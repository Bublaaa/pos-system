@extends('layouts.ownerview')

@section('content')
<div class="wrapper p-3">
    <section class="content">
        <div class="row">
            @foreach (range(1, 10) as $number)
            <div class="col-md-2 col-6 mb-2">
                @include('layouts/partials/card')
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection