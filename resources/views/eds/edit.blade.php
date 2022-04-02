@extends('layouts.main')

@section('content')

<div class="container mt-3 mb-5">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <div class="alert alert-succes"></div>
    @endif
    <div class="row mb-2">
        <div class="col">
            <div class="col"><a class="btn btn-secondary mb-2" style="float: right;" href="{{ route('edsPanel') }}">Powrót</a></div>
            <div class="col">
                <input type="text" id="search" class="form-control form-control-lg text-center" placeholder="Szukaj..." />
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <table id="table" class="table align-middle table-striped">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Produkt</th>
                    <th>Ilość</th>
                    <th class="text-end">Opcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dates as $date)
                <tr class="r">
                    <td>{{ $date->date }}</td>
                    <th>{{ $date->product->name }}</th>
                    <td>{{ $date->amount }}</td>
                    <td>
                        <a href="{{ route('edsShow', $date->id) }}" class="btn btn-warning float-end ms-2 mb-2">Edytuj<i class="fas fa-wrench ms-1"></i></a>
                        @can('isAdmin')
                            <a href="{{ route('edsDestroy', $date->id) }}" class="btn btn-danger float-end">Usuń<i class="fas fa-trash-alt ms-1"></i></a>
                        @endcan
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
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#table tr.r").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
@endsection
