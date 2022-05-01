@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 mb-3"><h1 class="text-center">Podręcznik</h1></div>
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Tytuł</th>
                            <th>Utworzony</th>
                            <th>Ostatnia aktualizacja</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guides as $guide)
                            <tr>
                                <td>{{ $guide->name }}</td>
                                <td>{{ $guide->created_at }}</td>
                                <td>{{ $guide->updated_at }}</td>
                                <td>
                                    <a class="btn btn-success btn-sm" href="{{ route('guideShow', $guide->id) }}"
                                        role="button">Pokaż</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
