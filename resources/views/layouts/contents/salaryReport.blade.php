@extends('layouts.ownerview')
@section('content')
<div class="container">
    @foreach($salariesByMonth as $month)
    <div class="card">
        <div class="card-header">
            {{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gaji Pokok</th>
                        <th>Persentasi Absen</th>
                        <th>Gaji</th>
                        <th>Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($month->salaries as $salary)
                    <tr>
                        <td>{{ $salary->name }}</td>
                        <td>{{ $salary->basic_salary }}</td>
                        <td>{{ ($salary->attendance_precentage) }}%</td>
                        <td>{{ $salary->salary }}</td>
                        <td>
                            <form action="{{ route('print-receipt', ['id' => $salary->id]) }}" method="POST"
                                target="_blank">
                                @csrf
                                <button type="submit" class="btn btn-primary">Cetak Kwitansi</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection