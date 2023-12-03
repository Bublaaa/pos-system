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
                            class="{{ $todayAttendance->status === 'hadir' ? 'alert alert-success' : ($todayAttendance->status === 'terlambat' ? 'alert alert-warning' : 'alert alert-danger') }}">
                            <div class="row">
                                <div class="col">
                                    <h5>{{$shiftData->employee_name}} -
                                        {{ucwords($todayAttendance->status)}}</h5>
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
                            class="{{ $todayAttendance->status === 'hadir' ? 'alert alert-success' : ($todayAttendance->status === 'terlambat' ? 'alert alert-warning' : 'alert alert-danger') }}">
                            <div class="row">
                                <div class="row">
                                    <div class="col">
                                        <h5>{{$shiftData->employee_name}} -
                                            {{ucwords($todayAttendance->status)}}</h5>
                                    </div>
                                </div>
                                <p>{{$todayAttendance->description}}</p>
                            </div>
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
                @if(count($groupedData) > 0)
                @foreach($groupedData as $year => $yearlyData)
                <div class="row">
                    <h4 class="text-center">Tahun {{ $year }}</h3>
                        @foreach($yearlyData as $month => $employeeData)
                        <div class="row">
                            <h4 class="py-2">{{ $month }}</h4>
                            <div class="row">
                                @foreach($employeeData as $employeeName => $totalAttendances)
                                <div class="col-12 col-md-3">
                                    <div class="card" data-toggle="modal"
                                        data-target="#detailModal{{ str_replace(' ', '', $employeeName) }}"
                                        tabindex="1">
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
                                            <a href="{{ route('salary-payment', ['userName' => $employeeName, 'attendancePercentage' => round(($totalAttendances / $totalDaysInMonth) * 100), 'month' => $month, 'year' => $year]) }}"
                                                type="button" class="btn btn-primary">Bayar Gaji</a>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                </div>
                @endforeach
                @else
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada presensi yang terdaftar.
                </div>
                @endif
            </div>

            <!-- All attendance tab -->
            <div class="tab-pane fade" id="allAttendance">
                @if($allAttendance->count() > 0)
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
                                        <p
                                            style="{{ $attendance->status === "hadir" ? 'color:green;' : ($attendance->status === "terlambat" ? 'color: #FFA500;' : 'color:red;') }}">
                                            {{ ucwords($attendance->status) }}</p>
                                        <p>Presensi Pukul :
                                            {{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i') }}
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
                    <div class="modal fade" id="deleteModal{{ $attendance['id']}}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Presensi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda yakin ingin menghapus presensi ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('attendance.destroy', $attendance) }}" method="POST">
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
                @endforeach
                @endforeach
                @else
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada presensi yang terdaftar.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection