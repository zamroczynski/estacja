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
                <a class="btn btn-warning position-absolute top-0 start-0"
                    href="{{ route('adminTaskArchives') }}" role="button">Archiwum</a>
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
                            <tr id="task{{ $task->id }}" class="{{ $bg }}">
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
                                    <a class="btn btn-warning btn-sm" href="{{ route('adminTaskEdit', $task->id) }}"
                                        role="button">Edycja</a>
                                    <button class="btn btn-secondary btn-sm"
                                        onclick="archive({{ $task->id }})">Archiwizuj</button>
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

        function archive(id) {
            if (confirm("Proszę o potwierdzenie") == true) {
                axios.get("/admin/tasks/archive/" + id)
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        $('#task' + id).hide();
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                    });
            }
        }
    </script>
@endsection
