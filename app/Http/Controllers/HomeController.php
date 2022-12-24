<?php

namespace App\Http\Controllers;

use App\Models\Arrival;
use App\Models\Departure;
use App\Models\FareBasis;
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

        foreach ($flights as $flight) {

            $flight_model = new Flight();
            $flight_model->price = $flight['price'];
            $flight_model->save();

            foreach ($flight['itineraries'] as $flight_itineraries) {
                $itineraries = new Itinerarie();
                $itineraries->flight_id = $flight_model->id;
                $itineraries->duration = $flight_itineraries['duration'];
                $itineraries->save();

                foreach ($flight_itineraries['segments'] as $key => $segment) {

                    $segment_model = new Segment();
                    $segment_model->itineraries_id = $itineraries->id;
                    $segment_model->marketingCarrier = $segment['marketingCarrier'];
                    $segment_model->carrierCode = $segment['carrierCode'];
                    $segment_model->flightNumber = $segment['flightNumber'];
                    $segment_model->aircraft = $segment['aircraft'];
                    $segment_model->save();

                    foreach ($segment['departure'] as $key => $departure) {
                        $departure = new Departure();
                        $departure->segment_id = $segment_model->id;
                        $departure->iataCode = $segment['departure']['iataCode'];
                        $departure->at = $segment['departure']['at'];
                        $departure->save();
                    }
                    foreach ($segment['arrival'] as $key => $arrival) {
                        $arrival = new Arrival();
                        $arrival->segment_id = $segment_model->id;
                        $arrival->iataCode = $segment['arrival']['iataCode'];
                        $arrival->at = $segment['arrival']['at'];
                        $arrival->save();
                    }
                }
            }

            foreach ($flight['fareBasis'] as $key => $fareBasis) {

                foreach ($fareBasis as $f_basis) {
                    $fareBasis = new FareBasis();
                    $fareBasis->flight_id = $flight_model->id;
                    $fareBasis->name = $f_basis;
                    $fareBasis->save();
                }
            }

            foreach ($flight['class'] as $key => $f_val) {
                foreach ($f_val as $f_class) {
                    $classes = new FlightClass();
                    $classes->flight_id = $flight_model->id;
                    $classes->name = $f_class;
                    $classes->save();
                }
            }
            foreach ($flight['seat'] as $key => $f_val) {
                foreach ($f_val as $f_seat) {
                    $seat = new Seat();
                    $seat->flight_id = $flight_model->id;
                    $seat->seat_number = $f_seat;
                    $seat->save();
                }
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