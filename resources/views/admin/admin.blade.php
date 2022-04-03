@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row mt-5"><h1 class="text-center">Administracja</h1></div>
    <div class="row">
        <div class="col">
            <div class="card-group">
                <div class="card mt-5" style="">
                    <div class="card-body">
                        <a href="{{ route('adminUsers') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-address-card fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Pracownicy</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="#" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-tasks fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Zadania</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="#" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-newspaper fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Wiadomości</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="#" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-th fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Planogramy</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('adminGuide') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-book fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Podręcznik</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('adminSchedule') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-calendar-alt fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Grafik</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
