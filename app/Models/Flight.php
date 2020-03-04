<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    //

    public function departure_airport()
    {
        return $this->belongsTo(Airport::class);
    }

    public function arrival_airport()
    {
        return $this->belongsTo(Airport::class);
    }

    public function airplane()
    {
        return $this->belongsTo(Airplane::class);
    }

    public function scopeSearch($query, $search)
    {
        $query->when($search, function($query, $search){
            $query->where('departure_airport_id', $search)
                ->orWhere('arrival_airport_id', $search);
        });
    }

    public function getPriceeAttribute()
    {
        $price = $this->base_price + ($this->base_price * (1/$this->airplane->economy_class_seats));

        $price = round($price , 2);

        return $price;      
    }

    public function getPricefAttribute()
    {
        $price = ($this->pricee * 160)/100;

        $price = round($price , 2);

        return $price;      
    }
}
