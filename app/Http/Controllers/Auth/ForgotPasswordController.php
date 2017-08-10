<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mail;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;
use Illuminate\Support\Facades\Validator;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(Request $request) {
        
        $v = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($v->fails())
        {
             return response()->json(['error' => $v->errors()], 500);
        }

        try {
            $user = \App\User::where('email', $request->email)
                ->where('login_type', \Config::get('constants.loginTypes.EMAIL'))
                ->first();
            if($user != null) {
            $password = str_random(8);    
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->save();    

            $client = SesClient::factory(array(
                "credentials" => ['key' => env('SES_KEY', ''), 'secret' => env('SES_SECRET', '')],
                  'version'=> 'latest',
                  'region' => env('SES_REGION', '')
                ));

                $mail = array();
                $mail['Source'] = \Config::get('constants.email.FROM_ADDRESS');
                $mail['Destination']['ToAddresses'] = [$request->email];
                $mail['Message']['Subject']['Data'] = 'New password for Advts';
                $mail['Message']['Body']['Text']['Data'] = 'Your new password for advtr is '.$password;

                try {
                     $result = $client->sendEmail($mail);
                     return response()->json(['success' => 'Password sent successfully on your email'], 200);
                } catch (SesException $e) {
                      return response()->json(['error' => 'Email sending failed'], 500);
                }    
            } else {
                return response()->json(['error' => 'We are not able to find your email address'], 500);    
            }    
            

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'We are not able to find your email address'], 500);
        }
        
    }
}
