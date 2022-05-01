@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Planogramy</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('planograms') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Obowiązuje od</th>
                            <th>Odpowiedzialny pracownik</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planograms as $planogram)
                            <tr>
                                <td>{{ $planogram->name }}</td>
                                <td>{{ $planogram->date_start }}</td>
                                <td>
                                    @isset($planogram->user->first_name)
                                        {{ $planogram->user->first_name }}
                                        {{ $planogram->user->last_name }}
                                    @endisset
                                </td>
                                <td>
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('planogramShow', $planogram->id) }}" role="button">Pokaż</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
