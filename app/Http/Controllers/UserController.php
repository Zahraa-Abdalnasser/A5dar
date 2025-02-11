<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'description' => 'string',
        ]);

        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Customer registered successfully',
            'data' => $customer,
        ], 201);
    }

    
    
     public function login(Request $request)
     {
         // Validate the request 
         $validator = Validator::make($request->all(), [
             'email' => 'required|email',
             'password' => 'required|min:6',
         ]);
 
         if ($validator->fails()) {
             return response()->json(['errors' => $validator->errors()], 422);
         }
           

         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('API Token')->plainTextToken;
             return response()->json([
                 'message' => 'Login successful',
                 'user data' => $user, 
                 'token' => $token
                 ], 200);
         }
 
         return response()->json([
             'message' => 'Unauthanticated',
         ], 401);
     }
 
 
    

    
     
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,  $id)
    {
      //  $user = Auth::User();
      $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
        // Validate input fields
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,'. $user->id,
            'password' => 'sometimes|min:6',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user data if provided
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {    //
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle profile picture upload
        if ($request->hasFile('photo')) {
            // Delete the old photo if exists
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Store new photo
            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }
        if ($request->has('phone_number')){
            $user->phone_number = $request->phone_number; 
        }
        // Save user details
        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'photo' => $user->photo ? asset('storage/' . $user->photo) : null,
                'phone_number' => $user->phone_number
            ],
        ]);
    }


       


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }


}
