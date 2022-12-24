<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable= ['itineraries_id','price','fareBasis_id','class_id','seat_id'];
    /**
     * Get the user that owns the Flight
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function itineraries()
    {
        return $this->hasMany(Itinerarie::class,'flight_id','id');
    }
    public function classes()
    {
        return $this->hasMany(FlightClass::class);
    }
    public function seats()
    {
        return $this->hasMany(Seat::class,'flight_id','id');
    }
    public function fareBasises()
    {
        return $this->hasMany(FareBasis::class,'flight_id','id');
    }
}
