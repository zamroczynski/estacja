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
    <div class="row mb-1">
        <div class="col"><h1>Moje preferencje:</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('userSchedule') }}" role="button">Powrót</a>
            <a class="btn btn-success btn-lg" style="float: right;" href="#preferencesAddForm" role="button">Dodaj Preferencje</a>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <table class="table align-middle table-striped mb-5">
                <thead>
                <tr>
                    <th>Zmiana</th>
                    <th>Data</th>
                    <th>Dostępność</th>
                    <th>Opis</th>
                </tr>
                </thead>
                <tbody>
                @foreach($preferences as $preference)
                <tr>
                    <td>{{ $preference->shift->name }}</td>
                    <td>{{ $preference->date }}</td>
                    <td>{{ $preference->available ? "Tak" : "Nie" }}</td>
                    <td>{{ $preference->description }}</td>
                    <td>
                        <a class="btn btn-danger btn-sm" href="{{ route('preferenceDestroy', $preference->id) }}" role="button">Usuń</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr/>
    <div class="row mt-5">
        <h1>Dodaj Preferencje:</h1>
    </div>
    <div class="row mt-1">
        <form class="" id="preferencesAddForm" action="{{ route('preferenceAdd') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <label for="shift" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Zmiana</label>
                <div class="col-sm-10">
                    <select name="shift" id="shift" class="form-control form-control-lg" required>
                        @foreach($shifts as $shift)
                        <option value="{{ $shift->id }}">{{ $shift->name }} | {{ $shift->start }} - {{ $shift->stop }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="dateP" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Data</label>
                <div class="col-sm-10">
                    <input
                        name="dateP"
                        id="dateP"
                        value="{{ date('Y-m-d') }}"
                        type="date"
                        class="form-control form-control-lg"
                        required />
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="available" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Dostępność</label>
                <div class="col-sm-10">
                    <select name="available" id="available" class="form-control form-control-lg" required>
                        <option value="0">Nie mogę przyjść</option>
                        <option value="1">Chcę przyjść</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="description" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Opis</label>
                <div class="col-sm-10">
                    <input
                        name="description"
                        id="description"
                        type="text"
                        class="form-control form-control-lg"
                        placeholder="Powód (nieobowiązkowe)"/>
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-lg mt-2" value="Dodaj nową zmianę"/>
            <a class="btn btn-secondary btn-lg mt-2" href="{{ route('userSchedule') }}" role="button">Powrót</a>
        </form>
    </div>
</div>

@endsection
