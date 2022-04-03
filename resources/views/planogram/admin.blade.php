@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Planogramy</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Aktualny</th>
                            <th>Obowiązuje od</th>
                            <th>Przypisany pracownik</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planograms as $planogram)
                            <tr>
                                <td>{{ $planogram->name }}</td>
                                <td>{{ $planogram->current ? "Tak" : "Nie" }}</td>
                                <td>{{ $planogram->date_start }}</td>
                                <td>{{ $planogram->user->first_name }} {{ $planogram->user->last_name }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('adminPlanogramEdit', $planogram->id) }}" role="button">Edytuj</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
