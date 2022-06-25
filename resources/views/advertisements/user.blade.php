@extends('layouts.main')
@section('content')
    <div class="container">
        @include('layouts.alerts')
        <div class="row mt-5">
            <h1 class="text-center">Wiadomości</h1>
        </div>
        <div class="row">
            @foreach ($advertisements as $ad)
                <div class="card mt-3">
                    @if ($ad->priority != 'Normalny')
                        <div class="card-header">
                            {{ $ad->priority }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">{{ $ad->title }}</h5>
                            </div>
                            <div class="col">
                                <h6 class="card-subtitle mb-2 text-muted float-end">
                                    Obowiązuje od {{ $ad->start }} do {{ $ad->end }}
                                </h6>
                            </div>
                        </div>
                        <div class="card-text" id="content{{ $ad->id }}"></div>
                        <div class="row mt-2">
                            <div class="col">
                                <a href="{{ route('userAdShow', $ad->id) }}" class="card-link">Pokaż więcej</a>

                            </div>
                            <div class="col">
                                <div class="float-end">
                                    <a href="#" class="card-link">Komentarze (0)</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <script>
                    var id = "{{ $ad->id }}";
                    var content = "{{ Str::limit($ad->content, 100) }}";
                    try {
                        $('#content' + id).html(
                            $('<div/>', {
                                html: content
                            }).text()
                        )
                    } catch (error) {
                        console.error(error)
                    }
                </script>
            @endforeach
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="d-grid gap-2">
                    <a class="btn btn-success btn-lg" href="{{ route('adCreate') }}" role="button">
                        Dodaj nową wiadomość
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
