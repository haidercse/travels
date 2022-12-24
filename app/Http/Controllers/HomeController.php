<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\FlightClass;
use App\Models\Itinerarie;
use App\Models\Seat;
use App\Models\Segment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $all_flights = json_decode(file_get_contents(public_path() . "/file.txt"), true);
        $flights = $all_flights['flightOffer'];
        // dd($flights[0]);
        $segments  = count($flights[0]['itineraries'][0]);
        $classes  = count($flights[0]['class'][0]);
        $seats  = count($flights[0]['seat'][0]);
        $fareBasises  = count($flights[0]['fareBasis'][0]);
        dd($fareBasises);
        // $itineraries = [];
        foreach ($flights as $key => $flight) {
            $flight_model = new Flight();
            $flight_model->price = $flight['price'];
            $flight_model->save();

            for ($i = 0; $i < $segments; $i++) {
                $flight_itineraries = new Itinerarie();
                $flight_itineraries->flight_id = $flight_model->id;
                $flight_itineraries->duration = $flights[0]['itineraries'][0]['duration'];
                $flight_itineraries->save();
            }
            // foreach ($flight->itineraries as $key => $value) {
            //     $flight_itineraries = new Itinerarie();
            //     $flight_itineraries->flight_id = $flight_model->id;
            //     $flight_itineraries->duration = $value;
            //     $flight_itineraries->save();

            //     foreach ($value->segments as $key => $value) {
            //         $segment = new Segment();
            //         $segment->itineraries_id =  $flight_itineraries->id;
            //         $segment->marketingCarrier =  $flight_itineraries->id;
            //         $segment->carrierCode =  $flight_itineraries->id;
            //         $segment->flightNumber =  $flight_itineraries->id;
            //         $segment->aircraft =  $flight_itineraries->id;
            //         $segment->save();
            //     }
            // }

            for ($i = 0; $i < $classes; $i++) {
                $flight_class = new FlightClass();
                $flight_class->flight_id = $flight_model->id;
                $flight_class->name = $flights[0]['class'][0][$i];
                $flight_class->save();
            }
            for ($i = 0; $i < $seats; $i++) {
                $flight_class = new Seat();
                $flight_class->flight_id = $flight_model->id;
                $flight_class->seat_number = $flights[0]['class'][0][$i];
                $flight_class->save();
            }
        }
        return view('home');
    }
    public function store(Request $request)
    {
        if ($request->has('file')) {
            $image = $request->file('file');
            $reImage = 'file' . '.' . $image->getClientOriginalExtension();
            $dest = public_path('/');
            $image->move($dest, $reImage);
            // save in database
        }
        echo "OK";
    }
}
