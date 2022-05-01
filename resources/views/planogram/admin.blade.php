@extends('layouts.main')

@section('content')
    <div class="container">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                    {{ $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endforeach
        @endif
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Planogramy</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button">Powrót</a>
                <a class="btn btn-success btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminPanel') }}" role="button" data-bs-target="#exampleModal"
                    data-bs-toggle="modal">Dodaj nowy planogram</a>
            </div>
        </div>
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show my-3" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row mt-2">
            <div class="col">
                <table class="table align-middle table-striped">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Aktualny</th>
                            <th>Obowiązuje od</th>
                            <th>Przypisany pracownik</th>
                            <th>Opcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($planograms as $planogram)
                            <tr>
                                <td>{{ $planogram->name }}</td>
                                <td>{{ $planogram->current ? 'Tak' : 'Nie' }}</td>
                                <td>{{ $planogram->date_start }}</td>
                                <td>
                                    @isset($planogram->user->first_name)
                                        {{ $planogram->user->first_name }}
                                        {{ $planogram->user->last_name }}
                                    @endisset
                                </td>
                                <td>
                                    @if ($planogram->current)
                                    <a class="btn btn-secondary btn-sm"
                                    href="{{ route('adminPlanogramHide', $planogram->id) }}" role="button">Ukryj</a>
                                    @else
                                    <a class="btn btn-success btn-sm"
                                    href="{{ route('adminPlanogramPublish', $planogram->id) }}" role="button">Publikuj</a>
                                    @endif
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('adminPlanogramEdit', $planogram->id) }}" role="button">Edytuj</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dodaj planogram</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="product" action="{{ route('adminPlanogramAdd') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="col mb-3 mt-1">
                            <label for="name" class="form-label">Nazwa:</label>
                            <input type="text" id="name" class="form-control form-control-lg" name="name" required />
                        </div>
                        <div class="col mb-3 mt-2">
                            <label for="user" class="form-label">Pracownik:</label>
                            <select id="user" class="form-select form-control-lg" name="user">
                                <option value="-1">-</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->first_name }}
                                        {{ $user->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col mb-3 mt-2">
                            <label for="date" class="form-label">Obowiązuje od:</label>
                            <input type="date" id="date" min="1900-01-01" max="3000-12-31"
                                class="form-control form-control-lg" name="date" required />
                        </div>
                        <div class="col mb-3 mt-2">
                            <label for="file" class="form-label">Plik: </label>
                            <input class="form-control form-control-lg" id="file" type="file" name="planogram[]" multiple
                                required>
                            <small class="fs-10">Obsługiwane formaty: PDF, JPEG, PNG</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success btn-lg" value="Dodaj planogram" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var myModal = document.getElementById('myModal');
        var myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', function() {
            myInput.focus();
        });
    </script>
@endsection
