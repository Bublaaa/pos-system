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
<!-- Tambah Posisi baru -->
<h2>Edit Posisi</h2>
<div class="card">
    <div class="card-body">
        <!-- POsition Card -->
        @foreach($positions as $index => $position)
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row mb-4">
                <div class="col-6 col-md-3">
                    <label for="name[{{ $index }}]">Nama Posisi</label>
                    <input id="name[{{ $index }}]" type="text"
                        class="form-control @error('name[{{ $index }}]') is-invalid @enderror" name="name[{{ $index }}]"
                        value="{{ $position->name }}" required autofocus>
                    @error('name[{{ $index }}]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-6 col-md-4">
                    <label for="basic_salary[{{ $index }}]">Gaji Pokok</label>
                    <input type="number" name="basic_salary[{{$index}}]"
                        class="form-control @error('basic_salary[{{$index}}]') is-invalid @enderror"
                        id="basic_salary[{{$index}}]" value="{{ $position->basic_salary }}" inputmode="numeric"
                        max="10000000" min="1" required=true>
                    @error('basic_salary[{{$index}}]')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-6 col-md-4 pt-4">
                    <p id="formattedBasicSalary[{{$index}}]"></p>
                </div>
                <div class="col-6 col-md-1">
                    <button type="button" class="btn btn-danger mt-3" data-toggle="modal"
                        data-target="#deleteModal{{ $position->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </form>

        <div class="modal fade" id="deleteModal{{ $position->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Posisi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus posisi ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('position.destroy', $position) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class=" card-footer">
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</div>
<!-- <h2>Tambah Posisi Baru</h2>
<div class="card">
    <form action="{{ route('position.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-header">
            Tambah posisi
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <label for="addName">Nama Posisi</label>
                    <input id="addName" type="text" class="form-control @error('addName') is-invalid @enderror"
                        name="addName" value="{{ old('addName') }}" required autofocus>
                    @error('addName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="col-12 col-md-3">
                    <label for="addBasicSalary">Gaji Pokok</label>
                    <input type="number" name="addBasicSalary"
                        class="form-control @error('addBasicSalary') is-invalid @enderror" id="addBasicSalary"
                        value="{{ old('addBasicSalary') }}" inputmode="numeric" max="10000000" min="1" required=true>
                    @error('addBasicSalary')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <p id="addFormattedBasicSalary"></p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </form>
</div> -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
var positionIndex = "{{$positions->count()-1}}";
$(document).ready(function() {
    for (let index = 0; index <= positionIndex; index++) {
        (function(i) {
            updateSalaryArray(i);
            $('#basic_salary\\[' + i + '\\]').on('input', function() {
                updateSalaryArray(i);
            });
        })(index);
    }
});

function updateSalaryArray(index) {
    var basic_salary = document.getElementById('formattedBasicSalary[' + index + ']');
    var basicSalaryInput = parseFloat($('#basic_salary\\[' + index + '\\]').val()) || 0;
    basic_salary.innerText = formatCurrency(basicSalaryInput);
}


$('#addBasicSalary').on('input', function() {
    updateSalary();
});

function updateSalary() {
    const basic_salaryText = document.getElementById('addFormattedBasicSalary');
    var basic_salary = parseFloat($('#addBasicSalary').val()) || 0;
    basic_salaryText.innerText = formatCurrency(basic_salary);
}

function formatCurrency(amount) {
    return 'Rp. ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}
updateSalary();
</script>
@endsection