@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>No Match Found</h2>
    <p>Sorry, we couldn't find a match for your request to {{ $preferredState }}.</p>
    <a href="{{ url('/profile') }}" class="btn btn-secondary">Go Back</a>
</div>
@endsection
