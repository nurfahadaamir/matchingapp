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
            <!-- Profile Picture -->
            @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
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
                <button class="btn btn-success mt-3" data-toggle="modal" data-target="#eligibilityModal">Let's Match</button>
            @endif

            @if(Auth::user()->match_id)
    @php
        $matchedUser = App\Models\User::find(Auth::user()->match_id);
    @endphp

    @if($matchedUser)
        <div class="alert alert-success">
            <h4>Matched with:</h4>
            <p><strong>Name:</strong> {{ $matchedUser->name }}</p>
            <p><strong>Negeri:</strong> {{ $matchedUser->negeri }}</p>
            <p><strong>Skim:</strong> {{ $matchedUser->skim }}</p>
            <p><strong>Gred:</strong> {{ $matchedUser->gred }}</p>
            <p><strong>Fasiliti:</strong> {{ $matchedUser->fasiliti }}</p>
            <p><strong>Jabatan:</strong> {{ $matchedUser->jabatan }}</p>
            <a href="mailto:{{ $matchedUser->email }}" class="btn btn-primary">Contact Match</a>

            <form action="{{ route('cancel.match') }}" method="POST" class="d-inline">
                @csrf
           <button type="submit" class="btn btn-danger mt-2">Cancel Match</button>
           </form>

        </div>
    @endif
@endif

        </div>
    </div>
</div>

<!-- Eligibility Modal -->
<div class="modal fade" id="eligibilityModal" tabindex="-1" role="dialog" aria-labelledby="eligibilityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pertukaran Yang Tidak Dibenarkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Sila tandakan jika anda tergolong dalam mana-mana kategori di bawah. Jika sekurang-kurangnya satu dipilih, pertukaran tidak dibenarkan.</strong></p>
                <form id="eligibility-form">
                    @csrf
                    <div class="form-group">
                        <label><input type="checkbox" name="rules[]" value="prestasi_rendah"> Pegawai berprestasi rendah – kurang daripada 75 peratus.</label>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="rules[]" value="tatatertib"> Pegawai yang melanggar tata kelakuan dan sedang dalam tindakan tatatertib.</label>
                    </div>
                    <div id="error-message" class="alert alert-danger mt-3" style="display: none;">
                        <strong>Pertukaran Tidak Dibenarkan!</strong> Anda tidak layak untuk pertukaran.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="checkEligibilityBtn">Teruskan</button>
            </div>
        </div>
    </div>
</div>

<!-- Preferred State Modal -->
<div class="modal fade" id="matchModal" tabindex="-1" role="dialog" aria-labelledby="matchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Di mana anda berhajat untuk berpindah?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Pilih Negeri:</label>
                <select id="preferredState" class="form-control">
                    <option value="">Pilih Negeri</option>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="findMatchBtn">Cari Padanan</button>
            </div>
        </div>
    </div>
</div>


<script>

document.getElementById("checkEligibilityBtn").addEventListener("click", function() {
    let checkboxes = document.querySelectorAll('input[name="rules[]"]:checked');

    if (checkboxes.length > 0) {
        document.getElementById("error-message").style.display = "block";
    } else {
        document.getElementById("error-message").style.display = "none";
        
        // ✅ Close eligibility modal
        $('#eligibilityModal').modal('hide');

        // ✅ Open state selection modal
        setTimeout(() => {
            $('#matchModal').modal('show');
        }, 500); // Delay to avoid modal conflict
    }
});

document.getElementById("findMatchBtn").addEventListener("click", function() {
    let selectedState = document.getElementById("preferredState").value;
    
    if (!selectedState) {
        alert("Please select a state.");
        return;
    }
    
    // ✅ Redirect to available matches page with selected state
    window.location.href = "/available-matches?state=" + selectedState;
});


</script>

@endsection
