@extends('layouts.app')

@section('content')

<div class="hero hero-inner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mx-auto text-center">
          <div class="intro-wrap">
            <h1 class="mb-0">My Profile</h1>
            
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="container">
  

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-profile.png') }}" 
         alt="Profile Picture" 
         class="rounded-circle" width="150">

            <h3 class="mt-3">{{ Auth::user()->name }}</h3>

            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
            <p><strong>Skim:</strong> {{ Auth::user()->skim }}</p>
            <p><strong>Gred:</strong> {{ Auth::user()->gred }}</p>
            <p><strong>Fasiliti:</strong> {{ Auth::user()->fasiliti }}</p>
            <p><strong>Negeri:</strong> {{ Auth::user()->negeri }}</p>
            <p><strong>Jabatan:</strong> {{ Auth::user()->jabatan }}</p>
            <p><strong>Pengalaman:</strong> {{ Auth::user()->pengalaman }} years</p>
            <p><strong>Jenis Fasiliti:</strong> {{ Auth::user()->jenis_fasiliti }}</p>
    
            <a href="{{ url('/edit-profile') }}" class="btn btn-primary">Edit Profile</a>

            <!-- Let's Match Button -->
            @if(!Auth::user()->match_id)
            <button class="btn btn-success mt-3" data-toggle="modal" data-target="#matchModal">Let's Match</button>
             @endif


             @php
             use App\Models\UserMatch;

            $match = UserMatch::where('user_id', Auth::user()->id)->first();
            @endphp


@if($match)
    @php
        $matchedUser = App\Models\User::find($match->matched_user_id);
    @endphp

    <div class="alert alert-success">
        <h4>Matched with:</h4>
        <p><strong>Name:</strong> {{ $matchedUser->name }}</p>
        <p><strong>Negeri:</strong> {{ $matchedUser->negeri }}</p>
        <p><strong>Skim:</strong> {{ $matchedUser->skim }}</p>
        <p><strong>Gred:</strong> {{ $matchedUser->gred }}</p>
        <a href="mailto:{{ $matchedUser->email }}" class="btn btn-primary">Contact Match</a>

        <!-- Cancel Match Button -->
        <form action="{{ route('cancel.match') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger mt-2">Cancel Match</button>
        </form>
    </div>
@endif


        </div>
    </div>

 <!-- Match Modal -->
<div class="modal fade" id="matchModal" tabindex="-1" role="dialog" aria-labelledby="matchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Where do you want to transfer?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="matchForm">
                    @csrf
                    <label>Select State:</label>
                    <select name="preferred_state" class="form-control" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="findMatchBtn">Find Match</button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("findMatchBtn").addEventListener("click", function() {
    let selectedState = document.querySelector("select[name='preferred_state']").value;
    if (!selectedState) {
        alert("Please select a state.");
        return;
    }
    window.location.href = "{{ url('/find-match') }}?state=" + selectedState;
});
</script>


</div>
@endsection
