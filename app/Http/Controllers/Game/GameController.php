<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

class GameController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    public function getPhotos(Request $request) {

        $data = [
                 ['name' => 'Grand Canyon Nationalpark', 'description' => ' The Skywalk is not located in the Grand Canyon National Park but on the West Rim (about 200 km from Las Vegas).', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/grand-canyon.jpg'], 
                 ['name' => 'Bellagio, Las Vegas ', 'description' => 'The infamous Bellagio Las Vegas is the only hotel to appear on Instagrams top 20 list, which is no small feat. Dont miss the nightly fountain show; its a true Vegas spectacle.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image3.png'], 
                 ['name' => 'The Dubai Mall, Dubai ', 'description' => 'If you build a shopping mall, they will come — and they will take pictures and post them on the internet. Dubais massive shopping plaza (its the size of 50 football fields) boasts some 1,200 shops, a 250-room luxury hotel, 120 restaurants, an aquarium and underwater zoo, an ice rink, and a theme park. Boredom is not a thing here.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image4.png'], 
                 ['name' => 'Piazza Duomo, Milan, Italy', 'description' => 'Milans wondrous Duomo Cathedral is the focal point of this popular public square, which houses an array of cultural attractions and monuments. Its no wonder people love taking photos of it.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image5.png'],
                 ['name' => 'Estadio Santiago Bernabéu, Madrid', 'description' => 'Madrids Estadio Santiago Bernabéu stadium is a frequent check-in point among football fans. Opened in 1947, it holds a whopping 85,000 people and remains one of the worlds most prestigious football venues.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image6.png'], 
                 ['name' => 'Piazza San Marco, Venice, Italy', 'description' => 'The most famous public square in a country thats famous for its public squares. Piazza San Marco (known simply as "the Piazza") houses charming open-air cafes overlooking some of Italys most remarkable ancient structures, including St. Marks Basilica. Watch out for the birds!', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image7.png'], 
                 ['name' => 'Colosseum, Rome', 'description' => 'Romes Colosseum is among the most recognizable (and most ancient) attractions in the world. Thats enough of a reason to pause for a photo opp, but the fact that it is truly spectacular doesnt hurt, either. We love the way this grammer chose to do something a little different.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image8.png'], 
                 ['name' => 'Wrigley Field, Chicago ', 'description' => 'How gorgeous is Chicagos Wrigley Field at sunset? (And who wouldve guessed that Instagrams most geotagged locations would include not one but two American baseball stadiums?)', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image9.png'],
                 ['name' => 'Nevsky Prospect, Saint Petersburg, Russia', 'description' => 'St. Petersburgs main thoroughfare remains one of the top snapped spots in the world, with most of the citys best restaurants and shops clustered right on (or right off) the main drag.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image10.png'], 
                 ['name' => 'Golden Gate Bridge, San Francisco', 'description' => 'Seeing snaps of the Golden Gate Bridge in San Francisco never gets old. We love the way this one juxtaposes the bright bridge and blue sky against the heavy fog.', 'image' => 'https://s3-us-west-2.amazonaws.com/advtr/listing-images/image11.png']
                 ];

        
        return response()->json(['data' => $data], 200);    
    }

    
}