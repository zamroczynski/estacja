@extends('layouts.main')

@section('content')

<div class="container mt-5 mb-5">
    @include('layouts.alerts')
    <div class="row mb-1">
        <div class="col"><h1>Edycja pracownika:</h1></div>
        <div class="col">
            <a class="btn btn-secondary btn-lg" style="float: right; margin-left: 0.25rem" href="{{ route('adminUsers') }}" role="button">Powrót</a>
        </div>
    </div>
    <div class="row mt-1">
        <form class="" id="userAddForm" action="{{ route('adminUserUpdate', $user->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ $user->id }}" required/>
            <div class="form-group row mb-2">
                <label for="inputfirstName" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Imię</label>
                <div class="col-sm-10">
                    <input
                        name="first_name"
                        value="{{ $user->first_name }}"
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
                        value="{{ $user->last_name }}"
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
                        value="{{ $user->name }}"
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
                        value="{{ $user->email }}"
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
                        @if ($user->role=='user')
                        <option value="user" selected>Użytkownik</option>
                        <option value="admin">Admin</option>
                        @else
                        <option value="user">Użytkownik</option>
                        <option value="admin" selected>Admin</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="inputPhone" class="col-sm-2 col-form-label col-form-label-lg d-none d-lg-block">Numer telefonu</label>
                <div class="col-sm-10">
                    <input
                    name="phone"
                    value="{{ $user->phone }}"
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
                    value=""
                    type="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                    id="inputPassword"
                    placeholder="Hasło..."/>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <input type="submit" class="btn btn-success btn-lg mt-2" value="Aktualizuj dane"/>
            <a class="btn btn-secondary btn-lg mt-2" href="{{ route('adminUsers') }}" role="button">Powrót</a>
        </form>
    </div>
</div>

@endsection
