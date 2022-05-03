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
        <div class="row mt-3 mb-2">
            <div class="col">
                <input type="text" id="search" class="form-control form-control-lg text-center" placeholder="Szukaj..." />
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <table id="table" class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Przydzielony pracownik</th>
                            <th>Termin</th>
                            <th>Wykonanie</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            @php
                                $bg = '';
                                if (!$task->done) {
                                    $today = new DateTime('today');
                                    $matchDate = DateTime::createFromFormat('Y-m-d', $task->deadline);
                                    $matchDate->setTime(0, 0, 0);
                                    $diff = $today->diff($matchDate);
                                    $diffDays = (int) $diff->format('%R%a');
                                    if ($diffDays == 0) {
                                        $bg = 'bg-warning bg-opacity-50';
                                    } elseif ($diffDays < 0) {
                                        $bg = 'bg-danger bg-opacity-50';
                                    }
                                } else {
                                    $bg = 'bg-success bg-opacity-50';
                                }
                            @endphp
                            <tr class="{{ $bg }}">
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
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection
