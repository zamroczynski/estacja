@extends('layouts.main')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
    <style>
        .trix-content img {
            width: 300px;
            height: 300px;
        }

    </style>
@endsection
@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Zadania</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
                <a class="btn btn-success btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminTaskCreate') }}" role="button">Przydziel nowe zadanie</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Przydzielony pracownik</th>
                            <th>Termin oddania</th>
                            <th>Wykonanie</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>
                                    {{ $task->user->first_name }}
                                    {{ $task->user->last_name }}
                                </td>
                                <td>{{ $task->deadline }}</td>
                                <td>{{ $task->done ? 'Tak' : 'Nie' }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('adminTaskShow', $task->id) }}"
                                        role="button">Wyświetl</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script></script>
@endsection
