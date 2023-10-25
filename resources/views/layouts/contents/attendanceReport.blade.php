@extends('layouts.ownerView')

@section('content')
<div class="container">
    <h2>Laporan Absensi</h2>
    @foreach($groupedData as $month => $employeeData)
    <div class="card">
        <div class="card-header">
            {{ $month }}
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($employeeData as $employeeName => $totalAttendances)
                <div class="col-6 col-md-3">
                    <div class="card" data-toggle="modal"
                        data-target="#detailModal{{ str_replace(' ', '', $employeeName) }}" tabindex="1">
                        <div class="col p-3">
                            <h4>{{ $employeeName }}</h4>
                            <h6>{{ round(($totalAttendances / $totalDaysInMonth) * 100) }}%</h6>
                            </h6>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ round($totalAttendances / $totalDaysInMonth * 100) }}%;"
                                    aria-valuenow="{{ round($totalAttendances / $totalDaysInMonth * 100) }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('salary-payment', ['userName' => $employeeName]) }}" type="button"
                                class="btn btn-primary">Bayar
                                Gaji</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    @foreach($allUserAttendance as $userName => $allUserAttendance)
    @include('layouts/partials/attendanceDetailModal', ['allUserAttendance' => $allUserAttendance])
    @endforeach
</div>
@endsection