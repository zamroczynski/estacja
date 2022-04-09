@extends('layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mt-3">
            <div class="col">
                <a class="btn btn-secondary btn-lg mt-2" style="float: right;" href="{{ route('adminSchedule') }}"
                    role="button">Powrót</a>
            </div>
        </div>
        <div class="row mt-5">
            <h1>Utwórz nowy grafik:</h1>
        </div>
        <div class="row mt-1">
            <form action="{{ route('scheduleSave') }}" method="POST">
                @csrf
                <div class="form-group row mb-2">
                    <label for="name" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Nazwa</label>
                    <div class="col-sm-10">
                        <input name="name" id="name" type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Nazwa..."
                            required />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="month" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Miesiąc</label>
                    <div class="col-sm-10">
                        @php
                            $year = date('Y');
                        @endphp
                        <select class="form-select fs-5" size="12" name="month" required>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 1, 1)) }}">Styczeń</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 2, 1)) }}">Luty</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 3, 1)) }}">Marzec</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 4, 1)) }}">Kwiecień</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 5, 1)) }}">Maj</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 6, 1)) }}">Czerwiec</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 7, 1)) }}">Lipiec</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 8, 1)) }}">Sierpień</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 9, 1)) }}">Wrzesień</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 10, 1)) }}">Październik</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 11, 1)) }}">Listopad</option>
                            <option value="{{ date('m-d', mktime(0, 0, 0, 12, 1)) }}">Grudzień</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="year" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Rok</label>
                    <div class="col-sm-10">
                        <input name="year" id="year" type="number" min="2022" max="2999" step="1"
                            class="form-control form-control-lg" required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Zmiany</label>
                    <div class="col-sm-10">
                        @foreach ($shifts as $shift)
                            <div class="form-check fs-5">
                                <input class="form-check-input" type="checkbox" value="{{ $shift->id }}" name="shift[]"
                                    id="{{ $shift->name }}">
                                <label class="form-check-label" for="{{ $shift->name }}">
                                    {{ $shift->name }} | {{ $shift->start }} - {{ $shift->stop }} | Liczba
                                    pracowników: {{ $shift->number_of_employees }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <input type="submit" class="btn btn-success btn-lg mt-2 form-control" value="Utwórz grafik" />
            </form>
        </div>
    </div>
@endsection
