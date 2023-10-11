@extends('layouts.ownerview')

@section('content')
<div class="wrapper">
    <section class="content">
        <div class="row">
            @foreach ($menus as $menu)
            <div class="col-md-2 col-6 mb-2">
                @include('layouts/partials/card', ['menu' => $menu])
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection