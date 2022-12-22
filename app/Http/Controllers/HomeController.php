<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $all_flights = json_decode(file_get_contents(public_path() . "/file.txt"), true);
        $flights = $all_flights['flightOffer'];
        $itineraries = [];
        foreach ($flights as $key => $flight) {
           foreach( $flight->itineraries as $f_itinerarie){
             
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
