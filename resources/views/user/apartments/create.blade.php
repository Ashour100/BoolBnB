@extends('layouts.app')

@section('content')
<div class="container create-container mt-1 w-50">
    <h1 class="text-center">
        Aggiungi un nuovo Appartamento
    </h1>
    <form class="row mt-4 g-3" action="{{route("apartment.store")}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row apartment">
            <div class="col-12">
                <label for="title">Titolo</label>
                <input class="w-100" type="text" name="title" id="title" value="{{ old('title') ?? ''}}" required>
                @error('title')
                        <div class="alert alert-danger mt-2">
                            Il titolo
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="image">Carica la foto cover:</label>
                <input type="file" name="image" id="image">
                @error('image')
                        <div class="alert alert-danger mt-2">
                            L'immagine
                            {{ $message }}
                        </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="description">Descrizione</label>
                <textarea class="w-100" name="description" id="description">{{ old('description') ?? ''}}</textarea required>
                @error('description')
                    <div class="alert alert-danger mt-2">
                        La descrizione
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="n_rooms">Numero di stanze:</label>
                <input type="number" name="n_rooms" id="n_rooms" value="{{ old('n_rooms') ?? ''}}" required>
                @error('n_rooms')
                    <div class="alert alert-danger mt-2">
                        IL numero di stanze
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="n_bedrooms">Numero di stanze da letto:</label>
                <input type="number" name="n_bedrooms" id="n_bedrooms" value="{{ old('n_bedrooms') ?? ''}}" required>
                @error('n_bedrooms')
                    <div class="alert alert-danger mt-2">
                        Il numero di stanze da letto
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="n_bathrooms">Numero di bagni:</label>
                <input type="number" name="n_bathrooms" id="n_bathrooms" value="{{ old('n_bathrooms') ?? ''}}" required>
                @error('n_bathrooms')
                    <div class="alert alert-danger mt-2">
                        Il numero di bagni
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="guests">Numero massimo di ospiti:</label>
                <input type="number" name="guests" id="guests" value="{{ old('guests') ?? ''}}" required>
                @error('guests')
                    <div class="alert alert-danger mt-2">
                        Il numero massimo di ospiti
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="n_beds">Numero di letti:</label>
                <input type="number" name="n_beds" id="n_beds" value="{{ old('n_beds') ?? ''}}" required>
                @error('n_beds')
                    <div class="alert alert-danger mt-2">
                        Il numero di letti
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="visible">Spuntare la seguente checkbox per rendere l'appartamento visibile </label>
                <input type="checkbox" name="visible" id="visible" checked=true>
            </div>
            <div class="col-12">
                <label for="available">Spuntare la seguente checkbox per rendere l'appartamento disponibile </label>
                <input type="checkbox" name="available" id="available" checked=true>
            </div>
            <div class="col-12">
                <label for="price">Inserisci il prezzo a notte per ospite: </label>

                <input type="number" name="price" id="price" value="{{ old('price') ?? ''}}" required>
                @error('price')
                    <div class="alert alert-danger mt-2">
                        Il prezzo
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-12">
                <label for="square_meters">Numero di metri quadrati: </label>
                <input type="number" name="square_meters" id="square_meters" value="{{ old('square_meters') ?? ''}}">
            </div>
            <div class="col-12">
                <label for="address">inserisci la via:</label>
                <input class="w-100" type="text" name="address" id="address" value="{{ old('address') ?? ''}}" required>
                @error('address')
                    <div class="alert alert-danger mt-2">
                        Il nome della via
                        {{ $message }}
                    </div>
                @enderror
                    <ul class="list-group" id="results">
                        <li class="list-group-item active d-none" id="1-result"></li>
                        <li class="list-group-item active d-none" id="2-result"></li>
                        <li class="list-group-item active d-none" id="3-result"></li>
                        <li class="list-group-item active d-none" id="4-result"></li>
                        <li class="list-group-item active d-none" id="5-result"></li>
                    </ul>
            </div>

            <div class="col-12 mb-3">
                <label for="address_city">Servizi:</label><br>
                <div class="servizi d-flex flex-column flex-wrap">
                    @foreach ($services as $service)
                        <div class="service">
                            <input class="form-check-input" type="checkbox"
                            name="service[]" value="{{$service->id}}"
                            {{ (is_array(old('service')) and in_array($service->id, old('service'))) ? ' checked' : '' }}>
                            <label for="categories">
                                {{$service->name}}
                            </label>
                        </div>
                    @endforeach
                    @error('service')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="col-12">
                    <label for="image[]">inserisci altre foto del tuo appartamento</label>
                    <input type="file" class="form-control" name="images[]" id="image[]"  multiple>
                </div>
            </div>

            {{-- @foreach ($sponsorships as $sponsorship)
                <div class="col-12">
                    <label for="sponsorship">{{$sponsorship->name}}</label>
                    <input type="radio" name="sponsorship" id="sponsorship" value="{{$sponsorship->id}}">
                </div>
            @endforeach --}}

            <div class="col-12 text-center mt-3">
                <button class="btn btn-outline-primary" type="submit">send</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('footer-scripts')
    <script src="{{ asset('js/tipsAddress.js') }}"></script>
@endsection
