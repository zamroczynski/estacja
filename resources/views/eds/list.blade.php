@extends('layouts.main')

@section('content')
    <div class="container mt-2 mb-5">
        <div class="row mt-5 mb-3 position-relative">
            <div class="col"><h2 class="position-absolute top-0 start-50 translate-middle">Lista terminów na dzień: {{ date_format(date_create($oldDate), 'd.m.Y') }}</h2></div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('edsPanel') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Produkt</th>
                            <th>Data</th>
                            <th>Ilość</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dates as $date)
                            <tr>
                                <th scope="row">{{ $date->product->name }}</th>
                                <td>{{ $date->date }}</td>
                                <td>{{ $date->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col mt-5 mb-1">
            <hr  />
            <h3>Wybierz date:</h3>
        </div>
        <div class="row mb-5">
            <div class="col">
                <form action="{{ route('edsList') }}" method="GET">
                    <div class="col mb-3">
                        <input id="datePicker" type="date" min="1900-01-01" max="3000-12-31"
                            class="form-control form-control-lg text-center" name="date" value="{{ $oldDate }}"
                            required />
                    </div>
                    <div class="col">
                        <input type="submit" class="form-control btn btn-success btn-lg" value="Pokaż" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
    </script>
@endsection
