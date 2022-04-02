@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row mt-5"><h1 class="text-center">Grafik</h1></div>
    <div class="row">
        <div class="col">
            <div class="card-group">
                <div class="card mt-5" style="">
                    <div class="card-body">
                        <a href="{{ route('adminPreferences') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-tasks fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Preferencje</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('scheduleCreate') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-plus-circle fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Utwórz grafik</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('scheduleManage') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-edit fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Zarządzaj Grafikami</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('shiftList') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-wrench fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Konfiguruj zmiany</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
