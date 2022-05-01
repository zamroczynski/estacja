@extends('layouts.main')
@section('content')

    <div class="container mt-3 mb-5">
        @include('layouts.alerts')
        <div class="row mb-2">
            <div class="col">
                <div class="col"><a class="btn btn-secondary mb-2" style="float: right;"
                        href="{{ route('edsPanel') }}">Powrót</a></div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <form action="{{ route('edsGenerate') }}" method="POST">
                    @csrf
                    <div id="divStart" class="form-floating mb-3">
                        <input id="dateStart" type="date" min="1900-01-01" max="3000-12-31"
                            class="form-control form-control-lg text-center mb-3" name="dataStart" id="dataStart"
                            value="{{ $dateStart ?? '' }}" required>
                        <label for="dataStart">Data Od</label>
                        <div id="errorMessageStart"></div>
                    </div>
                    <div id="divEnd" class="form-floating mb-3">
                        <input id="dateEnd" type="date" min="1900-01-01" max="3000-12-31"
                            class="form-control form-control-lg text-center mb-3" name="dataEnd" id="dataEnd"
                            value="{{ $dateEnd ?? '' }}" required>
                        <label for="dataEnd">Data Do</label>
                    </div>
                    <div class="col">
                        <input id="generateButton" type="submit" class="form-control btn btn-success btn-lg"
                            value="Generuj" />
                    </div>
                </form>
            </div>
        </div>


        @isset($dates)
            <div class="row mb-5">
                <div class="col">
                    <table id="table" class="table align-middle table-striped">
                        <thead>
                            <tr>
                                <th>Produkt</th>
                                <th>Data</th>
                                <th>Ilość</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dates as $date)
                                <tr>
                                    <th scope="row">{{ $date->product->name }}</th>
                                    <td>{{ $date->date }}</td>
                                    <td>{{ $date->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-success mb-2" onclick="save()">Zapisz XLS</a>
                </div>
            </div>
        @endisset

    </div>

@endsection


@section('js')
    <script>
        const errorMessage = '<span id="error" class="invalid-feedback" role="alert"><strong>Błędna data!</strong></span>';

        $('#dateStart').change(function() {
            const dateStart = new Date($('#dateStart').val());
            const dateEnd = new Date($('#dateEnd').val());
            if (dateStart > dateEnd) {
                if (!($('#dateStart').hasClass('is-invalid'))) {
                    $('#dateStart').addClass('is-invalid');
                    $('#divStart').append(errorMessage);
                    $('#generateButton').attr('disabled', 'disabled');
                }
            } else {
                $('#dateStart').removeClass('is-invalid');
                $('#error').remove();
                $('#generateButton').removeAttr('disabled');
            }
        });

        $('#dateEnd').change(function() {
            const dateStart = new Date($('#dateStart').val());
            const dateEnd = new Date($('#dateEnd').val());
            if (dateStart > dateEnd) {
                if (!($('#dateEnd').hasClass('is-invalid'))) {
                    $('#dateEnd').addClass('is-invalid');
                    $('#divEnd').append(errorMessage);
                    $('#generateButton').attr('disabled', 'disabled');
                }
            } else {
                $('#dateEnd').removeClass('is-invalid');
                $('#error').remove();
                $('#generateButton').removeAttr('disabled');
            }
        });

        function save() {
            // Acquire Data (reference to the HTML table)
            var table_elt = document.getElementById("table");

            // Extract Data (create a workbook object from the table)
            var workbook = XLSX.utils.table_to_book(table_elt);

            // Process Data (add a new row)
            var ws = workbook.Sheets["Sheet1"];
            XLSX.utils.sheet_add_aoa(ws, [
                ["Created " + new Date().toISOString()]
            ], {
                origin: -1
            });

            // Package and Release Data (`writeFile` tries to write and save an XLSB file)
            XLSX.writeFile(workbook, "Report.xlsb");
        }
    </script>
@endsection
