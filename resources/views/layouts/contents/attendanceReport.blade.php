@extends('layouts.ownerView')

@section('content')
<div class="container">
    <h2>Laporan Absensi</h2>
    <div class="row">
        @foreach($employees as $employee)
        <div class="col-6 col-md-3">
            <div class="card" data-toggle="modal" data-target="#detailModal{{ str_replace(' ', '', $employee->name) }}"
                tabindex="1">
                <div class="col p-3">
                    <h4>{{ $employee->name }}</h4>
                    <h5>{{ $employee->position === 'headbar' ? "Head Bar" : "Karyawan"}}</h5>
                    @foreach($userAttendances as $userName => $userAttendance)
                    @if($employee->name == "$userName")
                    <h6>{{ round(($userAttendance->count() / $totalDaysInMonth) * 100) }}%</h6>
                    </h6>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ round(($userAttendance->count() / $totalDaysInMonth) * 100) }}%;"
                            aria-valuenow="{{ round(($userAttendance->count() / $totalDaysInMonth) * 100) }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('salary-payment', ['userName' => $employee->name]) }}" type="button"
                        class="btn btn-primary">Bayar
                        Gaji</a>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($allUserAttendance as $userName => $allUserAttendance)
        @include('layouts/partials/attendanceDetailModal', ['allUserAttendance' => $allUserAttendance])
        @endforeach
    </div>
</div>
@endsection