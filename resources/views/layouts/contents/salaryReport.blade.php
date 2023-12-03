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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
</head>
<div class="container">
    <h2>Laporan Penggajian</h2>
    @if($salariesByMonth->count()>0)
    @foreach($salariesByMonth as $month)
    <div class="row">
        <h5>
            {{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}
        </h5>
        @foreach($month->salaries as $salary)
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h5>{{ $salary->name }}</h5>
                        <p>Gaji pokok : Rp. {{ number_format($salary->basic_salary, 0, ',', '.') }}</p>
                        <p>Persentasi absen : {{ ($salary->attendance_precentage) }}% </p>
                        @if($salary->additional_salary)
                        <p>{{ $salary->additional_salary_name }} : Rp.
                            {{ number_format($salary->additional_salary, 0, ',', '.') }}</p>
                        @endif
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
        <div class="modal fade" id="deleteModal{{ $salary->id }}" tabindex="-1" role="dialog"
            aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Catatan Pembayaran Gaji</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus catatan ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <form action="{{ route('salary.destroy', $salary) }}" method="POST">
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
    @else
    <div id="alertContainer" class="alert alert-primary">
        Belum ada catatan pembayaran yang terdaftar.
    </div>
    @endif
</div>
@endsection