@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Available Matches in {{ request('state') }}</h2>

    @if($availableMatches->isEmpty())
        <p>No available matches found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Skim</th>
                    <th>Gred</th>
                    <th>Negeri</th>
                    <th>Fasiliti</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availableMatches as $match)
                    <tr>
                        <td>{{ $match->name }}</td>
                        <td>{{ $match->skim }}</td>
                        <td>{{ $match->gred }}</td>
                        <td>{{ $match->negeri }}</td>
                        <td>{{ $match->fasiliti }}</td>
                        <td>
                            <form action="{{ route('send.match.request', $match->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Match</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
