<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use App\User;
use Aws\S3\S3Client;

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
          
          $model = \App\User::findOrFail($userId, ['name', 'email', 'phone_no', 'profile_pic', 'date_of_birth']);
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
          //If image is present upload to S3
          if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageFileName = time().'_'.$userId . '.' . $image->getClientOriginalExtension();
           
            $s3 = new \Aws\S3\S3Client([
            'region'  => env('SES_REGION', ''),
            'version' => 'latest',
            'credentials' => [
                'key'    => env('SES_KEY', ''),
                'secret' => env('SES_SECRET', '')
            ]
            ]);

            // Send a PutObject request and get the result object.
            $result = $s3->putObject([
            'Bucket' => 'advtr',
            'Key'    => 'profile/'.$imageFileName,
            'ContentType' => $_FILES['image']['type'],
            'SourceFile'   => $image,
            'ACL'    => 'public-read'
            ]);
            $profilePic = $result['ObjectURL'];

          \App\User::where('id', $userId)
          ->update(['profile_pic' => $profilePic, 'name' => $request->name, 'phone_no' => $request->phone_no, 'date_of_birth' => $request->date_of_birth]);

          } else {

          \App\User::where('id', $userId)
          ->update(['name' => $request->name, 'phone_no' => $request->phone_no, 'date_of_birth' => $request->date_of_birth]);

          }

          $data = ['success' => 'Profile updated successfully'];
          return response()->json(['data' => $data], 200); 
          

        } catch(ModelNotFoundException $e) {
          return response()->json(['error' => 'Invalid user information'], 500);
        }   
    }
}
