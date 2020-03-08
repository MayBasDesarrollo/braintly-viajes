@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Vuelos Reservados</h1>


    @forelse ($reservations as $reservation)  
    
    <div class="card mb-4" style="max-height: 540px;">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">
                        {{$reservation->flight->departure_airport->location}} - 
                        {{$reservation->flight->arrival_airport->location}}
                    </h2>
                    <h5 class="card-title">
                        <p class="card-text"> 
                            {{$reservation->flight->departure_airport->iata_code}} <small class="text-muted">({{ $reservation->flight->dated }})</small> -
                            {{$reservation->flight->arrival_airport->iata_code}} <small class="text-muted">({{ $reservation->flight->datea }})</small>
                        </p>
                    </h5>
                    <p class="card-text">
                        <strong>Datos de Reserva</strong> 
                        <br>
                        <small class="text-muted">Nombre:</small> {{$reservation->name}}
                        <br>
                        <small class="text-muted">Email:</small> {{$reservation->email}}
                        <br>
                        <small class="text-muted">Status del vuelo:</small> {{ $reservation->flight->status }}
                        <br>
                        <small class="text-muted">Precio {{ $reservation->class ? 'Primera Clase' : 'Clase Economica' }}:</small> 
                        {{$reservation->price}}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-end mb-3">
                        @if ($reservation->flight->status == 'scheduled')
                            <form action="{{ route('reservation.delete', $reservation) }}" method="POST">
                                {{ method_field('DELETE') }}
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-danger" title="Eliminar">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @empty
    <p>No se encontraron reservaciones</p>
    @endforelse
    
    <div class="d-flex justify-content-center align-items-end mb-3">
        {{ $reservations->links() }}
    </div>

</div>
@endsection
