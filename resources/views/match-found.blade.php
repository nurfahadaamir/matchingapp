@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Match Found!</h2>
    <p>We found a match for your transfer request to {{ $preferredState }}!</p>

    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <img src="{{ $match->profile_picture ? asset('storage/' . $match->profile_picture) : asset('images/default-profile.png') }}" 
                 alt="Matched User Picture" 
                 class="rounded-circle" width="150">
            <h3 class="mt-3">{{ $match->name }}</h3>
            <p><strong>Skim:</strong> {{ $match->skim }}</p>
            <p><strong>Gred:</strong> {{ $match->gred }}</p>
            <p><strong>Current Location:</strong> {{ $match->fasiliti }}</p>

            <a href="mailto:{{ $match->email }}" class="btn btn-primary">Contact Match</a>
        </div>
    </div>
</div>
@endsection
