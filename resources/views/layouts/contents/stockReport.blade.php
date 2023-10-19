@extends('layouts.ownerview')

@section('content')
<div class="container">
    <h2>Laporan Stok</h2>
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="nameTab" data-toggle="tab" href="#nameContent">Stok tersisa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="kindTab" data-toggle="tab" href="#kindContent">Jenis transaksi</a>
        </li>
    </ul>
    <div class="container p-3">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="nameContent">
                <h3>Estimasi Stok Tersisa</h3>
                <table class="table">
                    <thead class="thead" style="border-bottom: none;">
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overAllStockData as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>{{ $stock->Total }}</td>
                            <td>{{ $stock->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="kindContent">
                <h3>Sortir berdasarkan jenis transaksi</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kind</th>
                            <th>Name</th>
                            <th>Total Quantity</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockDataByKind as $data)
                        <tr>
                            <td>{{ $data->kind }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->total }}</td>
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