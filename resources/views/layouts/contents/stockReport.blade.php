@extends('layouts.ownerview')

@section('content')
<style>
.green-text {
    color: green;
}

.red-text {
    color: red;
}
</style>
<div class="container">
    <h2>Laporan Stok</h2>
    <!-- Tabs link -->
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
            <a class="nav-link active" id="availableTab" data-toggle="tab" href="#availableStock">Stok tersisa</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="kindTab" data-toggle="tab" href="#kindContent">Transaksi</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="buyTab" data-toggle="tab" href="#buyContent">Pembelian</a>
        </li>
    </ul>
    <!-- Tabs content -->
    <div class="container p-3">
        <div class="tab-content">
            <!-- Available Ingredients -->
            <div class="tab-pane fade show active" id="availableStock">
                <h3>Estimasi Stok Tersisa</h3>
                <table class="table" style="overflow-x:scroll;">
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
            <!-- All transaction -->
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
                        @foreach ($stockDataByKind as $stock)
                        <tr>
                            <td style="{{ $stock->kind === 'pembelian' ? 'color:green;' : 'color:red;' }}">
                                {{ $stock->kind === "pembelian" ? "Beli" : "Jual"}}</td>
                            <td>{{ $stock->user_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($stock->created_at)->format('d-M-y \P\u\k\u\l H:i') }}</td>
                            <td>{{ $stock->name }}</td>
                            <td>{{ number_format($stock->total, 0, ',', '.') }}</td>
                            <td>{{ $stock->unit }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Buy transaction -->
            <div class="tab-pane fade" id="buyContent">
                <h3>Laporan pembelian</h3>
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
                                            style="max-width: 200px; max-height: 150px; width: 100%; height: auto; object-fit: cover;">
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
            </div>
        </div>
    </div>

</div>

@endsection