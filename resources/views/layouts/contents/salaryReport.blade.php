@extends('layouts.ownerview')
@section('content')
<div class="container">
    <h2>Laporan Penggajian</h2>
    @foreach($salariesByMonth as $month)
    <div class="row">
        <h5>
            {{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}
        </h5>
        @foreach($month->salaries as $salary)
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5>{{ $salary->name }}</h5>
                        <p>Gaji pokok : Rp. {{ number_format($salary->basic_salary, 0, ',', '.') }}</p>
                        <p>Persentasi absen : {{ ($salary->attendance_precentage) }}% </p>
                        <h5>Rp. {{ number_format($salary->salary, 0, ',', '.') }}</h5>
                        <div class="row">
                            <div class="col-8 col-md-6">
                                <form action="{{ route('print-receipt', ['id' => $salary->id]) }}" method="POST"
                                    target="_blank">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Cetak Kwitansi</button>
                                </form>
                            </div>
                            <div class="col-1 col-md-1">
                                <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                    data-target="#deleteModal{{ $salary->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endforeach
</div>
@endsection