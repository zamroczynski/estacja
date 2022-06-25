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
        <div class="col"><h1 class="position-absolute top-0 start-50 translate-middle">Nowa Wiadomość</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ url()->previous() }}" role="button">Powrót</a>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <form action="{{ route('adStore') }}" method="POST">
                @csrf
                <input type="text" name="title" placeholder="Tytuł...." class="form-control mb-1" required>
                <div>
                    <label for="start">Ważna od:</label>
                    <input type="date" name="start" id="start" value="{{ date('Y-m-d') }}" class="form-control mb-1" required>
                </div>
                <div class="mb-4">
                    <label for="end">Ważna do:</label>
                    <input type="date" name="end" id="end" value="{{ date('Y-m-d') }}" class="form-control mb-1" required>
                </div>
                <input type="hidden" id="post_body" value="" placeholder="..." name="content">
                <trix-editor
                    input="post_body"
                    class="trix-content"
                    data-controller="trix"
                    data-action="trix-attachment-add->trix#upload">
                </trix-editor>
                <input type="submit" class="btn btn-success btn-lg mt-2" value="Zapisz"/>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    var HOST = "{{ route('uploadTrix') }}";

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
        xhr.setRequestHeader( 'X-CSRF-TOKEN', getMeta( 'csrf-token' ) );

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
