@extends('layouts.main')

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
    <div class="row mb-1">
        <div class="col"><h1>Archiwum:</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('userSchedule') }}" role="button">Powrót</a>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <table class="table align-middle table-striped mb-5 text-center">
                <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Data</th>
                </tr>
                </thead>
                <tbody>
                @foreach($schedules as $schedule)
                @php
                    $date = new DateTime($schedule->date);
                @endphp
                <tr>
                    <td>{{ $schedule->name }}</td>
                    <td>{{ $date->format('Y-m') }}</td>
                    <td>
                        <a class="btn btn-primary" style="float: right; margin-left: 0.25rem" href="{{ route('scheduleShow', $schedule->id) }}">Wyświetl</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
