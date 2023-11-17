@extends('layouts.ownerView')

@section('content')
<div class="container">
    <h2>Laporan Presensi</h2>
    <!-- Tabs link -->
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="dailyTab" data-toggle="tab" href="#dailyAttendance"
                style="color: black;">Presensi
                Harian</a>
        </li>
        @if($user->position == "owner")
        <li class="nav-item">
            <a class="nav-link " id="monthlyTab" data-toggle="tab" href="#monthlyAttendance"
                style="color: black;">Presensi
                Bulanan</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link " id="allTab" data-toggle="tab" href="#allAttendance" style="color: black;">Semua
                Presensi</a>
        </li>
    </ul>
    <div class="container p-3">
        <div class="tab-content">
            <!-- Daily Attendance -->
            <div class="tab-pane fade show active" id="dailyAttendance">
                @if($todayAttendanceData->count()>0)
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h4 class="text-center">Shift Siang</h4>
                        @foreach($todayAttendanceData as $index => $todayAttendance)
                        @php
                        $shiftData = $todayShiftData->where('employee_name', $todayAttendance->name)->first();
                        @endphp
                        @if($shiftData->name == 'siang')
                        <div
                            class="{{ $todayAttendance->status === 1 ? 'alert alert-success' : 'alert alert-danger' }}">
                            <div class="row">
                                <div class="col">
                                    <h5>{{$shiftData->employee_name}} -
                                        {{$todayAttendance->status === 1 ? 'Hadir' : 'Absen'}}</h5>
                                    <p>Shift dimulai pukul
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $shiftData->start_time) ->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <p>{{$todayAttendance->description}}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="col-12 col-md-6">
                        <h4 class="text-center">Shift Sore</h4>
                        @foreach($todayAttendanceData as $index => $todayAttendance)
                        @php
                        $shiftData = $todayShiftData->where('employee_name', $todayAttendance->name)->first();
                        @endphp
                        @if($shiftData->name == 'sore')
                        <div
                            class="{{ $todayAttendance->status === 1 ? 'alert alert-success' : 'alert alert-danger' }}">
                            <div class="row">
                                <div class="col">
                                    <h5>{{$shiftData->employee_name}} -
                                        {{$todayAttendance->status === 1 ? 'Hadir' : 'Absen'}}</h5>
                                    <p>Shift dimulai pukul
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $shiftData->start_time) ->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <p>{{$todayAttendance->description}}</p>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @else
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada presensi yang terdaftar.
                </div>
                @endif

            </div>
            <!-- Monthly attendance tab -->
            <div class="tab-pane fade" id="monthlyAttendance">
                @foreach($groupedData as $month => $employeeData)
                <div class="row">
                    <h4 class="text-center py-2">{{ $month }}</h4>
                    <div class="row">
                        @foreach($employeeData as $employeeName => $totalAttendances)
                        <div class="col-12 col-md-3">
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
                @endforeach
                @foreach($allUserAttendanceThisMonth as $userName => $allUserAttendance)
                @include('layouts/partials/attendanceDetailModal', ['allUserAttendanceThisMonth' =>
                $allUserAttendanceThisMonth])
                @endforeach
            </div>

            <!-- All attendance tab -->
            <div class="tab-pane fade" id="allAttendance">
                @foreach ($allAttendance as $month => $data)
                <h4 class="text-center">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</h4>

                @foreach ($data->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('d'); // grouping by day
                }) as $day => $attendances)

                <h5>Tanggal: {{ \Carbon\Carbon::create()->month($month)->day($day)->format('d') }}</h5>
                <div class="row">
                    @foreach ($attendances as $attendance)
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        @if($attendance->image)
                                        <img class="product-img" src="{{ Storage::url($attendance->image) }}"
                                            style="max-width: 200px; max-height: 150px; width: 100%; height: 100%; object-fit: cover;">
                                        <p>{{ $attendance->description }}</p>
                                        @else
                                        Bukti Absen tidak tersedia
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h5>{{ $attendance->name }}</h5>
                                        <p style="{{ $attendance->status === 1 ? 'color:green;' : 'color:red;' }}">
                                            {{ $attendance->status == 1 ? 'Hadir' : 'Absen' }}</p>
                                        <p>Pukul: {{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i') }}
                                        </p>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                            target="_blank" type="button" class="btn btn-primary">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Open maps
                                        </a>
                                        <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                            data-target="#deleteModal{{ $attendance['id'] }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection