@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (session('error'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="row"><div class="col"><a class="btn btn-secondary btn-lg mb-2" style="float: right;" href="{{ route('edsPanel') }}">Powrót</a></div></div>
    <div class="row">

        <div class="col"><h3>Dodaj terminy:</h3></div>
        <div class="col mb-3"><a class="btn btn-primary btn-lg" style="float: right;" href="#product">Dodaj Produkt</a></div>

    </div>
    <div class="row mb-2">
        <div class="col">
                <div class="col">
                    <input type="text" id="search" class="form-control form-control-lg text-center" placeholder="Szukaj produktu..." />
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
                        @foreach($products as $item)
                        <tr>
                            <td>
                                <input class="form-check-input" type="radio" id="{{ $item->id }}" name="product_id" value="{{ $item->id }}" aria-label="Radio button for following text input">
                                <label class="form-check-label" for="{{ $item->id }}">{{$item->name}}</label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col mb-3 mt-5">
                    <input type="date" class="form-control form-control-lg text-center" name="dateInput" value="{{ date("Y-m-d"); }}" required/>
                </div>
                <div class="col mb-3">
                    <input type="number" class="form-control form-control-lg text-center" name="amount" value="" placeholder="Ilość (opcjonalnie)" />
                </div>
                <div class="col">
                    <input type="submit" class="form-control btn btn-success btn-lg" value="Dodaj termin" />
                </div>
            </form>
        </div>
    </div>
    <hr />
    <div class="row mt-5">
        <div class="col"><h3>Dodaj produkt:</h3></div>
    </div>
    <div class="row">
        <div class="col">
            <form id="product" action="{{ route('edsAddProduct') }}" method="POST">
                @csrf
                <div class="col mb-3 mt-1">
                    <input type="text" class="form-control form-control-lg text-center" name="nameProduct" placeholder="Nazwa produktu" required/>
                </div>
                <div class="col">
                    <input type="submit" class="form-control btn btn-success btn-lg" value="Dodaj produkt" />
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

var myModal = document.getElementById('productModal');
var myInput = document.getElementById('modalInput');

myModal.addEventListener('shown.bs.modal', function () {
  myInput.focus();
});
</script>
@endsection
