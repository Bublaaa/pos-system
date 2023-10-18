@extends('layouts.ownerview')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-3 col-12 mb-2">
                <div class="card bg-white" tabindex="1" data-toggle="modal"
                    data-target="#menuDetailModal{{ $menu['id'] }}">
                    <img class="card-img-top" src="https://placehold.co/150x100" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu['name'] }}</h5>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('menu.edit', $menu) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-edit"></i> Menu
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
<script>
@endsection