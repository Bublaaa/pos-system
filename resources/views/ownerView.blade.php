@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-2">
            @include('./components/sidebar', ['userPosition' => Auth::user()->position])
        </div>
        <div class="col-lg-10">
            @include('./components/navbar', ['userPosition' => Auth::user()->position])

            <div class="container p-5">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in as owner!') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection