@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Lista de vuelos</h1>

    
    <div class="d-flex">
        
    </div>

    <div class="d-flex justify-content-between align-items-end mb-3">
        <h1 class="">
            <a class="btn btn-outline-warning" href="{{ route('reservation.index') }}" role="button">Reservaciones</a>
        </h1>
        <p>
            <div class="ml-auto p-2">
                <form method="get" action="{{ $all_flight == true ? route('flights') : route('searchFlight')}}">
                    @csrf
                    <div class="input-group">
                        <select class="custom-select" name="search">
                            <option value="" selected disabled>Busca tu aeropuerto...</option>
                            @foreach($airports as $airport)
                            <option value="{{ $airport->id }}"{{ old('search') == $airport->id ? ' selected' : '' }}>
                                ({{ $airport->iata_code }}) {{ $airport->location }} - {{ $airport->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" type="button">Filtrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </p>
    </div>
     
    @forelse ($flights as $flight)  
    <div class="card mb-4" style="max-height: 540px;">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">
                        {{$flight->departure_airport->location}} - {{$flight->arrival_airport->location}}
                    </h2>
                    <h5 class="card-title">
                        <p class="card-text"> 
                            {{$flight->departure_airport->iata_code}} <small class="text-muted">({{ $flight->dated }})</small> -
                            {{$flight->arrival_airport->iata_code}} <small class="text-muted">({{ $flight->datea }})</small>
                        </p>
                    </h5>
                    <p class="card-text">
                        Asientos Disponibles: 
                        <small class="text-muted">Primera Clase:</small>{{$flight->seats_remain_first}} / 
                        <small class="text-muted">Clase Economica:</small> {{$flight->seats_remain_economy}}
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <p class="card-text"><small class="text-muted">Primera Clase:</small> ${{$flight->pricef}} </p>
                    </h5>
                    <h5 class="card-title">
                        <p class="card-text"><small class="text-muted">Clase Economica:</small> ${{$flight->pricee}} </p>
                    </h5>
                    <div class="d-flex justify-content-center align-items-end mb-3">
                        <a class="btn btn-success" href="{{ route('reservation.create', $flight) }}" role="button">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @empty
    <p>No se encontraron vuelos disponibles</p>
    @endforelse
    
    <div class="d-flex justify-content-center align-items-end mb-3">
        {{ $flights->links() }}
    </div>

</div>
@endsection
