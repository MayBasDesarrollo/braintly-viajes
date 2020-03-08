<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\{Flight,Reservation};

class FlightController extends Controller
{
    public function index(Request $request) {

        // Para actualizar el status de los vuelos crearia un stored procedure, todo el desarrollo esta basado en 
        // que la actualización del los status del vuelo ya se realizan

        $flights = Flight::join('airplanes', 'airplanes.id', '=', 'flights.airplane_id')
                            ->leftJoinSub($this->countSeatsClass('0'), 're', function ($join) {
                                $join->on('flights.id', '=', 're.flight_id');
                            })
                            ->leftJoinSub($this->countSeatsClass('1'), 'rf', function ($join) {
                                $join->on('flights.id', '=', 'rf.flight_id');
                            })
                            ->select(
                                DB::raw('flights.*'),
                                DB::raw('coalesce((airplanes.economy_class_seats - re.cant ),airplanes.economy_class_seats) seats_remain_economy'),
                                DB::raw('coalesce((airplanes.first_class_seats - rf.cant),airplanes.first_class_seats) seats_remain_first')
                            )
                            ->with('departure_airport', 'arrival_airport', 'airplane')
                            ->whereDate('departure_date', '>=' , Carbon::now()->format('Y-m-d H:i:s'))
                            ->search(request('search'))
                            ->paginate(5);

        $flights->appends(request(['search']));
        $all_flight = true;

        return view('flights', compact('flights', 'all_flight'));
    }

    public function searchFlight(Request $request) {

        $data = request()->validate([
            'departure_airport_id' => ['present', Rule::exists('airports', 'id'),],
            'arrival_airport_id' => ['present',Rule::exists('airports', 'id'),],
            'departure_date' => 'date|after_or_equal:'.Carbon::now()->format('Y-m-d'),
        ]);

        $flights = Flight::join('airplanes', 'airplanes.id', '=', 'flights.airplane_id')
                            ->leftJoinSub($this->countSeatsClass('0'), 're', function ($join) {
                                $join->on('flights.id', '=', 're.flight_id');
                            })
                            ->leftJoinSub($this->countSeatsClass('1'), 'rf', function ($join) {
                                $join->on('flights.id', '=', 'rf.flight_id');
                            })
                            ->select(
                                DB::raw('flights.*'),
                                DB::raw('coalesce((airplanes.economy_class_seats - re.cant ),airplanes.economy_class_seats) seats_remain_economy'),
                                DB::raw('coalesce((airplanes.first_class_seats - rf.cant),airplanes.first_class_seats) seats_remain_first')
                            )
                            ->with('departure_airport', 'arrival_airport', 'airplane')
                            ->whereDate('departure_date', '=' , $data['departure_date'])
                            ->where('departure_airport_id', $data['departure_airport_id'])
                            ->where('arrival_airport_id', $data['arrival_airport_id'])
                            ->search(request('search'))
                            ->paginate(5);

        $flights->appends(request(['search']));
        $all_flight = false;

        return view('flights', compact('flights', 'all_flight'));
    }

    static public function countSeatsClass($class)
    {
        return Reservation::where('class', $class)->select('flight_id',DB::raw('COUNT(1) cant'))->groupBy('flight_id');
    }

}
