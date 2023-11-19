@extends('layouts.ownerView')

@section('content')
<!-- <h2>Edit akun {{$user[0]->name}}</h2> -->
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.update' ,$user[0]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="userName">Username :</label>
                <input name="userName" class="form-control @error('userName') is-invalid @enderror" id="userName"
                    placeholder="Nama karyawan" value="{{ $user[0]['username'] }}"></input>
                @error('userName')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Nama Karyawan :</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="Nama karyawan" value="{{ $user[0]['name'] }}">{{ old('name') }}</input>
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="position">Posisi : </label>
                <select name="position" class="custom-select @error('position') is-invalid @enderror" id="position">
                    <option value="headbar" {{ $user[0]['position'] === 'headbar' ? 'selected' : ''}}>Head Bar</option>
                    <option value="employee" {{ $user[0]['position'] === 'employee' ? 'selected' : ''}}>Employee
                    </option>
                </select>
                @error('position')
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