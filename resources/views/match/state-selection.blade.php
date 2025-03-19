@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Select Your Preferred Transfer State</h2>

    <form action="{{ route('available.matches') }}" method="GET">
        @csrf
        <div class="form-group">
            <label for="state">Choose a State:</label>
            <select id="state" name="state" class="form-control" required>
                <option value="">Choose a state</option>
                <option value="Johor">Johor</option>
                <option value="Kedah">Kedah</option>
                <option value="Kelantan">Kelantan</option>
                <option value="Melaka">Melaka</option>
                <option value="Negeri Sembilan">Negeri Sembilan</option>
                <option value="Pahang">Pahang</option>
                <option value="Penang">Penang</option>
                <option value="Perak">Perak</option>
                <option value="Perlis">Perlis</option>
                <option value="Sabah">Sabah</option>
                <option value="Sarawak">Sarawak</option>
                <option value="Selangor">Selangor</option>
                <option value="Terengganu">Terengganu</option>
                <option value="WP Kuala Lumpur">WP Kuala Lumpur</option>
                <option value="WP Labuan">WP Labuan</option>
                <option value="WP Putrajaya">WP Putrajaya</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Continue</button>
    </form>
</div>

@endsection
