@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card mx-auto mt-4" style="max-width: 600px;">
        <div class="card-body">
            <h3 class="text-center">Supervisor & Department Head Details</h3>
            <p class="text-center">Please provide the contact details of your supervisor and department head.</p>

            <form action="{{ route('match.supervisor.save', ['match_id' => $match->id]) }}" method="POST">
                @csrf

                <h5>Supervisor (Penyelia)</h5>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="penyelia_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="penyelia_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="penyelia_phone" class="form-control" required>
                </div>

                <h5>Department Head (Ketua Jabatan)</h5>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="ketua_jabatan_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="ketua_jabatan_email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="ketua_jabatan_phone" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success btn-block">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
