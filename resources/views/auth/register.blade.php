@extends('layouts/ownerView')

@section('content')
<div class="container">
    <h2>Tambah Akun Karyawan</h2>
    <div class="row justify-content-center">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <!-- <div class="row mb-3 justify-content-center">
                            <img id="profileImagePreview" class="rounded-circle"
                                style="min-width: 150px;max-width: 170px; max-height: 150px; object-fit: cover;object-position: center center;" />
                        </div> -->
                        <div class="row">
                            <!-- Personal info -->
                            <div class="col-12 col-md-6">
                                <!-- Profile image -->
                                <!-- <div class="row mb-3">
                                    <label for="profile_image"
                                        class="col-md-4 col-form-label">{{ __('Foto Profil') }}</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="profile_image" id="profile_image"
                                            required=true onchange="previewImage(this)">
                                        @error('profile_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div> -->
                                <!-- Full Name -->
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label  ">{{ __('Nama Lengkap') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Phone number -->
                                <div class="row mb-3">
                                    <label for="phone_number"
                                        class="col-md-4 col-form-label  ">{{ __('Nomor Telepon') }}</label>
                                    <div class="col-md-6">
                                        <input id="phone_number" value="{{ old('phone_number') }}" name="phone_number"
                                            class="form-control @error('phone_number') is-invalid @enderror" type="tel"
                                            pattern="[0-9]*" inputmode="numeric" maxlength="12" required autofocus>
                                        @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Address -->
                                <div class="row mb-3">
                                    <label for="address" class="col-md-4 col-form-label  ">{{ __('Alamat') }}</label>
                                    <div class="col-md-6">
                                        <textarea class="form-control @error('address') is-invalid @enderror"
                                            name="address" id="address" rows="3" autocomplete="address"
                                            value="{{ old('address') }}" required></textarea>
                                        @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Bank Name -->
                                <div class="row mb-3">
                                    <label for="bank_name"
                                        class="col-md-4 col-form-label  ">{{ __('Nama Bank') }}</label>
                                    <div class="col-md-6">
                                        <input id="bank_name" type="text"
                                            class="form-control @error('bank_name') is-invalid @enderror"
                                            name="bank_name" value="{{ old('bank_name') }}" required
                                            autocomplete="bank_name" autofocus>
                                        @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Bank Account Number -->
                                <div class="row mb-3">
                                    <label for="account_number"
                                        class="col-md-4 col-form-label  ">{{ __('No. Rekening') }}</label>
                                    <div class="col-md-6">
                                        <input id="account_number" value="{{ old('account_number') }}"
                                            name="account_number"
                                            class="form-control @error('account_number') is-invalid @enderror"
                                            type="tel" pattern="[0-9]*" inputmode="numeric" maxlength="12" required
                                            autofocus>
                                        @error('account_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Account info -->
                            <div class="col-12 col-md-6">
                                <!-- Username -->
                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-form-label  ">{{ __('Username') }}</label>
                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username">
                                        @error('userName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Position -->
                                @if($positionData->count()>0)
                                <div class="row mb-3">
                                    <label for="position" class="col-md-4 col-form-label  ">{{ __('Posisi') }}</label>
                                    <div class="col-md-6">
                                        <select id="position"
                                            class="custom-select @error('position') is-invalid @enderror"
                                            value="{{ old('name') }}" name="position" required autocomplete="name"
                                            autofocus>
                                            @foreach($positionData as $position)
                                            <option value="{{ $position->name}}"> {{ ucwords($position->name) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Basic Salary -->
                                <div class="row">
                                    <label for="basic_salary"
                                        class="col-md-4 col-form-label  ">{{ __('Gaji Pokok') }}</label>
                                    <div class="col-md-6">
                                        <input type="number" name="basic_salary"
                                            class="form-control @error('basic_salary') is-invalid @enderror"
                                            id="basic_salary" value="{{ old('basic_salary') }}" inputmode="numeric"
                                            max="10000000" min="1" required=true>
                                        @error('basic_salary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <p id="formattedBasicSalary"></p>
                                    </div>
                                </div>
                                @else
                                <div id="alertContainer" class="alert alert-primary">
                                    Belum ada posisi yang terdaftar.
                                    <br>
                                    <button onclick="window.location.href='{{ route('position.index') }}'"
                                        class="btn btn-primary">
                                        Tambah Posisi
                                </div>
                                @endif
                                <!-- Password -->
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label  ">{{ __('Password') }}</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- Confirm password -->
                                <div class="row mb-3">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label  ">{{ __('Konfirmasi Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-2 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
var positionData = [];

@foreach($positionData as $index => $position)
var positionItem = {
    name: '{{ $position->name }}',
    basic_salary: '{{ $position->basic_salary }}',
};
positionData.push(positionItem);
@endforeach

$(document).ready(function() {
    var selectedValue = $('#position').val();
    $('#position').on('change', function() {
        var selectedValue = $(this).val();
        for (const position of positionData) {
            if (selectedValue == position.name) {
                $('#basic_salary').val(position.basic_salary);
                updateSalary();
            }
        }
    });
    for (const position of positionData) {
        if (selectedValue == position.name) {
            $('#basic_salary').val(position.basic_salary);
            updateSalary();
        }
    }
});

$('#basic_salary').on('input', function() {
    updateSalary();
});

function updateSalary() {
    const basic_salaryText = document.getElementById('formattedBasicSalary');
    var basic_salary = parseFloat($('#basic_salary').val()) || 0;
    basic_salaryText.innerText = formatCurrency(basic_salary);
}


function formatCurrency(amount) {
    return 'Rp. ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
updateSalary();

function previewImage(input) {
    var preview = $('#profileImagePreview')[0];
    var file = input.files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        };

        reader.readAsDataURL(file);
    } else {
        preview.src = ""; // If no file is selected, clear the preview
    }
}
</script>
@endsection