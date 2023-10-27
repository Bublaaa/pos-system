@extends('layouts.ownerView')

@section('content')
<div class="container">
    <h2>Laporan Absensi</h2>
    <!-- Tabs link -->
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="dailyTab" data-toggle="tab" href="#dailyAttendance"
                style="color: black;">Absen
                Harian</a>
        </li>
        @if($user->position == "owner")
        <li class="nav-item">
            <a class="nav-link " id="monthlyTab" data-toggle="tab" href="#monthlyAttendance" style="color: black;">Absen
                Bulanan</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link " id="allTab" data-toggle="tab" href="#allAttendance" style="color: black;">Semua
                Absensi</a>
        </li>
    </ul>
    <div class="container p-3">
        <div class="tab-content">
            <!-- Daily Attendance -->
            <div class="tab-pane fade show active" id="dailyAttendance">
                <div class="row">
                    <div class="col-6 col-md-6">
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
                    <div class="col-6 col-md-6">
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
            </div>
            <!-- Monthly attendance tab -->
            <div class="tab-pane fade" id="monthlyAttendance">
                @foreach($groupedData as $month => $employeeData)
                <div class="row">
                    <h4 class="text-center py-2">{{ $month }}</h4>
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
                @endforeach
                @foreach($allUserAttendanceThisMonth as $userName => $allUserAttendance)
                @include('layouts/partials/attendanceDetailModal', ['allUserAttendanceThisMonth' =>
                $allUserAttendanceThisMonth])
                @endforeach
            </div>

            <!-- All attendance tab -->
            <div class="tab-pane fade" id="allAttendance">
                <table class="table">
                    @foreach($allAttendance as $month => $data)
                    <thead>
                        <tr>
                            <h4 class="text-center">{{ \Carbon\Carbon::create()->month($month)->format('F'); }}</h4>
                        </tr>
                        <tr>
                            <td class="text-center">Tanggal</td>
                            <td class="text-center">Nama</td>
                            <td class="text-center">Bukti absen</td>
                            <td class="text-center">Lokasi absen</td>
                            <td class="text-center"></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $attendance)
                        <tr>
                            <td class="text-center" style="vertical-align: middle;">
                                {{ \Carbon\Carbon::parse($attendance->created_at)->format('d-M-y  H:i') }}</td>
                            <td class="text-center" style="vertical-align: middle;">
                                <h5>{{ $attendance->name }}</h5>
                                <p style="{{ $attendance->status === 1 ? 'color:green;' : 'color:red;' }}">
                                    {{ $attendance->status == 1 ? 'Hadir' : 'Absen' }}</p>
                            </td>
                            <td class="text-center" style="vertical-align: middle;">
                                @if($attendance->image)
                                <img class="product-img" src="{{ Storage::url($attendance->image) }}"
                                    style="max-width: 200px; max-height: 150px; width: 100%; height: 100%; object-fit: cover;">
                                <p>{{ $attendance->description }}</p>
                                @else
                                Bukti Absen tidak tersedia
                                @endif
                            </td>
                            <td class="text-center" style="vertical-align: middle;">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $attendance->latitude }},{{ $attendance->longitude }}"
                                    target="_blank" type="button" class="btn btn-primary">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Open maps
                                </a>
                            </td>
                            <td class="text-center" style="vertical-align: middle;">
                                <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                    data-target="#deleteModal{{ $attendance['id'] }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $attendance['id'] }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Absensi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin menghapus absensi ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
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
                    </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection