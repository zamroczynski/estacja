@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Planogramy</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card-group">
                    <div class="card mt-5" style="">
                        <div class="card-body">
                            <a href="{{ route('myPlanograms') }}" class="link-secondary">
                                <h5 class="card-title text-center"><i class="fas fa-address-card fa-7x"></i></h5>
                                <p class="card-text text-center fs-4">Moje planogramy</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mt-5">
                    <div class="card-body">
                        <a href="{{ route('userPlanograms') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-th fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Wszystkie Planogramy</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
