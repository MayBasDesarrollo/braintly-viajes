<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Airport,Flight};

class FlightController extends Controller
{
    public function index(Request $request) {

        $airports = Airport::orderBy('location')->get();

        $flights = Flight::where('status', 'scheduled')
                    ->with('departure_airport', 'arrival_airport', 'airplane')
                    ->search(request('search'))
                    // ->paginate(5);
                    ->get();

        // $flights->appends(request(['search']));
        //$all_flight = true;

        return view('flights', compact('flights', 'airports'));
    }

    public function searchFlight(Request $request) {

        //CONDICIONES DE QUE INGRESE TODO LOS DATOS

        $airports = Airport::orderBy('location')->get(); //mover esto a un solo lugar para no duplicar codigo

        $flights = Flight::where('status', 'scheduled')
                    ->with('departure_airport', 'arrival_airport', 'airplane')
                    ->search(request('search'))
                    ->where(
                        ['departure_airport_id', request()->get('departure_airport_id')],
                        ['arrival_airport_id', request()->get('arrival_airport_id')],
                        // AGREGAR FECHA
                    )
                    ->get();

        // $flights->appends(request(['search']));
        // $all_flight = false;

        return view('flights', compact('flights', 'airports'));
    }
}
