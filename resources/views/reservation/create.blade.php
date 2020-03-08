@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Reservación de vuelo</h1>
    <div class="d-flex justify-content-center  mb-3">
        <div class="card col-md-8">
            <div class="card-body">

                <form method="POST" action="{{ url('reservation') }}">
                    {{ csrf_field() }}
                    <div class="card card-body text-center mb-3">

                        <h2 class="card-title">
                            {{$flight->departure_airport->location}} - {{$flight->arrival_airport->location}}
                        </h2>
                        <h5 class="card-title">
                            <p class="card-text"> 
                                {{$flight->departure_airport->iata_code}} <small class="text-muted">({{ $flight->dated }})</small> -
                                {{$flight->arrival_airport->iata_code}} <small class="text-muted">({{ $flight->datea }})</small>
                            </p>
                        </h5>


                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" id="firstClass" value="1" checked>
                            <label class="form-check-label" for="firstClass">
                                <p class="card-text"><small class="text-muted">Primera Clase:</small> ${{$flight->pricef}} </p>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="class" id="economyClass" value="0">
                            <label class="form-check-label" for="economyClass">
                                <p class="card-text"><small class="text-muted">Clase Economica:</small> ${{$flight->pricee}} </p>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" @if ($errors->has('name') ) class="form-control is-invalid" @else class="form-control" @endif id="name" placeholder="Nombre" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name') )
                            <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" @if ($errors->has('email') ) class="form-control is-invalid" @else class="form-control" @endif id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                        @if ($errors->has('email') )
                            <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <input type="hidden" name='flight_id' value="{{$flight->id}}">
                    <input type="hidden" name='pricef' value="{{$flight->pricef}}">
                    <input type="hidden" name='pricee' value="{{$flight->pricee}}">
                    <div class="d-flex justify-content-center align-items-end mb-3">
                        <button type="submit" class="btn btn-success">Reservar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection