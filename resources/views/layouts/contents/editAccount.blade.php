@extends('layouts.ownerView')

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    </script>
</head>
<h2>Edit Akun</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.update' ,$user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 col-md-4">
                    @if($user->profile_image)
                    <img id="profileImagePreview" src="{{ asset('storage/'. $user->profile_image) }}"
                        class="rounded-circle mb-3 "
                        style="min-width: 150px;max-width: 170px; max-height: 150px; object-fit: cover;object-position: center center;" />
                    @endif
                    <br>
                    <label for="profile_image">Foto Profil</label>
                    <input type="file" class="form-control" name="profile_image" id="profile_image"
                        onchange="previewImage(this)">
                    @error('profile_image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <!-- Username -->
                    <div class="form-group">
                        <label for="userName">Username</label>
                        <input name="userName" class="form-control @error('userName') is-invalid @enderror"
                            id="userName" placeholder="Nama karyawan" value="{{ $user->username }}"
                            require=true></input>
                        @error('userName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="oldPassword">Password Lama</label>
                        <input name="oldPassword" class="form-control @error('oldPassword') is-invalid @enderror"
                            id="oldPassword" placeholder="Password Lama" type="password"
                            value="">{{ old('oldPassword') }}</input>
                        @error('oldPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="newPassword">Password Baru</label>
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
                </div>
                <div class="col-12 col-md-8">
                    <!-- Full name -->
                    <div class="form-group">
                        <label for="name">Nama Karyawan</label>
                        <input name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="Nama karyawan" value="{{ $user->name }}">{{ old('name') }}</input>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Phone number -->
                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon</label>
                        <input id="phone_number" name="phone_number"
                            class="form-control @error('phone_number') is-invalid @enderror" type="tel" pattern="[0-9]*"
                            inputmode="numeric" maxlength="12"
                            value="{{ $user->phone_number !== '' ? $user->phone_number : old('phone_number') }}"
                            required>
                        @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address"
                            id="address" rows="3" autocomplete="address"
                            required>{{ $user->address != '' ? $user->address : old('address') }}</textarea>
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Bank name -->
                    <div class="form-group">
                        <label for="bank_name">Nama Bank</label>
                        <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror"
                            name="bank_name" value="{{ $user->bank_name != '' ? $user->bank_name : old('bank_name') }}"
                            required autocomplete="bank_name" autofocus>
                        @error('bank_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Account number -->
                    <div class="form-group">
                        <label for="account_number">No. Rekening</label>
                        <input id="account_number" name="account_number"
                            class="form-control @error('account_number') is-invalid @enderror" type="tel"
                            pattern="[0-9]*" inputmode="numeric" maxlength="12"
                            value="{{ $user->account_number !== '' ? ($user->account_number) : old('account_number') }}"
                            required>
                        @error('account_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection