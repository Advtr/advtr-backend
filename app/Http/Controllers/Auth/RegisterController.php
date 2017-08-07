<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mail;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;
use JWTAuth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function createUser(Request $request) {

        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'min:6',
            'login_type' => 'required'
        ]);

        if ($v->fails())
        {
             return response()->json(['error' => $v->errors()], 500);
        }

        try {
          \App\User::where('email', $request->email)->firstOrFail();
          return response()->json(['error' => 'User with this email is already registered'], 500);
        } catch (ModelNotFoundException $e) {

          try {
            $user = new \App\User();
            $user->email = $request->email;
            $digitsNeeded=4;

            $randomNumber=''; // set up a blank string

            $count=0;

            while ( $count < $digitsNeeded ) {
                $randomDigit = mt_rand(0, 9);
                
                $randomNumber .= $randomDigit;
                $count++;
            }
            $user->otp = $randomNumber;

            //For email
            if($request->login_type == \Config::get('constants.loginTypes.EMAIL')) {
              
              $user->password = password_hash($request->password, PASSWORD_BCRYPT);
              $user->login_type = \Config::get('constants.loginTypes.EMAIL');

            } else if ($request->login_type == \Config::get('constants.loginTypes.FACEBOOK') || $request->login_type == \Config::get('constants.loginTypes.TWITTER')){
              
              $user->social_media_id = $request->social_media_id;
              $user->login_type = $request->login_type;

            } else {
              return response()->json(['error' => 'No valid login type found'], 500);
            }
            

            if ($user->save()) {

              //Send email otp
              $client = SesClient::factory(array(
                "credentials" => ['key' => env('SES_KEY', ''), 'secret' => env('SES_SECRET', '')],
                  'version'=> 'latest',
                  'region' => env('SES_REGION', '')
              ));

              $mail = array();
              $mail['Source'] = \Config::get('constants.email.FROM_ADDRESS');
              $mail['Destination']['ToAddresses'] = [$request->email];
              $mail['Message']['Subject']['Data'] = 'OTP verification for Advts';
              $mail['Message']['Body']['Text']['Data'] = 'Your OTP for email verification is '.$randomNumber;

              try {
                   $result = $client->sendEmail($mail);
              } catch (SesException $e) {
                    return response()->json(['error' => 'Email sending failed'], 500);
              }

	            $token = JWTAuth::fromUser($user);
              $data = ['token' => $token, 'message' => 'Registration successful! Please check your email for OTP.', 'otp' => $randomNumber];

              return response()->json(['data' => $data], 200);
            } else {
              return response()->json(['error' => 'Error saving user'], 500);
            }
          } catch (QueryException $e) {
            return response()->json(['error' => 'Error saving user'], 500);
          } catch (\Exception $e) {
            return response()->json(['error' => 'Error saving user'], 500);
          }
        }
      }

      public function resendOTP() {
        
        $token = JWTAuth::parseToken()->getPayload();
        $userId = $token->get('sub');
        
        try {
          
          $model = \App\User::findOrFail($userId);

          //@todo send email
          $client = SesClient::factory(array(
                "credentials" => ['key' => env('SES_KEY', ''), 'secret' => env('SES_SECRET', '')],
                  'version'=> 'latest',
                  'region' => env('SES_REGION', '')
              ));

              $mail = array();
              $mail['Source'] = \Config::get('constants.email.FROM_ADDRESS');
              $mail['Destination']['ToAddresses'] = [$model->email];
              $mail['Message']['Subject']['Data'] = 'OTP verification for Advts';
              $mail['Message']['Body']['Text']['Data'] = 'Your OTP for email verification is '.$model->otp;

              try {
                   $result = $client->sendEmail($mail);
              } catch (SesException $e) {
                    return response()->json(['error' => 'Email sending failed'], 500);
              }

          $data = ['otp' => $model->otp, 'success' => 'OTP sent successfully'];  
          return response()->json(['data' => $data], 200); 

        } catch(ModelNotFoundException $e) {
          return response()->json(['error' => 'Invalid user information'], 500);
        }

      }

      public function verifyOTP(Request $request) {
        
        $v = Validator::make($request->all(), [
            'otp' => 'required'
        ]);

        if ($v->fails())
        {
             return response()->json(['error' => $v->errors()], 500);
        }

        $token = JWTAuth::parseToken()->getPayload();
        $userId = $token->get('sub');
        try {
          
          $model = \App\User::findOrFail($userId);  
          if($model->otp == $request->otp) {

            $returnToken = JWTAuth::fromUser($model);
            $data = ['success' => 'OTP confirmed successfully.', 'token' => $returnToken];
            return response()->json(['data' => $data], 500); 
          } else {
            return response()->json(['error' => 'Invalid OTP. Please try again'], 500); 
          }

        } catch(ModelNotFoundException $e) {
          return response()->json(['error' => 'Invalid user information'], 500);
        }
        
      }
}
