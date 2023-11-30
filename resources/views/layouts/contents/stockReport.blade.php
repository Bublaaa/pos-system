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
                @if($transactions->count() > 0)
                @foreach ($transactions as $transaction)
                @if($transaction->kind == 'pembelian')
                <!-- Buy card -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-11 col-md-11">
                                <div class="alert alert-success">
                                    <p>{{ ucwords($transaction->kind) }}</p>
                                </div>
                            </div>
                            <div class="col-1 col-md-1">
                                <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                    data-target="#deleteModal{{ $transaction->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="col-12 col-md-4">
                                <p>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-M-y \P\u\k\u\l H:i') }}
                                </p>

                            </div>
                            <div class="col-12 col-md-4">
                                <p>{{ $transaction->user_name }}</p>
                            </div>
                            <div class="col-12 col-md-4">
                                @foreach($stocks->where('kind' , 'pembelian') as $stock)
                                @if($stock->transaction_id == $transaction->id)
                                <h5> {{ $stock->name }} {{$stock->quantity}} {{$stock->unit}} </h5>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @else
                @php
                $menu = $menus->where('id',$transaction->menu_id)->first();
                @endphp
                <!-- Sale -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-11 col-md-11">
                                <div class="alert alert-danger">
                                    <p>{{ ucwords($transaction->kind) }}</p>
                                </div>
                            </div>
                            <div class="col-1 col-md-1">
                                <button type="button" class="btn btn-danger remove-row" data-toggle="modal"
                                    data-target="#deleteModal{{ $transaction->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="col-12 col-md-4">
                                <p>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-M-y \P\u\k\u\l H:i') }}
                                </p>
                            </div>
                            <div class="col-12 col-md-4">
                                <p>{{ $transaction->user_name }}</p>
                            </div>
                            <div class="col-12 col-md-4">
                                @if($menu)
                                <h5> {{ $transaction->quantity }} {{ $menu->name }}</h5>
                                @if($transaction->temprature)
                                <p>{{ $transaction->size }} - {{ $transaction->temprature }}</p>
                                @endif
                                @else
                                <p>Menu sudah dihapus</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @foreach($sortedStock->where('transaction_id',$transaction->id) as $stock)
                        <div class="row">
                            <div class="col-6 col-md-6">
                                <p>{{ $stock->name }}</p>
                            </div>
                            <div class="col-6 col-md-6">
                                <p>{{ $stock->total_quantity }} {{ $stock->unit }} </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                <!-- delete modal -->
                <div class="modal fade" id="deleteModal{{ $transaction->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Catatan Transaksi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Apakah anda yakin ingin menghapus catatan transaksi ini?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form action="{{ route('stock.destroy', $transaction->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
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
                                        @foreach($stocks as $stock)
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