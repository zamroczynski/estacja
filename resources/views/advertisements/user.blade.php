@extends('layouts.main')

@section('content')
<div class="container">
    @include('layouts.alerts')
    <div class="row mt-5"><h1 class="text-center">Wiadomości</h1></div>
    <div class="row">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Tytuł</h5>
              <h6 class="card-subtitle mb-2 text-muted">Podtytuł</h6>
              <p class="card-text">
                  Wiadomość tekst
                </p>
              <a href="#" class="card-link">Pokaż więcej</a>
            </div>
          </div>
    </div>
</div>
@endsection
