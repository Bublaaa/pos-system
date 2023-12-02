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
<div class="wrapper">
    <section class="content">
        <div class="row">
            @if($menus->count() > 0)
            @foreach ($menus as $menu)
            <div class="col-md-3 col-6 ">
                <div class="card bg-white w-100" data-toggle="modal" data-target="#menuDetailModal{{ $menu['id'] }}"
                    tabindex="1" style="overflow: hidden;">
                    <img class="product-img" src="{{ asset('storage/'.$menu->image) }}"
                        style="max-width: 300px; max-height: 175px; width: 100%; height: auto; object-fit: cover;">
                    <div class="card-body">
                        <div class="row">

                            <p class="card-title">{{ $menu['name'] }}</p>
                            @for($ingredientIndex = 0; $ingredientIndex < $ingredients->where('menu_id',
                                $menu->id)->count(); $ingredientIndex++)
                                @php
                                $ingredient = $ingredients->where('menu_id',
                                $menu->id)->values()->get($ingredientIndex);
                                $ingredientName = $ingredient->name;
                                $ingredientAvailable = false;
                                @endphp

                                @for($stockIndex = 0; $stockIndex < $stocks->count();
                                    $stockIndex++)
                                    @php
                                    $stockIngredient = $stocks->values()->get($stockIndex)->name;
                                    @endphp

                                    @if($ingredientName === $stockIngredient)
                                    @php
                                    $ingredientAvailable = true;
                                    break;
                                    @endphp
                                    @endif
                                    @endfor
                                    @endfor
                                    @if($ingredientAvailable == false)
                                    <p style="color:red;"> Stok {{ $ingredientName }} Kosong</p>
                                    @endif
                        </div>

                    </div>
                </div>
            </div>
            @include('layouts/partials/transactionDetailModal', ['menus' => $menus,
            'sizeAvailable' => $sizeAvailable,
            'tempratureAvailable' => $tempratureAvailable,])
            @endforeach
            @else
            <div class="container">
                <div id="alertContainer" class="alert alert-primary">
                    Belum ada menu yang terdaftar.
                    <br>
                    <button onclick="window.location.href='{{ route('menu.create') }}'" class="btn btn-primary">
                        Tambah Menu

                </div>
            </div>
            @endif

        </div>
    </section>
</div>
@endsection