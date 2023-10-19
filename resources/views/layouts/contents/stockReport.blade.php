@extends('layouts.ownerview')

@section('content')
<div class="container">
    <h2>Laporan Stok</h2>
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="nameTab" data-toggle="tab" href="#nameContent">Stok tersisa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="kindTab" data-toggle="tab" href="#kindContent">Transaksi</a>
        </li>
    </ul>
    <div class="container p-3">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="nameContent">
                <h3>Estimasi Stok Tersisa</h3>
                <table class="table">
                    <thead class="thead">
                        <tr>
                            <td>Nama</td>
                            <td>Jumlah</td>
                            <td>Satuan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overAllStockData as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>{{ number_format($stock->Total, 0, ',', '.') }}</td>
                            <td>{{ $stock->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="kindContent">
                <h3>Laporan stok tiap transaksi</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <td>Jenis Transaksi</td>
                            <td>Oleh</td>
                            <td>Tanggal</td>
                            <td>Nama Bahan</td>
                            <td>Jumlah</td>
                            <td>Satuan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockDataByKind as $data)
                        <tr>
                            <td>{{ $data->kind }}</td>
                            <td>{{ $data->user_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-y \P\u\k\u\l H:i') }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ number_format($data->total, 0, ',', '.') }}</td>
                            <td>{{ $data->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection