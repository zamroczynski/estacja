@extends('layouts.main')
@section('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/trix.css') }}">
    <style>
        .trix-content img {
            width: 300px;
            height: 300px;
        }

    </style>
@endsection
@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Przydziel nowe zadanie</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminTasks') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <form id="task" action="{{ route('adminTaskStore') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col mb-3 mt-1">
                        <label for="name" class="form-label">Tytuł:</label>
                        <input type="text" id="title" class="form-control form-control-lg" name="title"
                            @isset($task) value="{{ $task->title }}" @endisset required />
                    </div>
                    <div class="col mb-3 mt-1">
                        <label for="description" class="form-label">Treść:</label>
                        <input type="hidden" id="post_body" @isset($task) value="{{ $task->description }}" @endisset placeholder="..." name="content">
                        <trix-editor id="description" input="post_body" class="trix-content" data-controller="trix"
                            data-action="trix-attachment-add->trix#upload">
                        </trix-editor>
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="user" class="form-label">Pracownik:</label>
                        <select id="user" class="form-select form-control-lg" name="user" required>
                            <option value="-1">-</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }}
                                    {{ $user->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3 mt-2">
                        <label for="deadline" class="form-label">Termin wykonania:</label>
                        <input type="date" id="deadline" min="1900-01-01" max="3000-12-31"
                            class="form-control form-control-lg" name="deadline" required />
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
        var myModal = document.getElementById('myModal');
        var myInput = document.getElementById('myInput');

        myModal.addEventListener('shown.bs.modal', function() {
            myInput.focus();
        });
    </script>
    <script type="text/javascript">
        var HOST = "{{ route('adminUploadTrix') }}";

        addEventListener("trix-attachment-add", function(event) {
            if (event.attachment.file) {
                uploadFileAttachment(event.attachment)
            }
        })

        function uploadFileAttachment(attachment) {
            uploadFile(attachment.file, setProgress, setAttributes)

            function setProgress(progress) {
                attachment.setUploadProgress(progress)
            }

            function setAttributes(attributes) {
                attachment.setAttributes(attributes)
            }
        }

        function uploadFile(file, progressCallback, successCallback) {
            var formData = createFormData(file);
            var xhr = new XMLHttpRequest();

            xhr.open("POST", HOST, true);
            xhr.setRequestHeader('X-CSRF-TOKEN', getMeta('csrf-token'));

            xhr.upload.addEventListener("progress", function(event) {
                var progress = event.loaded / event.total * 100
                progressCallback(progress)
            })

            xhr.addEventListener("load", function(event) {
                var attributes = {
                    url: xhr.responseText,
                    href: xhr.responseText + "?content-disposition=attachment"
                }
                successCallback(attributes)
            })

            xhr.send(formData)
        }

        function createFormData(file) {
            var data = new FormData()
            data.append("Content-Type", file.type)
            data.append("file", file)
            return data
        }

        function getMeta(metaName) {
            const metas = document.getElementsByTagName('meta');

            for (let i = 0; i < metas.length; i++) {
                if (metas[i].getAttribute('name') === metaName) {
                    return metas[i].getAttribute('content');
                }
            }

            return '';
        }
    </script>
@endsection
