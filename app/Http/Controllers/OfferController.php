<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\offer;
use App\Models\User;

class OfferController extends Controller
{
   
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $offers = offer::with(['user:id,name,photo'])->get(); // جلب بيانات المستخدم مع الصورة

    return response()->json($offers);
}


    /**
     * Store a newly created resource in storage.
     */
   
        public function store(Request $request)
        {
            $request->validate([
                'offer_name' => 'required|string|max:255',
                'amount' => 'required|numeric',
                'unit_price' => 'required|numeric', 
                'status' => 'required|numeric|min:0',
                'unit_id' => 'required|exists:units,id',
                'cat_id' => 'required|exists:categories,id',
                'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            // Get the authenticated user
            $user = auth()->user();
            $imagePath = $request->file('image_path')->store('offers', 'public');

            // Create an offer linked to the logged-in user
            $offer = $user->offers()->create([
                'offer_name' => $request->offer_name,
                'amount' => $request->amount,
                'unit_price' => $request->unit_price,
                'status' => $request->status,
                'unit_id' => $request->unit_id,
                'cat_id' => $request->cat_id, 
                'image_path' => $imagePath,
                'user_id' => auth()->id(), // Get the logged-in user’s ID
               // 'custome_user_id' => $user->id,       
            ]);
         // $image_url =  asset('storage/' . $image->image_path);
            return response()->json([
                'message' => 'Offer created successfully',
                'offer' => $offer

            ], 201);
        }
    

    // GET /products/{id} - Fetch a single product by ID
    // Display the specified resource.

    public function show($id)
    {
        $product = offer::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product, 200);
    }

   
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        \Log::info('Request Data:', $request->all());
    
        $product = offer::find($id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // تحقق من وجود صورة جديدة وحذف الصورة القديمة إذا وجدت
        if ($request->hasFile('image_path')) {
            $request->validate([
                'image_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            // حذف الصورة القديمة من التخزين
            if ($product->image_path) {
                \Storage::disk('public')->delete($product->image_path);
            }
    
            // تخزين الصورة الجديدة
            $imagePath = $request->file('image_path')->store('offers', 'public');
            $product->image_path = $imagePath;
        }
    
        // تحديث باقي البيانات
        $validated = $request->validate([
            'offer_name' => 'string|max:255',
            'amount' => 'sometimes|numeric|min:1',
            'unit_price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|numeric',
            'unit_id' => 'sometimes|exists:units,id',
            'cat_id' => 'sometimes|exists:categories,id',
        ]);
    
        $product->update($validated);
        $product->save();
    
        return response()->json($product, 200);
    }
    
    
 
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(offer $offer)
    {
          // Find the product by ID
          if (Auth::id() !== $offer->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Delete the offer
        $offer->delete();
    
        return response()->json(['message' => 'Offer deleted successfully'], 200);
    }
}
