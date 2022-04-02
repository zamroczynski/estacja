@extends('layouts.main')
@section('php')
    @include('schedule.editDisplay')
@endsection
@section('content')

<div class="container mt-5 mb-5">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <form action="#">
        @csrf
    <div class="row mb-1">
        <div class="col">
            <h1>{{$scheduleName}}</h1>
        </div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('userSchedule') }}" role="button">Powrót</a>
            <button type="button" id="btn" onclick="capture()" class="btn btn-primary btn-lg" style="float: right; margin-left: 0.25rem">Pobierz grafik</button>
        </div>
    </div>
    <div class="row mb-5">
        <div id="grafikk" class="col grafik">
            @for ($row = 1; $row <= 6; $row++)
            <table class="table align-middle mb-3 table-bordered">
                <thead>
                <tr class="text-center">
                    <th>Zmiany</th>
                    @switch($row)
                        @case(1)
                            @for ($day = 1; $day <= 5; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                        @case(2)
                            @for ($day = 6; $day <= 10; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                        @case(3)
                            @for ($day = 11; $day <= 15; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                        @case(4)
                            @for ($day = 16; $day <= 20; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                        @case(5)
                            @for ($day = 21; $day <= 25; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                        @case(6)
                            @for ($day = 26; $day <= $daysInMonth; $day++)
                                @if (checkDayOff($month, $day, $year))
                                    <th class="table-danger">
                                @elseif (checkSaturday($month, $day, $year))
                                    <th class="table-warning">
                                @else
                                    <th>
                                @endif
                                {{polishDay($day, $month, $year)}} {{$day}}</th>
                            @endfor
                            @break
                    @endswitch
                </tr>
                </thead>
                <tbody>
                    @foreach ($shifts as $shift)
                    <tr>
                        <td class="fw-bold">
                            <div>{{$shift->shift->name}}</div>
                            <div>{{$shift->shift->start}}</div>
                            <div>{{$shift->shift->stop}}</div>
                        </td>

                        @switch($row)
                            @case(1)
                                @for ($day = 1; $day <= 5; $day++)
                                    <td>
                                        @isset($userInSchedule)
                                            {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                        @endisset
                                    </td>
                                @endfor
                                @break
                            @case(2)
                                @for ($day = 6; $day <= 10; $day++)
                                <td>
                                    @isset($userInSchedule)
                                        {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                    @endisset
                                </td>
                                @endfor
                                @break
                            @case(3)
                                @for ($day = 11; $day <= 15; $day++)
                                <td>
                                    @isset($userInSchedule)
                                        {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                    @endisset
                                </td>
                                @endfor
                                @break
                            @case(4)
                                @for ($day = 16; $day <= 20; $day++)
                                <td>
                                    @isset($userInSchedule)
                                        {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                    @endisset
                                </td>
                                @endfor
                                @break
                            @case(5)
                                @for ($day = 21; $day <= 25; $day++)
                                <td>
                                    @isset($userInSchedule)
                                        {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                    @endisset
                                </td>
                                @endfor
                                @break
                            @case(6)
                                @for ($day = 26; $day <= $daysInMonth; $day++)
                                <td>
                                    @isset($userInSchedule)
                                        {{currentSchedule($userInSchedule, $shift->shift->number_of_employees, $shift->shift_id, $day, $month, $year)}}
                                    @endisset
                                </td>
                                @endfor
                                @break
                        @endswitch
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endfor
        </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="http://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    function capture() {
        const captureElement = document.querySelector('.grafik')
        html2canvas(captureElement, {
            width: $(document).width()
        })
            .then(canvas => {
                canvas.style.display = 'none'
                document.body.appendChild(canvas)
                return canvas
            })
            .then(canvas => {
                const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream')
                const a = document.createElement('a')
                a.setAttribute('download', 'grafik.png')
                a.setAttribute('href', image)
                a.click()
                canvas.remove()
            })
    }
</script>
@endsection
