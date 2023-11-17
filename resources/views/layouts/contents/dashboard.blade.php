@extends('layouts.ownerView')

@section('content')
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
                        <p class="card-title">{{ $menu['name'] }}</p>
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