@extends('layouts.main')

@section('content')

<div class="row mt-2 mx-2">
    <div class="col">
        <div class="list-group">
            @isset($notifications)
                @foreach ($notifications as $notification)
                    @if ($notification->read_at == NULL)
                        <a href="#" data-id="{{$notification->id}}" class="list-group-item list-group-item-action bg-primary unRead bg-opacity-50 px-5 mb-3 rounded-pill">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$notification->data['name']}}</h5>
                                <small>{{$notification->created_at}}</small>
                            </div>
                            <p class="mb-1">Moduł: {{$notification->data['module']}}</p>
                            <small class="clickHere">Kliknij aby odczytać</small>
                        </a>
                    @else
                        <a href="#" class="list-group-item list-group-item-action bg-light px-5 mb-3 rounded-pill">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{$notification->data['name']}}</h5>
                                <small>{{$notification->created_at}}</small>
                            </div>
                            <p class="mb-1">Moduł: {{$notification->data['module']}}</p>
                        </a>
                    @endif
                @endforeach
            @endisset
            @empty($notifications)
                <li class="list-group-item">Brak powiadomień</li>
            @endempty
        </div>
    </div>
</div>

@endsection
@section('js')
<script>
    function readNotification(id = null) {
        if (id == null) {
            console.warning('Brak id powiadomienia!');
        } else {
            return $.ajax("{{ route('readNotification') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id
                }
            });
        }
    }

    $(function() {
        $('.unRead').click(function() {
            let request = readNotification($(this).data('id'));

            request.done(() => {
                $(this).removeClass(['unRead', 'bg-primary', 'bg-opacity-50']).addClass('bg-light');
                $(this).children('small.clickHere').remove();
            });
        });
    });
</script>
@endsection
