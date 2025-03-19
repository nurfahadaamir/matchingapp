@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Match Requests</h3>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#received">Requests Received</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#sent">Requests Sent</a>
        </li>
    </ul>
     
    <div class="tab-content">
        <div class="tab-pane fade show active" id="received">
            @foreach ($incomingRequests as $request)
                <p>{{ $request->sender->name }} wants to match with you.</p>
                <form action="{{ route('accept.match', $request->sender_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
                <form action="{{ route('decline.match', $request->sender_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Decline</button>
                </form>
            @endforeach
        </div>
        @if(auth()->user()->notifications->where('type', 'App\Notifications\MatchDeclinedNotification')->isNotEmpty())
    <div class="alert alert-danger">
        {{ auth()->user()->notifications->where('type', 'App\Notifications\MatchDeclinedNotification')->first()->data['message'] }}
    </div>
@endif


            @foreach ($sentRequests as $request)
                <p>Waiting for {{ $request->receiver->name }} to accept.</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
