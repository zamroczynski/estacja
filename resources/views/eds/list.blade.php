@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">
    <div class="row"><div class="col"><a class="btn btn-secondary btn-lg mb-2" style="float: right;" href="{{ route('edsPanel') }}">Powrót</a></div></div>
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
                @foreach($dates as $date)
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
    <div class="col mt-5"><h3>Wybierz date:</h3></div>
    <div class="row mt-1">

        <div class="col">
            <form action="{{ route('edsList') }}" method="GET">
                @csrf
                <div class="col mb-3">
                    <input type="date" class="form-control form-control-lg text-center" name="date" value="{{ $oldDate }}" required/>
                </div>
                <div class="col">
                    <input type="submit" class="form-control btn btn-success btn-lg" value="Pokaż" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
