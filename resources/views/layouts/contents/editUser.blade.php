@extends('layouts.ownerView')

@section('content')
<h2>Edit Akun Karyawan</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.update' ,$user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12 col-md-3">
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
                </div>
                <div class="col-12 col-md-5">
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
                <div class="col-12 col-md-4">
                    <!-- Username -->
                    <div class="form-group">
                        <label for="userName">Username</label>
                        <input name="userName" class="form-control @error('userName') is-invalid @enderror"
                            id="userName" placeholder="Nama karyawan" value="{{ $user->username }}"></input>
                        @error('userName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Postiion -->
                    @if($positionData->count()>0)
                    <div class="form-group">
                        <label for="position">Posisi</label>
                        <select name="position" class="custom-select @error('position') is-invalid @enderror"
                            id="position">
                            @foreach($positionData as $position)
                            <option value="{{$position->name}}"
                                {{$user->position === $position->name ? 'selected' : ''}}>
                                {{ ucwords($position->name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('position')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <!-- Basic Salary -->
                    <div class="form-group">
                        <label for="basic_salary">Gaji Pokok</label>
                        <input type="number" name="basic_salary"
                            class="form-control @error('basic_salary') is-invalid @enderror" id="basic_salary"
                            value="{{ $position->basic_salary }}" inputmode="numeric" max="10000000" min="1"
                            required=true>
                        @error('basic_salary')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <p id="formattedBasicSalary"></p>
                    </div>
                    @else
                    <div id="alertContainer" class="alert alert-primary">
                        Belum ada posisi yang terdaftar.
                        <br>
                        <button onclick="window.location.href='{{ route('position.index') }}'" class="btn btn-primary">
                            Tambah Posisi
                    </div>
                    @endif
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>
            </div>
        </form>
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