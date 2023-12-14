@extends('layouts.ownerView')

@section('content')

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
</head>
<div class="wrapper">
    <section class="content">
        <div class="container">
            <h2>Shift Karyawan</h2>
            <p>Mendaftarkan shift karyawan perlu dilakukan tiap bulan</p>

            @if($employees->count() > 0)
            <div class="row">
                @foreach($employees as $employee)
                @if($shifts->where('employee_name', $employee->name)->isEmpty())
                <div class="col-12 col-md-4">
                    <div class="alert alert-light">
                        <h5>{{$employee->name}}</h5>
                        <p> Shift karyawan belum terdaftar.</p>
                        <input type="hidden" name="userName" id="userName" value="{{$employee->name}}">
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#addModal{{ str_replace(' ', '', $employee->name) }}">
                            Masukkan shift
                        </button>
                    </div>
                </div>
                @endif
                <!-- Add shift modal -->
                <div class="modal fade" id="addModal{{ str_replace(' ', '', $employee->name) }}" tabindex="-1"
                    role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width: 80vw;">
                        <div class=" modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addModalLabel">Masukkan shift untuk {{ $employee->name }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('shift.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <input type="hidden" name="userName" id="userName" value="{{$employee->name}}">
                                        @foreach($daysInWeek as $index => $dayName)
                                        <div class="col-12 col-md">
                                            <div class="form-group">
                                                <label for="shift[{{$index}}]">{{$dayName}}</label>
                                                <select name="shift[{{$index}}]"
                                                    class="form-control @error('shift[{{$index}}]') is-invalid @enderror"
                                                    id="shift[{{$index}}]">
                                                    <option value="siang">Siang
                                                    </option>
                                                    <option value="sore">Sore
                                                    </option>
                                                </select>
                                                @error('shift[{{$index}}]')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            <div id="alertContainer" class="alert alert-primary">
                Belum ada akun karyawan yang terdaftar.
                <br>
                <button onclick="window.location.href='{{ route('register') }}'" class="btn btn-primary">
                    Tambah Akun
            </div>
            @endif
            <!-- Schedule -->
            <div class="card" style="overflow-x: auto;">
                <div class="row pt-3 pl-5">
                    Bulan {{$month_name}}
                </div>
                <div class="card-body">
                    <table class="table">
                        <th></th>
                        @for($day = 1; $day <= $totalDaysInMonth; $day++) <td class="text-center">
                            {{$datesArray[$day-1]}}<br>{{ $day }}
                            </td>
                            @endfor
                            <tr>
                                <td>Siang</td>
                                @for($day = 1; $day <= $totalDaysInMonth; $day++) <td>@foreach($shifts->where('name',
                                    'siang') as $shift)
                                    @if(date('j', strtotime($shift->created_at)) == $day)
                                    <div class="{{ $shift->updated_at->format('Y-m-d') === $now->format('Y-m-d') ? 'alert alert-success' : 'alert alert-primary' }}"
                                        style="cursor: pointer;" data-toggle="modal"
                                        data-target="#updateModal{{ str_replace(' ', '', $shift->employee_name) . '-' . $shift->created_at->format('Y-m-d') }}">
                                        <p>{{$shift->employee_name}}</p>
                                    </div>
                                    @endif
                                    @endforeach
                                    </td>
                                    @endfor
                            </tr>
                            <tr>
                                <td>Sore</td>
                                @for($day = 1; $day <= $totalDaysInMonth; $day++) <td style="width: 100px;">
                                    @foreach($shifts->where('name',
                                    'sore') as $shift)
                                    @if(date('j', strtotime($shift->created_at)) == $day)
                                    <div class="{{ $shift->updated_at->format('Y-m-d') === $now->format('Y-m-d') ? 'alert alert-success' : 'alert alert-primary' }}"
                                        style="cursor: pointer;" data-toggle="modal"
                                        data-target="#updateModal{{ str_replace(' ', '', $shift->employee_name) . '-' . $shift->created_at->format('Y-m-d') }}">
                                        <p>{{$shift->employee_name}}</p>
                                    </div>
                                    @endif
                                    @endforeach
                                    </td>
                                    @endfor
                            </tr>
                    </table>
                </div>
                <div class="row px-5">
                    <div class="col-12 col-md-4">
                        <p>Tekan kotak nama untuk mengubah shift</p>
                    </div>
                    <div class="col-12 col-md-4">

                    </div>
                    <div class="col-12 col-md-2">
                        <div class="alert alert-primary">

                        </div>
                        <p>Sudah ditambahkan</p>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="alert alert-success">

                        </div>
                        <p>Baru ditambahkan / diubah hari ini</p>
                    </div>

                </div>
            </div>

            <!-- Update shift modal -->
            @foreach($shifts as $shift)
            <div class="modal fade"
                id="updateModal{{ str_replace(' ', '', $shift->employee_name) . '-' . $shift->created_at->format('Y-m-d') }}"
                tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document" style="max-width: 40vw;">
                    <div class=" modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateModalLabel">Ubah shift untuk {{ $shift->employee_name }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form
                            action="{{ route('shift.update', ['shift'=>$shift,'name' => $shift->employee_name, 'date' => $shift->created_at]) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="userName" id="userName" value="{{$employee->name}}">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="shiftName"> Tanggal
                                                {{$shift->created_at->format('d-m-y')}}</label>
                                            <select name="shiftName"
                                                class="custom-select @error('shiftName') is-invalid @enderror"
                                                id="shiftName">
                                                <option value="siang" {{$shift->name === 'siang' ? 'selected' : ''}}>
                                                    Siang
                                                </option>
                                                <option value="sore" {{$shift->name === 'sore' ? 'selected' : ''}}>Sore
                                                </option>
                                            </select>
                                            @error('shiftName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection