@extends('layouts.ownerView')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-3 col-6 ">
                <div class="card bg-white w-100" data-toggle="modal" data-target="#menuDetailModal{{ $menu['id'] }}"
                    tabindex="1" style="overflow: hidden;">
                    <img class="product-img" src="{{ Storage::url($menu->image) }}"
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
        </div>
    </section>
</div>
@endsection