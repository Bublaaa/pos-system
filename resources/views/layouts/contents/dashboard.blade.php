@extends('layouts.ownerview')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-2 col-6 mb-2">
                <div class="card bg-white w-100" data-toggle="modal" data-target="#menuDetailModal{{ $menu['id'] }}"
                    tabindex="1" style="overflow: hidden;">
                    <img class="product-img" src="{{ Storage::url($menu->image) }}"
                        style="max-width: 200px; max-height: 150px; width: 100%; height: auto; object-fit: cover;">
                    <div class="card-body">
                        <p class="card-title">{{ $menu['name'] }}</p>
                    </div>
                </div>
            </div>
            @include('layouts/partials/transactionDetailModal', ['menu' => $menu])
            @endforeach
        </div>
    </section>
</div>
@endsection