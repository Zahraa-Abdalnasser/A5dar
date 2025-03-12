<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\offer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderPlaced;
use App\Events\OrderResponse;
class OrderController extends Controller
{
    // Apply Sanctum authentication to all methods in this controller.
    /*
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    */
    /**
     * Store a new order for a given offer.
     * A user can only create one order per offer.
     *
     * Route: POST /api/orders  (or you can bind it as /api/offers/{offer}/orders)
     */
    public function store(Request $request, offer $offer)
{
    // Validate the incoming request data.
    $request->validate([
        'total_amount' => 'required|numeric',
        'to_city'      => 'required|string',
        'to_street'    => 'required|string',
        'order_price'  => 'required|numeric',
        'description'  => 'sometimes|string', 
    ]);

    // Check if the authenticated user is the owner of the offer.
    if ($offer->user_id === Auth::id()) {
        return response()->json(['error' => 'You cannot order your own offer'], 400);
    }

    // Ensure the offer is available for ordering.
    if ($offer->status !== 1) {
        return response()->json(['error' => 'Offer is not available for ordering'], 400);
    }

    // Check if an order already exists for this offer by the authenticated user.
    $existingOrder = Order::where('offer_id', $offer->id)
        ->where('user_id', Auth::id())
        ->first();

    if ($existingOrder) {
        return response()->json(['error' => 'You have already placed an order for this offer'], 400);
    }

    // Create the order.
    $order = Order::create([
        'user_id'      => Auth::id(),
        'offer_id'     => $offer->id,
        'total_amount' => $request->total_amount,
        'to_city'      => $request->to_city,
        'to_street'    => $request->to_street,
        'order_price'  => $request->order_price,
        'status'       => 'pending',
        'description' => $request->description,
    ]);
// Fire the event after order creation
event(new OrderPlaced($order,$offer));

    return response()->json($order, 201);
}


    /**
     * Update an existing order.
     * Only the owner of the order can update it.
     *
     * Route: PUT/PATCH /api/orders/{order}
     */
    public function update(Request $request, Order $order)
{
    if (Auth::id() !== $order->user_id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Validate only provided fields
    $validatedData = $request->validate([
        'total_amount' => 'sometimes|numeric',
        'to_city'      => 'sometimes|string',
        'to_street'    => 'sometimes|string',
        'order_price'  => 'sometimes|numeric',
        'status'       => 'sometimes|string|in:pending,processing,completed,cancelled',
    ]);

    \Log::info('Update Request Data:', $validatedData);

    // Ensure there's at least one field to update
    if (empty($validatedData)) {
        return response()->json(['error' => 'No valid fields provided for update'], 400);
    }

    // Force update and commit changes
    $order->fill($validatedData);
    $order->save();

    return response()->json(['message' => 'Order updated successfully', 'order' => $order], 200);
}




    /**
     * Delete an existing order.
     * Only the owner of the order can delete it.
     *
     * Route: DELETE /api/orders/{order}
     */
    public function destroy(Order $order)
    {
        // Check that the authenticated user is the owner.
        if (Auth::id() !== $order->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order->forceDelete();


        return response()->json(['message' => 'Order deleted successfully'], 204);
    }

    
    public function handleOrderDecision(Request $request, Order $order)
    {
        $request->validate([
            'decision' => 'required|in:accept,reject',
        ]);

        DB::transaction(function () use ($order, $request) {
            if ($request->decision === 'accept') {
                // Accept the order
                $order->status = 'accepted';
                $order->save();

                // Get the related offer
                $offer = $order->offer;

                // Reject all other orders for this offer
                Order::where('offer_id', $offer->id)
                    ->where('id', '!=', $order->id)
                    ->update(['status' => 'rejected']);

                // Mark offer as sold
                $offer->status = 0;
                $offer->save();
            } else {
                // Reject the order
                $order->status = 'rejected';
                $order->save();
            }
        });

        event(new OrderResponse($order));

        return response()->json([
            'message' => 'Order decision processed successfully',
            'order' => $order
        ]);
    }

    
}


