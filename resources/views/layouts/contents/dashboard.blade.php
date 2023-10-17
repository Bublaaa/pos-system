@extends('layouts.ownerview')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-2 col-6 mb-2">
                <div class="card bg-white w-100" data-toggle="modal" data-target="#menuDetailModal{{ $menu['id'] }}"
                    tabindex="1">
                    <img class="card-img-top" src="https://placehold.co/150x100" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu['name'] }}</h5>
                    </div>
                </div>
            </div>
            @include('layouts/partials/menuDetailModal', ['menu' => $menu])
            @endforeach
        </div>
    </section>
</div>
@endsection