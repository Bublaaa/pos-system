@extends('layouts.ownerView')

@section('content')
<div class="container">
    <div class="row">
        @foreach($userAttendance as $userName => $userAttendances)
        <div class="col-6 col-md-3">
            <div class="card" data-toggle="modal" data-target="#detailModal{{ str_replace(' ', '', $userName) }}"
                tabindex="1">
                <div class="col p-3">
                    <h5>{{ $userName }}</h5>
                    <h6>{{ round(($userAttendances->count() / $totalDaysInMonth) * 100) }}%</h6>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ round(($userAttendances->count() / $totalDaysInMonth) * 100) }}%;"
                            aria-valuenow="{{ round(($userAttendances->count() / $totalDaysInMonth) * 100) }}"
                            aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts/partials/attendanceDetailModal', ['userAttendances' => $userAttendances])
        @endforeach
    </div>
</div>
@endsection