@extends('layouts.ownerView')

@section('content')
<div class="container">
    <h2>Absensi</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
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
                </div>
                <input type="hidden" name="latitude" id="latitude" value="">
                <input type="hidden" name="longitude" id="longitude" value="">

                <div class="form-group">
                    <label for="image">Bukti absen</label>
                    <div class="custom-file">
                        <input type="file" class="form-control" name="image" id="image" required=true>
                    </div>
                    @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button class=" btn btn-primary" type="submit">Create</button>
            </form>
        </div>
    </div>
</div>

<script>
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

    console.log(latitude + "," + longitude);
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