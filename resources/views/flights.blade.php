@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Lista de vuelos</h1>

    <div class="d-flex">
        <div class="ml-auto p-2">
            <form method="get" action="{{ url('flights') }}">
                @csrf
                <div class="input-group">
                    <select class="custom-select" name="search">
                        <option value="" selected disabled>Busca tu aeropuerto...</option>
                        @foreach($airports as $airport)
                            <option value="{{ $airport->id }}">({{ $airport->iata_code }}) {{ $airport->location }} - {{ $airport->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary" type="button">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @forelse ($flights as $flight)  
    <div class="card mb-4" style="max-height: 540px;">
        <div class="row no-gutters">
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title">{{$flight->departure_airport->location}} - {{$flight->arrival_airport->location}}</h2>
                    <h5 class="card-title">{{$flight->departure_airport->iata_code}} - {{$flight->arrival_airport->iata_code}}</h5>
                    <p class="card-text">Seats Available: First Class 12 / Economy Class 25</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-body">
                    <h5 class="card-title">
                        <button type="button" class="btn btn-link">First Class</button>
                        ${{$flight->pricef}}
                    </h5>
                    <h5 class="card-title">
                        <button type="button" class="btn btn-link">Economy Class</button>
                        ${{$flight->pricee}}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    
    @empty
    <p>No se encontraron vuelos disponibles</p>
    @endforelse
    
    {{-- {{ $flights->links() }} --}}

</div>
@endsection
