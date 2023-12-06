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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
</head>
<div class="container">
    <div class="alert alert-warning">
        Pastikan GPS dalam kondisi hidup dan berikan akses lokasi pada situs ini.
    </div>
    <h2>Presensi</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="custom-select @error('status') is-invalid @enderror" id="status"
                        onchange="toggleDescription()">
                        <option value="1" {{ old('status') === 1 ? 'selected' : ''}}>Hadir</option>
                        <option value="0" {{ old('status') === 0 ? 'selected' : ''}}>Ijin</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div> 
                <div class="form-group" id="descriptionField" style="display:none;">
                    <label for="description">Keterangan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        id="description" placeholder="Keterangan ijin">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>-->
                <input type="hidden" name="latitude" id="latitude" value="">
                <input type="hidden" name="longitude" id="longitude" value="">
                <input type="hidden" name="attendanceStatus" id="attendanceStatus" value="hadir">

                <div class="form-group">
                    <label for="attendanceImage">Bukti presensi</label>
                    <div class="custom-file">
                        <input type="file" class="form-control" name="attendanceImage" id="attendanceImage"
                            required=true>
                    </div>
                    @error('attendanceImage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button class=" btn btn-primary" type="submit">Presensi</button>
            </form>
        </div>
    </div>
    <h2>Absensi</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- <div class="form-group">
                    <label for="statusAbsent">Status</label>
                    <select name="statusAbsent" class="custom-select @error('status') is-invalid @enderror"
                        id="statusAbsent">
                        <option value="0" selected>Ijin</option>
                    </select>
                    @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div> -->
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="date">Tanggal Ijin</label>
                            <input type="date" name="startDate" class="form-control" id="startDate"
                                min="{{date('Y-m-d', strtotime('+1 day'))}}"
                                value="{{date('Y-m-d', strtotime('+1 day'))}}" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label for="date">Sampai Tanggal</label>
                            <input type="date" name="endDate" class="form-control" id="endDate"
                                min="{{date('Y-m-d', strtotime('+1 day'))}}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                        id="description" placeholder="Keterangan ijin">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <input type="hidden" name="absentLatitude" id="absentLatitude" value="">
                <input type="hidden" name="absentLongitude" id="absentLongitude" value="">
                <input type="hidden" name="absentStatus" id="absentStatus" value="ijin">


                <div class="form-group">
                    <label for="absentImage">Bukti absen</label>
                    <div class="custom-file">
                        <input type="file" class="form-control" name="absentImage" id="absentImage" required=true>
                    </div>
                    @error('absentImage')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button class=" btn btn-primary" type="submit">Absen</button>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css"
    rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

<script>
$(document).ready(function() {
    $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d', // Today or later
        endDate: '+1d' // Tomorrow or later
    });
});

function toggleDescription() {
    var status = document.getElementById('status');
    var descriptionGroup = document.getElementById('descriptionField');
    var descriptionField = document.getElementById('description');

    if (status.value == 0) {
        // Show the description field
        descriptionGroup.style.display = 'block';
        descriptionField.required = true;
    } else {
        // Hide the description field
        descriptionGroup.style.display = 'none';
        descriptionField.required = false;
    }
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    document.getElementById('latitude').value = latitude;
    document.getElementById('longitude').value = longitude;
    document.getElementById('absentLatitude').value = latitude;
    document.getElementById('absentLongitude').value = longitude;

    // console.log(latitude + "," + longitude);
}

function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}

getLocation();
</script>
@endsection