@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">

    <div class="row mb-1">
        <div class="col"><h1>Lista pracowników:</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('adminPanel') }}" role="button">Powrót</a>
            <a class="btn btn-success btn-lg" style="float: right;" href="#userAddForm" role="button">Dodaj Praconwika</a>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <table class="table align-middle table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Email</th>
                    <th>Uprawnienia</th>
                    <th>Nazwa konta</th>
                    <th>Telefon</th>
                    <th>Opcje</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('adminUsersEdit', $user->id) }}" role="button">Edytuj</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr/>
    <div class="row mt-5">
        <h1>Dodaj pracownika:</h1>
    </div>
    <div class="row mt-1">
        <form class="" id="userAddForm" action="{{ route('adminUsersAdd') }}" method="POST">
            @csrf
            <div class="form-group row mb-2">
                <label for="inputfirstName" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Imię</label>
                <div class="col-sm-10">
                    <input
                        name="first_name"
                        value="{{ old('first_name') }}"
                        type="text"
                        class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                        id="inputfirstName"
                        placeholder="Imię..."
                        required />
                        @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputlastName" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Nazwisko</label>
                <div class="col-sm-10">
                    <input
                        name="last_name"
                        value="{{ old('last_name') }}"
                        type="text"
                        class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                        id="inputlastName"
                        placeholder="Nazwisko..."
                        required />
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputName" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Nazwa konta</label>
                <div class="col-sm-10">
                    <input
                        name="name"
                        value="{{ old('name') }}"
                        type="text"
                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                        id="inputName"
                        placeholder="Nazwa konta..."
                        required />
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputEmail" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Email</label>
                <div class="col-sm-10">
                    <input
                        name="email"
                        value="{{ old('email') }}"
                        type="email"
                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                        id="inputEmail"
                        placeholder="Email..."
                        required />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPermissions" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Uprawnienia</label>
                <div class="col-sm-10">
                    <select name="role" id="inputPermissions" class="form-control form-control-lg mb-3">
                        <option value="user" selected>Użytkownik</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputPhone" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Numer telefonu</label>
                <div class="col-sm-10">
                    <input
                    name="phone"
                    value="{{ old('phone') }}"
                    type="phone"
                    class="form-control form-control-lg"
                    id="inputPhone"
                    placeholder="Numer telefonu..." />
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputPassword" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Hasło</label>
                <div class="col-sm-10">
                    <input
                    name="password"
                    type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    id="inputPassword"
                    placeholder="Hasło..."
                    required />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="password-confirm" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Powtórz hasło</label>
                <div class="col-sm-10">
                    <input
                    name="password_confirmation"
                    type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    id="password-confirm"
                    placeholder="Hasło..."
                    required />
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-lg mt-2" value="Dodaj nowego pracownika"/>
            <a class="btn btn-secondary btn-lg mt-2" href="{{ route('adminPanel') }}" role="button">Powrót</a>
        </form>
    </div>
</div>

@endsection
