@extends('layouts.main')
@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Wiadomości</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
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
                            <th>Tytuł</th>
                            <th>Autor</th>
                            <th>Publiczny</th>
                            <th>Utworzono</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advertisements as $ad)
                            @php
                                $bg = '';
                                if ($ad->priority == 'Ważny!') {
                                    $bg = 'bg-warning bg-opacity-50';
                                } elseif ($ad->priority == 'Bardzo ważne!') {
                                    $bg = 'bg-danger bg-opacity-50';
                                }
                            @endphp
                            <tr id="ad{{ $ad->id }}" class="{{ $bg }}">
                                <td>{{ $ad->title }}</td>
                                <td>
                                    {{ $ad->author->first_name }}
                                    {{ $ad->author->last_name }}
                                </td>
                                <td>{{ $ad->public ? 'Tak' : 'Nie' }}</td>
                                <td>{{ $ad->created_at }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{ route('adminAdShow', $ad->id) }}"
                                        role="button">Wyświetl</a>
                                    <a class="btn btn-warning btn-sm" href="{{ route('adminAdEdit', $ad->id) }}"
                                        role="button">Edycja</a>
                                    <a class="btn btn-danger btn-sm"
                                        onclick="destroy({{ $ad->id }})">Usuń</a>
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

        function destroy(id) {
            if (confirm("Proszę o potwierdzenie") == true) {
                axios.get("/admin/ad/destroy/" + id)
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        $('#ad' + id).hide();
                    })
                    .catch(function(error) {
                        // handle error
                        console.log(error);
                    });
            }
        }
    </script>
@endsection
