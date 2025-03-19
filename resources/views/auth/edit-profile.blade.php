@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">Edit Profile</h2>

    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-body">
           <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}">
                        </div>

                <div class="form-group">
                   <label>Skim</label>
                    <select name="skim" class="form-control">
                    <option value="">Select Skim</option>
                    <option value="Pakar" {{ Auth::user()->skim == 'Pakar' ? 'selected' : '' }}>Pakar</option>
                    <option value="Pegawai Perubatan" {{ Auth::user()->skim == 'Pegawai Perubatan' ? 'selected' : '' }}>Pegawai Perubatan</option>
                    <option value="Farmasi" {{ Auth::user()->skim == 'Farmasi' ? 'selected' : '' }}>Farmasi</option>
                    <option value="Pergigian" {{ Auth::user()->skim == 'Pergigian' ? 'selected' : '' }}>Pergigian</option>
                   </select>
                </div> 


                <div class="form-group">
                    <label>Gred</label>
                    <input type="text" name="gred" class="form-control" value="{{ Auth::user()->gred }}">
                </div>

                <div class="form-group">
                    <label>Fasiliti</label>
                    <input type="text" name="fasiliti" class="form-control" value="{{ Auth::user()->fasiliti }}">
                </div>

                <div class="form-group">
                    <label>Negeri</label>
                    <select name="negeri" class="form-control">
                    <option value="">Select Negeri</option>
                    <option value="Johor" {{ Auth::user()->negeri == 'Johor' ? 'selected' : '' }}>Johor</option>
                    <option value="Kedah" {{ Auth::user()->negeri == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                    <option value="Kelantan" {{ Auth::user()->negeri == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                    <option value="Melaka" {{ Auth::user()->negeri == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                    <option value="Negeri Sembilan" {{ Auth::user()->negeri == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                    <option value="Pahang" {{ Auth::user()->negeri == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                    <option value="Penang" {{ Auth::user()->negeri == 'Penang' ? 'selected' : '' }}>Penang</option>
                    <option value="Perak" {{ Auth::user()->negeri == 'Perak' ? 'selected' : '' }}>Perak</option>
                    <option value="Perlis" {{ Auth::user()->negeri == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                    <option value="Sabah" {{ Auth::user()->negeri == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                    <option value="Sarawak" {{ Auth::user()->negeri == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                    <option value="Selangor" {{ Auth::user()->negeri == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                    <option value="Terengganu" {{ Auth::user()->negeri == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                    <option value="WP Kuala Lumpur" {{ Auth::user()->negeri == 'WP Kuala Lumpur' ? 'selected' : '' }}>WP Kuala Lumpur</option>
                    <option value="WP Labuan" {{ Auth::user()->negeri == 'WP Labuan' ? 'selected' : '' }}>WP Labuan</option>
                    <option value="WP Putrajaya" {{ Auth::user()->negeri == 'WP Putrajaya' ? 'selected' : '' }}>WP Putrajaya</option>
                    </select>
                  </div>


                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" value="{{ Auth::user()->jabatan }}">
                </div>

                <div class="form-group">
                    <label>Pengalaman (Years)</label>
                    <input type="number" name="pengalaman" class="form-control" value="{{ Auth::user()->pengalaman }}">
                </div>

                <div class="form-group">
                    <label>Jenis Fasiliti</label>
                    <input type="text" name="jenis_fasiliti" class="form-control" value="{{ Auth::user()->jenis_fasiliti }}">
                </div>

                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
