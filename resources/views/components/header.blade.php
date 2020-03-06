<header>
    <div class="header-search">
        <div class="search-box container">
            <form action="{{route('searchFlight')}}" method="GET">
                @csrf
                @method("GET")
                <h2>Encontrá tu viaje ideal</h2>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <select name="departure_airport_id" id="" class="form-control search-input">
                                <option value="" selected disabled>Salgo de...</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}">({{ $airport->iata_code }}) {{ $airport->location }} - {{ $airport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <select name="arrival_airport_id" id="" class="form-control search-input">
                                <option value="" selected disabled>Voy a...</option>
                                @foreach($airports as $airport)
                                    <option value="{{ $airport->id }}">({{ $airport->iata_code }}) {{ $airport->location }} - {{ $airport->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <input name="departure_date" type="date" class="form-control search-input" placeholder="Salida...">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" value="Buscar">
                        </div>
                    </div>
                </div>
            </form>

            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

            <div class="text-center">
                <a href="{{ route('flights') }}">Ver todos los vuelos disponibles</a>
            </div>
        </div>
    </div>
</header>
