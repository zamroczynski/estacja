@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Podręcznik</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
            </div>
        </div>
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
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Utworzony</th>
                            <th>Ostatnia aktualizacja</th>
                            <th>Publiczny</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guides as $guide)
                            <tr>
                                <th scope="row">{{ $guide->id }}</th>
                                <td>{{ $guide->name }}</td>
                                <td>{{ $guide->created_at }}</td>
                                <td>{{ $guide->updated_at }}</td>
                                <td>{{ $guide->is_public ? 'Tak' : 'Nie' }}</td>
                                <td>
                                    @if ($guide->is_public)
                                        <a class="btn btn-secondary btn-sm" href="{{ route('adminGuideUnPublic') }}"
                                            role="button"
                                            onclick="event.preventDefault();document.getElementById('unPublic-form{{ $guide->id }}').submit();">Odpublikuj</a>
                                        <form id="unPublic-form{{ $guide->id }}"
                                            action="{{ route('adminGuideUnPublic') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $guide->id }}">
                                        </form>
                                    @else
                                        <a class="btn btn-primary btn-sm" href="{{ route('adminGuidePublic') }}"
                                            role="button"
                                            onclick="event.preventDefault();document.getElementById('public-form{{ $guide->id }}').submit();">Publikuj</a>
                                        <form id="public-form{{ $guide->id }}"
                                            action="{{ route('adminGuidePublic') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $guide->id }}">
                                        </form>
                                    @endif
                                    <a class="btn btn-warning btn-sm" href="{{ route('adminGuideEdit', $guide->id) }}"
                                        role="button">Edytuj</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
