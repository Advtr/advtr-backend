<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    public function index(Request $request) {



        $data = array(array('category' => 'Handcrafted', 'items' => array(array(
                    'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
                                                    'price' => '$1500',
                                                    'name' => 'Positano'
                    ),
                array(                              'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-2.jpg',
                                                    'price' => '$1500',
                                                    'name' => 'Positano'
                      ),
                array(                             'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-3.jpg',
                                                    'price' => '$1500',
                                                    'name' => 'Positano'),
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-4.jpg',
                                                    'price' => '$1500',
                                                    'name' => 'Positano')
                )
            ),
                        array('category' => 'Featured', 'items' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-2.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-3.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-4.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'))
                        ),
                        array('category' => 'Most Visited', 'items' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array( 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-2.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-3.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-4.jpg',
                                                                'price' => '$1500',
                                                                'name' => 'Positano'))),
                        array('category' => 'Recent', 'items' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
                                                            'price' => '$1500',
                                                            'name' => 'Positano'), 
                array( 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-2.jpg',
                                                            'price' => '$1500',
                                                            'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-3.jpg',
                                                            'price' => '$1500',
                                                            'name' => 'Positano'), 
                array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-4.jpg',
                                                            'price' => '$1500',
                                                            'name' => 'Positano'))));
  
        return response()->json(['data' => $data], 200);    
    }

    public function detail(Request $request) {
     $data = array('name' => 'Hike Antelope Canyon', 
                   'picture' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/main.jpg', 
                   'price' => '$200', 
                   'curated_by' => 'Derek', 
                   'curated_by_picture' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/profile-1.jpeg', 
                   'latitude' => '72.123546', 
                   'longitude' => '78.123546', 
                   'description' => 'Take a 3 mile hike through slot canyons.  Easily walkable, but please wear closed toe shoes.Easily walkable, but please wear closed toe shoes',
                   'reviews' => array(array('user_name' => 'John', 'user_pic' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/profile-2.jpg', 'review' => 'I just loved this trip.  To see the power of water and wind to carve these canyons.  The Navajo are wonderful guides.'), 
                    array('user_name' => 'Mike', 'user_pic' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/profile-3.jpg', 'review' => 'We spent 4 nights at the Aria Hotel after a transatlantic flight from Miami. We have been to many places throughout the world, including to the sister hotels in NYC, but found the Aria to be one of the most interesting. The theme and the architecture were unique and very well done. Our room was comfortable and well appointed with the musical theme continued in the room. The service was excellent. The wine and cheese offered in the late afternoon was very pleasant. The breakfasts were a bit disorganized, but the food was good. The roof bar was just beautiful and comfortable. Appetizers there were among the best we have ever had. The Danube Bend Tour was only OK and probably over priced. Overall, it was a great experience.'),
                    array('user_name' => 'Harry', 'user_pic' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/profile-4.jpg', 'review' => 'This Aria Hotel Budapest hotel is the best hotel in Hungary . All types of facilities are available here . Travellers can access free wifi in this Aria Hotel Budapest hotel . Best qualities of services are available here.'))
     );   
     return response()->json(['data' => $data], 200);       
    }
}