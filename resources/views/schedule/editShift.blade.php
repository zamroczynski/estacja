@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">

    <div class="row">
        <div class="col"><h3>Edytuj:</h3></div>
        <div class="col mb-3"><a class="btn btn-secondary" style="float: right;" href="{{ route('shiftList') }}">Powrót</a></div>
    </div>
    <div class="row">
        <div class="col">
            <form class="" id="shiftEditForm" action="{{ route('shiftUpdate', $shift->id) }}" method="POST">
                @csrf
                <div class="form-group row mb-2">
                    <label for="name" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Nazwa</label>
                    <div class="col-sm-10">
                        <input
                            name="name"
                            id="name"
                            value="{{$shift->name}}"
                            type="text"
                            class="form-control form-control-lg"
                            placeholder="Nazwa..."
                            required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="start" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Od</label>
                    <div class="col-sm-10">
                        <input
                            name="start"
                            id="start"
                            value="{{$shift->start}}"
                            type="time"
                            class="form-control form-control-lg"
                            placeholder="Od..."
                            required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="stop" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Do</label>
                    <div class="col-sm-10">
                        <input
                            name="stop"
                            id="stop"
                            value="{{$shift->stop}}"
                            type="time"
                            class="form-control form-control-lg"
                            placeholder="Do..."
                            required />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="duration_show" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Czas trwania</label>
                    <div class="col-sm-10">
                        <input
                            name="duration_show"
                            id="duration_show"
                            type="text"
                            class="form-control form-control-lg"
                            disabled />
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label for="numberOfEmployees" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Liczba pracowników</label>
                    <div class="col-sm-10">
                        <input
                            name="numberOfEmployees"
                            id="numberOfEmployees"
                            min="0"
                            value="{{$shift->number_of_employees}}"
                            type="number"
                            class="form-control form-control-lg"
                            placeholder="Liczba pracowników..."
                            required />
                    </div>
                </div>
                <input type="hidden" id="duration" name="duration" />
                <input type="submit" class="btn btn-success btn-lg mt-2" value="Zapisz"/>
                <a class="btn btn-secondary btn-lg mt-2" href="{{ route('shiftList') }}" role="button">Powrót</a>
            </form>
        </div>
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
    return { hh: hh, mm: mm };
}
function timeShift(){
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
    var result = hh.toString().concat(' godzin i ', mm.toString(),' minut');

    $("#duration_show").val(result);
    $("#duration").val(diff);

}
$( document ).ready(function() {
    timeShift();
});
$("#start").change(function () {
    timeShift();
});
$("#stop").change(function () {
    timeShift();
});
</script>
@endsection
