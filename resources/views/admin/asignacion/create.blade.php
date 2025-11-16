@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Asignar Controlador a Cancha</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/asignacion') }}">Listado de asignaciones</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-navy">
                <div class="card-header">
                    <h3 class="card-title">Complete los campos para asignar un controlador</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.asignacion.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Espacio Deportivo -->
                            <div class="col-md-12">
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
                        </div>

                        <div class="row">
                            <!-- Cancha -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cancha_id">Cancha</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-futbol"></i></span>
                                        </div>
                                        <select name="cancha_id" id="cancha_id" class="form-control" required>
                                            <option value="">Seleccione una cancha</option>
                                            <!-- Se llenará dinámicamente vía AJAX -->
                                        </select>
                                    </div>
                                    @error('cancha_id')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Controlador -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="controlador_id">Controlador</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                        </div>
                                        <select name="controlador_id" id="controlador_id" class="form-control" required>
                                            <option value="">Seleccione un controlador</option>
                                            @foreach($controladores as $controlador)
                                                <option value="{{ $controlador->id }}" {{ old('controlador_id') == $controlador->id ? 'selected' : '' }}>
                                                    {{ $controlador->user->nombres }} {{ $controlador->user->apellidos }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('controlador_id')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Fecha y Turno -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fechaAsignacion">Fecha Asignada</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="date" name="fechaAsignacion" id="fechaAsignacion" class="form-control" value="{{ old('fechaAsignacion') }}" required>
                                    </div>
                                    @error('fechaAsignacion')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="turnoAsignado">Turno Asignado</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                        <select name="turnoAsignado" id="turnoAsignado" class="form-control" required>
                                            <option value="">Seleccione un turno</option>
                                            <option value="Mañana" {{ old('turnoAsignado') == 'Mañana' ? 'selected' : '' }}>Mañana</option>
                                            <option value="Tarde" {{ old('turnoAsignado') == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                                            <option value="Noche" {{ old('turnoAsignado') == 'Noche' ? 'selected' : '' }}>Noche</option>
                                        </select>
                                    </div>
                                    @error('turnoAsignado')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <a href="{{ route('admin.asignacion.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Regresar
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar Asignación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
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
<script>
$(document).ready(function() {
    $('#espacio_id').change(function() {
        var espacioID = $(this).val();
        if(espacioID) {
            $.ajax({
                url: "{{ url('admin/asignacion/canchasPorEspacio') }}/" + espacioID,
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

