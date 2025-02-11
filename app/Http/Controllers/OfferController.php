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
        return offer::all();
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
    public function update(Request $request,$id)
    {
        \Log::info('Request Data:', $request->all());
        // Find the product by ID
         $product = offer::find($id);

         if (!$product) {
             return response()->json(['message' => 'Product not found'], 404);
         }
 
         // Validate the incoming request
         $validated = $request->validate([
        'offer_name' => 'string|max:255',
        'amount' => 'sometimes|numeric|min:1',
        'unit_price' => 'sometimes|numeric|min:0',
        'status' => 'sometimes|numeric',
        'unit_id' => 'sometimes|exists:units,id',
        'cat_id' => 'sometimes|exists:categories,id',
        'image_path' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
         ]);
         
          //  $product->offer_name = $request->offer_name;
            $product->update($validated);
            $product->save();
       //  return response()->json(['name'=> $product->offer_name]); 
        
         // Update the product
         // $product->update($validated);
         // $product->fill($validated);
         return response()->json($product, 200); // Return the updated product
     }
 
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          // Find the product by ID
          $product = offer::find($id);

          if (!$product) {
              return response()->json(['message' => 'Product not found'], 404);
          }
  
          // Delete the product
          $product->delete();
  
          return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
