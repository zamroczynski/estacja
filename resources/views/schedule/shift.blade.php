@extends('layouts.main')

@section('content')
    <div class="container mt-5 mb-5">
        @include('layouts.alerts')
        <div class="row mb-1">
            <div class="col">
                <h1>Lista:</h1>
            </div>
            <div class="col">
                <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem"
                    href="{{ route('adminSchedule') }}" role="button">Powrót</a>
                <a class="btn btn-success btn-lg" style="float: right;" href="#shiftAddForm" role="button">Dodaj Zmianę</a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <table class="table align-middle table-striped mb-5">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Od</th>
                            <th>Do</th>
                            <th>Czas trwania</th>
                            <th>Liczba pracowników</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shifts as $shift)
                            @php
                                $hh = round($shift->duration / 3600000, 0, PHP_ROUND_HALF_DOWN);
                                $mm = ($shift->duration % 3600000) / 60000;
                            @endphp
                            <tr>
                                <th scope="row">{{ $shift->id }}</th>
                                <td>{{ $shift->name }}</td>
                                <td>{{ $shift->start }}</td>
                                <td>{{ $shift->stop }}</td>
                                <td>{{ $hh }}h {{ $mm }}m</td>
                                <td>{{ $shift->number_of_employees }}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm" href="{{ route('shiftEdit', $shift->id) }}"
                                        role="button">Edytuj</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr />
        <div class="row mt-5">
            <h1>Dodaj zmianę:</h1>
        </div>
        <div class="row mt-1">
            <form class="" id="shiftAddForm" action="{{ route('shiftAdd') }}" method="POST">
                @csrf
                <div class="form-group row mb-2">
                    <label for="name" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Nazwa</label>
                    <div class="col-sm-10">
                        <input name="name" id="name" type="text"
                            class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Nazwa..."
                            required />
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="start" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Od</label>
                    <div class="col-sm-10">
                        <input name="start" id="start" value="08:00" type="time"
                            class="form-control form-control-lg" placeholder="Od..."
                            required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="stop" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Do</label>
                    <div class="col-sm-10">
                        <input name="stop" id="stop" value="16:00" type="time"
                            class="form-control form-control-lg" placeholder="Do..."
                            required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="duration_show" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Czas
                        trwania</label>
                    <div class="col-sm-10">
                        <input name="duration_show" id="duration_show" type="text"
                            class="form-control form-control-lg @error('duration') is-invalid @enderror" disabled />
                        @error('duration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="numberOfEmployees"
                        class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Liczba pracowników</label>
                    <div class="col-sm-10">
                        <input name="numberOfEmployees" id="numberOfEmployees" min="0" type="number"
                            class="form-control form-control-lg" placeholder="Liczba pracowników..." required />
                    </div>
                </div>
                <input type="hidden" id="duration" name="duration" />
                <input type="submit" class="btn btn-success btn-lg mt-2" value="Dodaj nową zmianę" />
                <a class="btn btn-secondary btn-lg mt-2" href="{{ route('adminSchedule') }}" role="button">Powrót</a>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function parseTime(s) {
            var part = s.match(/(\d+):(\d+)(?: )?(am|pm)?/i);
            var hh = parseInt(part[1], 10);
            var mm = parseInt(part[2], 10);
            var ap = part[3] ? part[3].toUpperCase() : null;
            if (ap === "AM") {
                if (hh == 12) {
                    hh = 0;
                }
            }
            if (ap === "PM") {
                if (hh != 12) {
                    hh += 12;
                }
            }
            return {
                hh: hh,
                mm: mm
            };
        }

        function timeShift() {
            var start = $("input#start").val();
            var end = $("input#stop").val();
            start = parseTime(start);
            end = parseTime(end);
            var date1 = new Date(2000, 0, 1, start.hh, start.mm);
            var date2 = new Date(2000, 0, 1, end.hh, end.mm);

            if (date2 < date1) {
                date2.setDate(date2.getDate() + 1);
            }

            var diff = date2 - date1;

            var msec = diff;
            var hh = Math.floor(msec / 1000 / 60 / 60);
            msec -= hh * 1000 * 60 * 60;
            var mm = Math.floor(msec / 1000 / 60);
            msec -= mm * 1000 * 60;
            var result = hh.toString().concat(' godzin i ', mm.toString(), ' minut');

            $("#duration_show").val(result);
            $("#duration").val(diff);

        }
        $(document).ready(function() {
            timeShift();
        });
        $("#start").change(function() {
            timeShift();
        });
        $("#stop").change(function() {
            timeShift();
        });
    </script>
@endsection
