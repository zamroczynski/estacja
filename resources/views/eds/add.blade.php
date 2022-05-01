@extends('layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        @include('layouts.alerts')
        <div class="row mt-5 mb-3 position-relative">
            <div class="col">
                <h2 class="position-absolute top-0 start-50 translate-middle">Dodaj terminy:</h2>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('edsPanel') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <a class="btn btn-primary btn-lg" style="float: right;" href="#product" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Dodaj
                    Produkt</a>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <div class="col">
                    <input type="text" id="search" class="form-control form-control-lg text-center"
                        placeholder="Szukaj produktu..." />
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <form action="{{ route('edsAddDate') }}" method="POST">
                    @csrf
                    <table id="table" class="table text-center table-lg table-striped table-borderless">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <input class="form-check-input" type="radio" id="{{ $item->id }}"
                                            name="product_id" value="{{ $item->id }}"
                                            aria-label="Radio button for following text input">
                                        <label class="form-check-label"
                                            for="{{ $item->id }}">{{ $item->name }}</label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col mb-3 mt-5">
                        <input type="date" min="1900-01-01" max="3000-12-31" class="form-control form-control-lg text-center @error('dateInput') is-invalid @enderror" name="dateInput"
                            value="{{ date('Y-m-d') }}" required />
                    </div>
                    <div class="col mb-3">
                        <input type="number" min="1" max="1000" class="form-control form-control-lg text-center @error('amount') is-invalid @enderror" name="amount" value=""
                            placeholder="Ilość (opcjonalnie)" />
                    </div>
                    <div class="col">
                        <input type="submit" class="form-control btn btn-success btn-lg" value="Dodaj termin" />
                    </div>
                </form>
            </div>
        </div>
        <div class="modal" id="exampleModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Dodaj produkt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="product" action="{{ route('edsAddProduct') }}" method="POST">
                        <div class="modal-body">
                            @csrf
                            <div class="col mb-3 mt-1">
                                <input type="text" class="form-control form-control-lg text-center" name="nameProduct"
                                    placeholder="Nazwa produktu" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-success btn-lg" value="Dodaj produkt" />
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        </div>
                    </form>
                </div>
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

        var myModal = document.getElementById('myModal');
        var myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', function() {
            myInput.focus();
        });
    </script>
@endsection
