<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerarie extends Model
{
    use HasFactory;
    protected $fillable = ['flight_id','duration'];

    /**
     * Get all of the comments for the Itinerarie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function segments()
    {
        return $this->hasMany(Segment::class);
    }
    
}
