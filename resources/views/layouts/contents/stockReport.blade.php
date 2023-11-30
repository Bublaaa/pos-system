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
    <h2>Laporan Stok</h2>
    <!-- Tabs link -->
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="availableTab" data-toggle="tab" href="#availableStock"
                style="color: black;">Stok tersisa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="kindTab" data-toggle="tab" href="#kindContent" style="color: black;">Transaksi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="buyTab" data-toggle="tab" href="#buyContent" style="color: black;">Pembelian</a>
        </li>
    </ul>
    <!-- Tabs content -->
    <div class="container p-3">
        <div class="tab-content">
            <!-- Available Ingredients -->
            <div class="tab-pane fade show active" id="availableStock">
                <h3>Estimasi Stok Tersisa</h3>
                <div class="row">
                    @if($overAllStockData->count()>0)
                    @foreach ($overAllStockData as $stock)
                    <div class="col-12 col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <p>{{ $stock->name }}</p>
                                        <h5>{{ number_format($stock->Total, 0, ',', '.') }} {{ $stock->unit }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div id="alertContainer" class="alert alert-primary">
                        Belum ada stock yang tercatat.
                        <br>
                        <button onclick="window.location.href='{{ route('stock.create') }}'" class="btn btn-primary">
                            Tambah Stok
                    </div>
                    @endif
                </div>
            </div>
            <!-- All transaction -->
            <div class="tab-pane fade" id="kindContent">
                <h3>Laporan stok tiap transaksi</h3>
                @if($stockDataByKind->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <td>Jenis Transaksi</td>
                            <td>Oleh</td>
                            <td>Nama Bahan</td>
                            <td>Jumlah</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stockDataByKind as $stock)
                        <tr>
                            <td>
                                <p style="{{ $stock->kind === 'pembelian' ? 'color:green;' : 'color:red;' }}">
                                    {{ $stock->kind === 'pembelian' ? 'Beli' : 'Jual' }}</p>
                                <p>{{ \Carbon\Carbon::parse($stock->created_at)->format('d-M-y \P\u\k\u\l H:i') }}</p>
                            </td>
                            <td>{{ $stock->user_name }}</td>
                            <td>{{ $stock->name }}</td>
                            <td>{{ number_format($stock->total, 0, ',', '.') }} {{ $stock->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada transaksi yang tercatat.
                </div>
                @endif
            </div>
            <!-- Buy transaction -->
            <div class="tab-pane fade" id="buyContent">
                <h3>Laporan pembelian</h3>
                @if($buyTransaction->count()>0)
                <div class="row">
                    @foreach($buyTransaction as $transaction)
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <p>Tanggal :
                                            {{ \Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y') }}
                                        </p>
                                        @if($transaction->image)
                                        <img class="product-img" src="{{ Storage::url($transaction->image) }}"
                                            style=" width: 100%; height: auto; object-fit: cover;">
                                        @else
                                        <p>Bukti Transaksi tidak tersedia</p>
                                        @endif
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <h5>Pembelian dilakukan oleh :</h5>
                                        <p>{{$transaction->user_name}}</p>
                                        <h5>Bahan yang dibeli :</h5>
                                        @foreach($boughtStocks as $stock)
                                        @if($transaction->id == $stock->transaction_id)
                                        <p>- {{$stock->name}} {{number_format($stock->quantity, 0, ',', '.')}}
                                            {{$stock->unit}}</p>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada pembelian stok yang tercatat.
                    <br>
                    <button onclick="window.location.href='{{ route('stock.create') }}'" class="btn btn-primary">
                        Tambah Stok
                </div>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection