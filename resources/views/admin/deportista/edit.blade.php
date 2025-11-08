@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h2 class="m-0">Modificar Datos de: {{ $deportista->user->nombres }}</h2>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Modificar Datos</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-9">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Datos del Deportista</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.deportista.update', $deportista->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nombres">Nombres</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="nombres" value="{{ $deportista->user->nombres }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos">Apellidos</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="apellidos" value="{{ $deportista->user->apellidos }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="celular">Celular</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" id="celular" value="{{ $deportista->user->celular }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Correo Electrónico</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" value="{{ $deportista->user->email }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="club">Club</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                </div>
                                <input type="text" class="form-control" name="club" id="club" value="{{ old('club', $deportista->club) }}">
                            </div>
                            @error('club')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <a href="{{ route('admin.deportista.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-1"></i> Regresar
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .input-group-text i {
            color: navy;
        }
    </style>
@stop

@section('js')
    <script> console.log("Editando Deportista"); </script>
@stop
