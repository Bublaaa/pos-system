@extends('layouts.ownerview')
@section('content')
<div class="container">
    <h2>Laporan Penggajian</h2>
    @foreach($salariesByMonth as $month)
    <div class="card">
        <div class="card-header">
            {{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Gaji Pokok</td>
                        <td>Persentasi Absen</td>
                        <td>Gaji</td>
                        <td>Cetak</td>
                        <td></td>
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
                        <td>
                            <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                data-target="#deleteModal{{ $salary->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteModal{{ $salary->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda yakin untuk menghapus catatan pembayaran gaji?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <form action="{{ route('salary.destroy', $salary) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach
</div>
@endsection