@extends('layouts.main')

@section('content')

<header class="masthead text-white text-center">
    <div class="container align-items-center">
        <h1 class="masthead-heading text-dark"><span class="text-success">e</span>STACJA</h1>
        <div class="divider-custom divider-light">
            <div class="divider-custom-line  bg-dark"></div>
            <div class="divider-custom-icon  text-dark"><i class="fas fa-gas-pump"></i></div>
            <div class="divider-custom-line  bg-dark"></div>
        </div>
        @auth
        <div class="row mt-5">
            <div class="col text-dark">
                <h4>
                    Cześć {{auth()->user()->first_name}}!
                </h4>
            </div>
        </div>
        @endauth
    </div>
</header>

@endsection
