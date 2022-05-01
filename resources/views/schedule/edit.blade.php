@extends('layouts.main')
@section('php')
    @include('schedule.editDisplay')
@endsection
@section('content')

    <div class="container mt-5 mb-5">
        @include('layouts.alerts')
        <form action="{{ route('scheduleStore') }}" method="POST">
            @csrf
            <div class="row mb-1">
                <div class="col">
                    <h1>Edycja:</h1>
                    <input type="text" name="name"
                        class="form-control form-control-lg mt-1 mb-1 @error('name') is-invalid @enderror"
                        value="{{ $schedule->name }}" required />
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                        href="{{ route('scheduleManage') }}" role="button">Powrót</a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col">
                    @for ($row = 1; $row <= 6; $row++)
                        <table class="table align-middle table-striped mb-3">
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
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
                                                {{ polishDay($day, $month, $year) }} {{ $day }}</th>
                                            @endfor
                                        @break
                                    @endswitch
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shifts as $shift)
                                    <tr>
                                        <td class="fw-bold">
                                            <div>{{ $shift->shift->name }}</div>
                                            <div>{{ $shift->shift->start }}</div>
                                            <div>{{ $shift->shift->stop }}</div>
                                        </td>

                                        @switch($row)
                                            @case(1)
                                                @for ($day = 1; $day <= 5; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break

                                            @case(2)
                                                @for ($day = 6; $day <= 10; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break

                                            @case(3)
                                                @for ($day = 11; $day <= 15; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break

                                            @case(4)
                                                @for ($day = 16; $day <= 20; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break

                                            @case(5)
                                                @for ($day = 21; $day <= 25; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break

                                            @case(6)
                                                @for ($day = 26; $day <= $daysInMonth; $day++)
                                                    <td>
                                                        @isset($userInSchedule)
                                                            {{ loadEmployees($userInSchedule,$shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endisset
                                                        @empty($userInSchedule)
                                                            {{ displayEmployees($shift->shift->number_of_employees,$users,$shift->shift_id,$day,$month,$year,$preferences) }}
                                                        @endempty
                                                    </td>
                                                @endfor
                                            @break
                                        @endswitch
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endfor
                    <input type="hidden" name="schedule" value="{{ $schedule->id }}" />
                    <input type="hidden" name="daysInMonth" value="{{ $daysInMonth }}" />
                    <input type="hidden" name="month" value="{{ $month }}" />
                    <input type="hidden" name="year" value="{{ $year }}" />
                    <input type="submit" class="btn btn-success btn-lg form-control" value="Zapisz" />
        </form>
    </div>
    </div>
    </div>

@endsection
