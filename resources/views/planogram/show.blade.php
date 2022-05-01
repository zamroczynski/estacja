@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h2 class="position-absolute top-0 start-50 translate-middle">Edytuj Planogram</h2>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ url()->previous() }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <input type="hidden" name="id" value="{{ $planogram->id }}">
                <div class="col mb-3 mt-1">
                    <label for="name" class="form-label">Nazwa:</label>
                    <input type="text" id="name" class="form-control form-control-lg" name="name"
                        value="{{ $planogram->name }}" disabled />
                </div>
                <div class="col mb-3 mt-2">
                    <label for="user" class="form-label">Pracownik:</label>
                    <select id="user" class="form-select form-control-lg" name="user" disabled>
                        <option value="-1">{{$planogram->user->first_name}} {{$planogram->user->last_name}}</option>
                    </select>
                </div>
                <div class="col mb-3 mt-2">
                    <label for="date" class="form-label">Obowiązuje od:</label>
                    <input type="date" id="date" min="1900-01-01" max="3000-12-31" value="{{ $planogram->date_start }}"
                        class="form-control form-control-lg" name="date" disabled />
                </div>
                @isset($files)
                    <h4>Przypisane pliki:</h4>
                    @foreach ($files as $file)
                        <div class="list-group mb-3" id="file{{ $file->id }}">
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <p class="mb-1">Nazwa pliku: {{ $file->name }}</p>
                                </div>
                                <small>Dodano: {{ $file->created_at }}</small>
                                <p><a class="link-success" target="_blank"
                                        href="{{ route('planogramDownload', $file->id) }}">Pobierz</a></p>
                            </div>
                        </div>
                    @endforeach
                @endisset
                <div>
                    <a class="btn btn-secondary btn-lg" href="{{ url()->previous() }}" role="button">Powrót</a>
                </div>
            </div>
        </div>
    </div>
@endsection
