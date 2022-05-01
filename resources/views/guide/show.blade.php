@extends('layouts.main')

@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5 position-relative">
            <div class="col">
                <h1 class="position-absolute top-0 start-50 translate-middle">Podręcznik</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('guideList') }}" role="button">Powrót</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <h3 class="text-center">{{ $guide->name }}</h3>
                <div id="content"></div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: left; margin-left: 0.25rem"
                    href="{{ route('guideList') }}" role="button">Powrót</a>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var openEnderContent = "{{ $guide->text }}";
        $('#content').html(
            $('<div/>', {
                html: openEnderContent
            }).text()
        )
    </script>
@endsection
