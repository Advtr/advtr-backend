<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        /*$token = JWTAuth::parseToken()->getPayload();
        print_r($token->get('sub'));exit;
        $result = false;*/
        $credentials = '';

        //Check email and password if login type is email
        if($request->login_type == \Config::get('constants.loginTypes.EMAIL')) {
            
            $check = \Auth::attempt(array('email' => $request->email, 'password' => $request->password));
            
            if($check == true) {
                $credentials = \Auth::id();    
                $result = \App\User::where('id', $credentials)->first();
            }
            
        //Check id if login type is facebook or twitter    
        } else if ($request->login_type == \Config::get('constants.loginTypes.FACEBOOK') || $request->login_type == \Config::get('constants.loginTypes.TWITTER')){

            $result = \App\User::where('social_media_id', $request->social_media_id)
            ->where('login_type', $request->login_type)->first();

            if($result != null) {
                $credentials = $result->id;
            }    
      
        } else {
          return response()->json(['error' => 'No valid login type found'], 500);
        }

        if($result != false || $result != null) {

           $token = JWTAuth::fromUser($result);
           $data = ['success' => 'Login successful', 'token' => $token, 'is_verified' => $result->is_verified];
           return response()->json(['data' => $data]);

        } else {
           return response()->json(['error' => 'Please make sure your login details are correct'], 500);    
        }
    
    }
}