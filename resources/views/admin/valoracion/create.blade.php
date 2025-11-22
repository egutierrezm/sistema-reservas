@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Registrar Valoración</h1>
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
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title">Complete los campos para registrar una valoración</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.valoracion.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        {{-- Espacio Deportivo --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="espacio_id">Espacio Deportivo</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                    </div>
                                    <select name="espacio_id" id="espacio_id" class="form-control" required>
                                        <option value="">Seleccione un espacio deportivo</option>
                                        @foreach($espacios as $espacio)
                                            <option value="{{ $espacio->id }}">{{ $espacio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('espacio_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cancha_id">Cancha</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-futbol"></i></span>
                                    </div>
                                    <select name="cancha_id" id="cancha_id" class="form-control" required>
                                        <option value="">Seleccione una cancha</option>
                                    </select>
                                </div>
                                @error('cancha_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="deportista_id">Deportista</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <select name="deportista_id" id="deportista_id" class="form-control" required>
                                        <option value="">Seleccione un deportista</option>
                                        @foreach($deportistas as $deportista)
                                            <option value="{{ $deportista->id }}">
                                                {{ $deportista->user->nombres }} {{ $deportista->user->apellidos }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('deportista_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="puntos">Puntos (1-5)</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-star"></i></span>
                                    </div>
                                    <input type="number" name="puntos" id="puntos" class="form-control" min="1" max="5" value="{{ old('puntos') }}" required>
                                </div>
                                @error('puntos')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comentario">Comentario</label>
                                <div class="input-group-prepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                                    </div>
                                    <input type="text" name="comentario" id="comentario" class="form-control" value="{{ old('comentario') }}">
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

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
    $('#espacio_id').change(function() {
        var espacioID = $(this).val();
        if(espacioID) {
            $.ajax({
                url: "{{ url('admin/valoracion/canchasPorEspacio') }}/" + espacioID,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#cancha_id').empty();
                    $('#cancha_id').append('<option value="">Seleccione una cancha</option>');
                    $.each(data, function(key, value) {
                        $('#cancha_id').append('<option value="'+ value.id +'">'+ value.nombre +'</option>');
                    });
                }
            });
        } else {
            $('#cancha_id').empty();
            $('#cancha_id').append('<option value="">Seleccione una cancha</option>');
        }
    });
});
</script>
@stop
