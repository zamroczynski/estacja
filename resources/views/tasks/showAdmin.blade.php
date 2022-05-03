@extends('layouts.main')
@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Zadanie</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ redirect()->back() }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <form id="task" action="{{ route('adminTaskStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col mb-3 mt-1">
                        <label for="name" class="form-label">Tytuł:</label>
                        <input type="text" id="title" class="form-control form-control-lg" name="title"
                            value="{{ $task->title }}" disabled />
                    </div>
                    <div class="col mb-4 mt-1">
                        <label for="content" class="form-label">Treść:</label>
                        <div class="my-2" id="content"></div>
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="user" class="form-label">Pracownik:</label>
                        <select id="user" class="form-select form-control-lg" name="user" disabled>
                            <option value="-1">-</option>
                            <option value="{{ $task->user->id }}" selected>
                                {{ $task->user->first_name }} {{ $task->user->last_name }}
                            </option>
                        </select>
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="deadline" class="form-label">Zaplanowany Termin wykonania:</label>
                        <input type="date" id="deadline" min="1900-01-01" max="3000-12-31"
                            class="form-control form-control-lg" name="deadline" value="{{ $task->deadline }}" disabled />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="done" class="form-label">Czy zadanie zostało wykonane:</label>
                        <input type="text" id="done" class="form-control form-control-lg" name="done"
                            value="{{ $task->done ? "Tak" : "Nie" }}" disabled />
                    </div>
                    <label for="comment" class="form-label">Komentarz:</label>
                    <textarea name="comment" id="comment" rows="5" class="form-control" disabled>
                        {{ $task->comment }}
                    </textarea>
                    <div class="col mb-3 mt-2">
                        <label for="updated" class="form-label">Ostatnia zmiana:</label>
                        <input type="datetime" id="updated" class="form-control form-control-lg" name="updated"
                            value="{{ $task->updated_at }}" disabled />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="admin" class="form-label">Ostania zmiana dokonana przez:</label>
                        <input type="text" id="admin" class="form-control form-control-lg" name="admin"
                            value="{{ $task->last->first_name }} {{ $task->last->last_name }}" disabled />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="created" class="form-label">Zadanie utworzone:</label>
                        <input type="datetime" id="created" class="form-control form-control-lg" name="created"
                            value="{{ $task->created_at }}" disabled />
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="admin" class="form-label">Zadanie utworzone przez:</label>
                        <input type="text" id="admin" class="form-control form-control-lg" name="admin"
                            value="{{ $task->admin->first_name }} {{ $task->admin->last_name }}" disabled />
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-success btn-lg" value="Przydziel nowe zadanie" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var openEnderContent = "{{ $task->description }}";
        $('#content').html(
            $('<div/>', {
                html: openEnderContent
            }).text()
        )
    </script>
@endsection
