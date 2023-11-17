@extends('layouts.ownerView')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group" id="userName" name="userName">
                <label for="userName">Username :</label>
                <input name="userName" class="form-control @error('userName') is-invalid @enderror" id="userName"
                    placeholder="Nama karyawan" value="{{ $user->username }}" require=true></input>
                @error('userName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group" id="oldPassword" name="oldPassword">
                <label for="oldPassword">Password Lama :</label>
                <input name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror"
                    id="oldPassword" placeholder="Password Lama" type="password"
                    value="">{{ old('oldPassword') }}</input>
                @error('oldPassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group" id="newPassword" name="newPassword">
                <label for="newPassword">Password Baru :</label>
                <input name="newPassword" class="form-control @error('newPassword') is-invalid @enderror"
                    id="newPassword" placeholder="Password Baru" type="password" minlength="8"
                    value="">{{ old('newPassword') }}</input>
                @error('newPassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
</div>
@endsection