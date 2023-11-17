@extends('layouts.ownerView')

@section('content')
<div class="wrapper">
    <section class="content">
        <h2>Edit shift</h2>
        @foreach($employees as $employee)
        <div class="card">
            <div class="card-body">
                <h5>{{$employee->name}}</h5>
                <form action="{{ route('shift.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- @method('PUT') -->
                    <input type="hidden" name="userName" id="userName" value="{{$employee->name}}">
                    <div class="row">
                        @foreach($daysInWeek as $index => $dayName)
                        <div class="col-12 col-md">
                            <div class="form-group">
                                @php
                                $shiftForDay = $shifts->where('employee_name', $employee->name)
                                ->where('day_name', $dayName)->first();
                                @endphp
                                @if($shiftForDay)
                                <label for="shift[{{$index}}]">{{$dayName}}</label>
                                <select name="shift[{{$index}}]"
                                    class="form-control @error('shift[{{$index}}]') is-invalid @enderror"
                                    id="shift[{{$index}}]">
                                    <option value="siang" {{ $shiftForDay->name === 'siang' ? 'selected' : ''}}>
                                        Siang
                                    </option>
                                    <option value="sore" {{ $shiftForDay->name === 'sore' ? 'selected' : ''}}>Sore
                                    </option>
                                </select>
                                @endif
                                @error('shift[{{$index}}]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @if($shifts->where('employee_name', $employee->name)->isEmpty())
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#addModal{{ str_replace(' ', '', $employee->name) }}">
                        Masukkan shift
                    </button>
                    @else
                    <button class="btn btn-primary" type="submit">Update</button>
                    @endif
                </form>
            </div>
        </div>
        <div class="modal fade" id="addModal{{ str_replace(' ', '', $employee->name) }}" tabindex="-1" role="dialog"
            aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="max-width: 80vw;">
                <div class=" modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Masukkan shift untuk {{ $employee->name }}</h5>
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
    </section>
</div>
@endsection