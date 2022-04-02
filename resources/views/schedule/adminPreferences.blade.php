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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <div class="row mb-1">
        <div class="col"><h1>Wszystkie preferencje:</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('adminSchedule') }}" role="button">Powrót</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="text" id="search" class="form-control form-control-lg text-center" placeholder="Szukaj..." />
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <table id="table" class="table align-middle table-striped mb-5">
                <thead>
                <tr>
                    <th>Pracownik</th>
                    <th>Zmiana</th>
                    <th>Data</th>
                    <th>Dostępność</th>
                    <th>Opis</th>
                </tr>
                </thead>
                <tbody>
                @foreach($preferences as $preference)
                <tr>
                    <td>{{ $preference->user->first_name }} {{ $preference->user->last_name }}</td>
                    <td>{{ $preference->shift->name }}</td>
                    <td>{{ $preference->date }}</td>
                    <td>{{ $preference->available ? "Tak" : "Nie" }}</td>
                    <td>{{ $preference->description }}</td>
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

</script>
@endsection
