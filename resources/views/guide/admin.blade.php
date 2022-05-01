@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Podręcznik</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row">

            <div class="col">
                <div class="card-group">
                    <div class="card mt-5" style="">
                        <div class="card-body">
                            <a href="{{ route('adminGuideList') }}" class="link-secondary">
                                <h5 class="card-title text-center"><i class="fas fa-wrench fa-7x"></i></h5>
                                <p class="card-text text-center fs-4">Zarządzaj</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mt-5">
                    <div class="card-body">
                        <a href="{{ route('adminGuideCreate') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-plus-circle fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Utwórz instrukcje</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
