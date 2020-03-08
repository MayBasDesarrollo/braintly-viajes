<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'flight_id', 'name', 'email', 'class',
    ];
    
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

}
