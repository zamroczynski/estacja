@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h2 class="position-absolute top-0 start-50 translate-middle">Edytuj Planogram</h2>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ url()->previous() }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <form id="product" action="{{ route('adminPlanogramUpdate') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $planogram->id }}">
                    <div class="col mb-3 mt-1">
                        <label for="name" class="form-label">Nazwa:</label>
                        <input type="text" id="name" class="form-control form-control-lg" name="name"
                            value="{{ $planogram->name }}" required />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="user" class="form-label">Pracownik:</label>
                        <select id="user" class="form-select form-control-lg" name="user">
                            <option value="-1">-</option>
                            @foreach ($users as $user)
                                @if ($planogram->user_id === $user->id)
                                    <option value="{{ $user->id }}" selected>{{ $user->first_name }}
                                        {{ $user->last_name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }}
                                        {{ $user->last_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="date" class="form-label">Obowiązuje od:</label>
                        <input type="date" id="date" min="1900-01-01" max="3000-12-31"
                            value="{{ $planogram->date_start }}" class="form-control form-control-lg" name="date"
                            required />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="file" class="form-label">Plik: </label>
                        <input class="form-control form-control-lg" id="file" type="file" name="planogram[]" multiple>
                        <small class="fs-10">Obsługiwane formaty: PDF, JPEG, PNG</small>
                    </div>
                    @isset($files)
                        <h4>Przypisane pliki:</h4>
                        @foreach ($files as $file)
                            <div class="list-group mb-3" id="file{{ $file->id }}">
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">Nazwa pliku: {{ $file->name }}</p>
                                        <button type="button" class="border-0 bg-transparent" role="button"
                                            onclick="delete_file({{ $file->id }})"><i
                                                class="fas fa-trash fa-lg link-danger"></i></button>
                                    </div>
                                    <small>Dodano: {{ $file->created_at }}</small>
                                    <p><a class="link-success" target="_blank" href="{{ route('planogramDownload', $file->id) }}">Pobierz</a></p>
                                </div>
                            </div>
                        @endforeach
                    @endisset

                    <div>
                        <input type="submit" class="btn btn-success btn-lg" value="Zapisz" />
                        <a class="btn btn-secondary btn-lg" href="{{ url()->previous() }}" role="button">Powrót</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function delete_file(id) {
            axios.get('/admin/planograms/file/delete/' + id)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    $('#file' + id).hide();
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                });
        }
    </script>
@endsection
