@extends('layouts.main')

@section('content')
<div class="container">
    @include('layouts.alerts')
    <div class="row mt-1"><h1 class="text-center">Grafik</h1></div>
    <div class="row">
        <div class="col">
            <div class="card-group">
                <div class="card mt-5" style="">
                    <div class="card-body">
                        <a href="{{ route('userCurrent') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-calendar-alt fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Grafik</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card-group">
                <div class="card mt-5" style="">
                    <div class="card-body">
                        <a href="{{ route('userIndividual') }}" class="link-secondary">
                            <h5 class="card-title text-center"><i class="fas fa-calendar-minus fa-7x"></i></h5>
                            <p class="card-text text-center fs-4">Indywidualny</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('userPreferences') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-tasks fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Preferencje</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card mt-5" >
                <div class="card-body">
                    <a href="{{ route('userArchives') }}" class="link-secondary">
                        <h5 class="card-title text-center"><i class="fas fa-archive fa-7x"></i></h5>
                        <p class="card-text text-center fs-4">Archiwum</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
