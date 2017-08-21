<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\User;


class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function getProfile() {

        $token = JWTAuth::parseToken()->getPayload();
        $userId = $token->get('sub');
        try {
          
          $model = \App\User::findOrFail($userId, ['name', 'email', 'phone_no', 'profile_pic']);
          return response()->json(['data' => $model], 200); 

        } catch(ModelNotFoundException $e) {
          return response()->json(['error' => 'Invalid user information'], 500);
        }
    }

    public function updateProfile(Request $request) {

        $v = Validator::make($request->all(), [
            'date_of_birth' => 'nullable|date',
            'phone_no' => 'numeric'
        ]);

        if ($v->fails())
        {
             return response()->json(['error' => $v->errors()->first()], 500);
        }

        $token = JWTAuth::parseToken()->getPayload();
        $userId = $token->get('sub');

        try {

          \App\User::where('id', $userId)
          ->update(['name' => $request->name, 'phone_no' => $request->phone_no, 'date_of_birth' => $request->date_of_birth]);

          return response()->json(['success' => 'Profile updated successfully'], 200); 

        } catch(ModelNotFoundException $e) {
          return response()->json(['error' => 'Invalid user information'], 500);
        }   
    }
}
