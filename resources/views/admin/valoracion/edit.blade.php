@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Editar Valoración</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/valoracion') }}">Listado de valoraciones</a></li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Actualice los datos de la valoración</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.valoracion.update', $valoracion->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Espacio Deportivo --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Espacio Deportivo</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $valoracion->cancha->espacioDeportivo->nombre }}" disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Cancha --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cancha</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-futbol"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $valoracion->cancha->nombre }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deportista --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Deportista</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" value="{{ $valoracion->deportista->user->nombres }} {{ $valoracion->deportista->user->apellidos }}" disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Puntos --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="puntos">Puntos (1-5)</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-star"></i></span>
                                    </div>
                                    <input type="number" name="puntos" id="puntos" class="form-control" min="1" max="5" 
                                        value="{{ old('puntos', $valoracion->puntos) }}" required>
                                </div>
                                @error('puntos')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Comentario --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comentario">Comentario</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                    </div>
                                    <input type="text" name="comentario" id="comentario" class="form-control" 
                                        value="{{ old('comentario', $valoracion->comentario) }}">
                                </div>
                                @error('comentario')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <a href="{{ route('admin.valoracion.index') }}" class="btn btn-outline-secondary me-2">
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
