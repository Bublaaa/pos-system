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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambah menu baru -->
<div class="container">
    <form action="{{ route('salary.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2>Pembayaran Gaji : {{ $userData->name }}</h2>
        <h5>Rekening : {{ $userData->bank_name }} - {{ $userData->account_number }}</h5>
        <input type="hidden" name="userName" id="userName" value="{{ $userData->name }}">
        <input type="hidden" name="attendancePercentage" id="attendancePercentage" value="{{ $attendancePercentage }}">
        <input type="hidden" name="month" id="month" value="{{ $month }}">
        <input type="hidden" name="year" id="year" value="{{ $year }}">
        <div class="card">
            <div class="card-body">
                <h2>{{ $month }}</h2>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="basicSalary">Gaji Pokok</label>
                            <input type="number" name="basicSalary"
                                class="form-control @error('basicSalary') is-invalid @enderror" id="basicSalary"
                                placeholder="Jumlah gaji pokok"
                                value="{{ $userData->basic_salary !== null ? $userData->basic_salary : old('basicSalary') }}"
                                inputmode="numeric" max="10000000" min="1" required=true>
                            @error('basicSalary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <p id=formattedBasicSalary></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="attendancePercentage">Persentasi kehadiran</label>
                            <h6 name="attendancePercentage" id="attendancePercentage">
                                {{ $attendancePercentage }}%</h6>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="additionalSalaryName">Gaji Tambahan</label>
                            <input type="text" name="additionalSalaryName"
                                class="form-control @error('additionalSalaryName') is-invalid @enderror"
                                id="additionalSalaryName" placeholder="Uang lembur tanggal 12 November.. "
                                value="{{ old('additionalSalaryName') }}">
                            @error('additionalSalaryName')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="additionalSalary">Jumlah Gaji Tambahan</label>
                            <input type="number" name="additionalSalary"
                                class="form-control @error('additionalSalary') is-invalid @enderror"
                                id="additionalSalary" placeholder="Jumlah gaji tambahan" value="old('additionalSalary')"
                                inputmode="numeric" max="10000000" min="1">
                            @error('additionalSalary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <p id=formattedAdditionalSalary></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="salary">Gaji yang diberikan</label>
                            <input type="number" name="salary"
                                class="form-control @error('salary') is-invalid @enderror" id="salary"
                                placeholder="Jumlah gaji pokok" value="{{ old('salary') }}" inputmode="numeric" min="1"
                                max="10000000" required=true>
                            @error('salary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <p id=formattedSalary></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Bayar</button>
            </div>
        </div>
    </form>
</div>
<script>
$('#basicSalary').on('input', function() {
    updateSalary();
});
$('#salary').on('input', function() {
    updateSalaryOnInput();
});
$('#additionalSalary').on('input', function() {
    updateSalary();
    updateRequired();
});
$('#additionalSalaryName').on('input', function() {
    updateRequired();
});

function updateRequired() {
    var additionalSalary = parseFloat($('#additionalSalary').val()) || 0;
    var additionalSalaryName = $('#additionalSalaryName').val().trim();

    if (additionalSalary !== 0 || additionalSalaryName !== '') {
        $('#additionalSalary').prop('required', true);
        $('#additionalSalaryName').prop('required', true);
    } else {
        $('#additionalSalary').prop('required', false);
        $('#additionalSalaryName').prop('required', false);
    }
}

function updateSalaryOnInput() {
    const salaryText = document.getElementById('formattedSalary');

    var salary = parseFloat($('#salary').val()) || 0;
    salaryText.textContent = `${formatCurrency(salary)}`;

}

function updateSalary() {
    const basicSalaryText = document.getElementById('formattedBasicSalary');
    const salaryText = document.getElementById('formattedSalary');
    const additionalSalaryText = document.getElementById('formattedAdditionalSalary');


    var basicSalary = parseFloat($('#basicSalary').val()) || 0;
    var additionalSalary = parseFloat($('#additionalSalary').val()) || 0;
    var attendancePercentage = parseFloat('{{ $attendancePercentage}}');
    var calculatedSalary = (basicSalary * (attendancePercentage / 100)) + additionalSalary;

    // Update the content of basicSalaryText and salaryText dynamically
    additionalSalaryText.textContent = `${formatCurrency(additionalSalary)}`;
    basicSalaryText.textContent = `${formatCurrency(basicSalary)}`;
    salaryText.textContent = `${formatCurrency(calculatedSalary)}`;

    $('#salary').val(calculatedSalary);
}

function formatCurrency(amount) {
    // Implement your currency formatting logic here
    return 'Rp. ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}

updateSalary();
</script>
@endsection