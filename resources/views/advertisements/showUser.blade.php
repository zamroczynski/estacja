@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Wiadomości</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ url()->previous() }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <h6 class="text-center">{{ $ad->title }}</h6>
                <div class="text-center mb-3 small">
                    Ważna od <b>{{ $ad->start }}</b> do <b>{{ $ad->end}}</b>
                </div>
                <div class="text-justify" id="content"></div>
                <div class="mt-2">
                    @if ($ad->priority != 'Normalny')
                        Priorytet: {{$ad->priority}}
                    @endif
                </div>
                <div class="float-end small">Autor: {{$ad->author->first_name}} {{$ad->author->last_name}}</div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var openEnderContent = "{{ $ad->content }}";
        $('#content').html(
            $('<div/>', {
                html: openEnderContent
            }).text()
        )
    </script>
@endsection
