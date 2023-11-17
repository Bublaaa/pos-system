@extends('layouts.ownerView')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Tambah menu baru -->
<form action="{{ route('salary.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Pembayaran Gaji : {{ $userData->name }}</h2>
    <input type="hidden" name="userName" id="userName" value="{{ $userData->name }}">
    <input type="hidden" name="attendanceCount" id="attendanceCount" value="{{ $userAttendanceData->count() }}">
    <input type="hidden" name="totalDaysInMonth" id="totalDaysInMonth" value="{{ $totalDaysInMonth }}">
    <div class="container p-3">
        <div class="card">
            <div class="card-body">
                <h2>{{ $currentMonth }}</h2>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="basicSalary">Gaji Pokok</label>
                            <input type="number" name="basicSalary"
                                class="form-control @error('basicSalary') is-invalid @enderror" id="basicSalary"
                                placeholder="Jumlah gaji pokok" value="{{ old('basicSalary') }}" inputmode="numeric"
                                max="10000000" min="1" required=true>
                            @error('basicSalary')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <p id=formattedBasicSalary></p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="attendancePercentage">Persentasi kehadiran</label>
                            <h6 name="attendancePercentage" id="attendancePercentage">
                                {{ round(($userAttendanceData->count() / $totalDaysInMonth) * 100) }}%</h6>
                        </div>
                    </div>
                    <div class="col-4">
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
    </div>
</form>
<script>
$('#basicSalary').on('input', function() {
    updateSalary();
});

function updateSalary() {
    const basicSalaryText = document.getElementById('formattedBasicSalary');
    const salaryText = document.getElementById('formattedSalary');

    var basicSalary = parseFloat($('#basicSalary').val()) || 0;
    var attendancePercentage = parseFloat('{{ round(($userAttendanceData->count() / $totalDaysInMonth) * 100) }}');
    var calculatedSalary = basicSalary * (attendancePercentage / 100);

    // Update the content of basicSalaryText and salaryText dynamically
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