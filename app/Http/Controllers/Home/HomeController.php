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

/*
        $data = array(
                'data' => array('Handcrafted' => array(array(
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
                ), 'Featured' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
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
                                                                'name' => 'Positano')), 
                'Most Visited' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
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
                                                                'name' => 'Positano')), 
                'Recent' => array(array('image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image-1.jpg',
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
                                                            'name' => 'Positano')) )
            );
        print_r($data);exit;
      */  
        return response()->json(['data' => $data], 200);    
    }
}