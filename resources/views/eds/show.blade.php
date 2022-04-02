@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">

    <div class="row">
        <div class="col"><h3>Edytuj:</h3></div>
        <div class="col mb-3"><a class="btn btn-secondary" style="float: right;" href="{{ route('edsEdit') }}">Powrót</a></div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{ route('edsUpdate', $dateE->id) }}" method="POST">
                @csrf
                <table id="table" class="table text-center table-lg table-striped table-borderless">
                    <thead>
                        <tr>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $item)
                        <tr>
                            <td>
                                <input class="form-check-input" type="radio" id="{{ $item->id }}" name="product_id" value="{{ $item->id }}" {{($dateE->product_id==$item->id)? "checked" : "" }} required />
                                <label class="form-check-label" for="{{ $item->id }}">{{$item->name}}</label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col mb-3 mt-5">
                    <input type="date" class="form-control form-control-lg text-center" name="dateInput" value="{{ $dateE->date }}" required/>
                </div>
                <div class="col mb-3">
                    <input type="number" class="form-control form-control-lg text-center" name="amount" value="{{ $dateE->amount }}" placeholder="Ilość (opcjonalnie)" />
                </div>
                <div class="col">
                    <input type="hidden" name="id" value="{{ $dateE->id }}" />
                    <input type="submit" class="form-control btn btn-success btn-lg" value="Zapisz" />
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
