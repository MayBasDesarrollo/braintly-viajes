<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Reservation;
use App\Http\Requests\ReservationCreateRequest;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {

        $reservations = Reservation::paginate(5);

        return view('reservation.index', compact('reservations'));

    }

    public function create(Flight $flight)
    {
        return view('reservation.create', compact('flight'));
    }

    public function store(ReservationCreateRequest $request)
    {
        
        $flight = Flight::join('airplanes', 'airplanes.id', '=', 'flights.airplane_id')
                        ->leftJoinSub(FlightController::countSeatsClass('0'), 're', function ($join) {
                            $join->on('flights.id', '=', 're.flight_id');
                        })
                        ->leftJoinSub(FlightController::countSeatsClass('1'), 'rf', function ($join) {
                            $join->on('flights.id', '=', 'rf.flight_id');
                        })
                        ->select(
                            'flights.status',
                            DB::raw('coalesce((airplanes.economy_class_seats - re.cant ),airplanes.economy_class_seats) seats_remain_economy'),
                            DB::raw('coalesce((airplanes.first_class_seats - rf.cant),airplanes.first_class_seats) seats_remain_first')
                            )
                            ->with('departure_airport', 'arrival_airport', 'airplane')
                            ->where('flights.id', '=' , $request->flight_id)
                            ->first();

        if ($request->class) {
            if ($flight->seats_remain_first == 0) {
                return redirect()->back()->with("error","No se encuentran asientos disponibles para la primera clase.");
            }
        }else{
            if ($flight->seats_remain_economy == 0) {
                return redirect()->back()->with("error","No se encuentran asientos disponibles para la clase economica.");
            }
        }

        if ($flight->status != 'scheduled') {
            return redirect()->back()->with("error","El vuelo se encuentra con el status {$flight->status}, por lo tanto no puede realizar reservaciones.");
        }

        $request->createReservation();
        
        return redirect()->route('reservation.index');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservation.index');
    }
}
