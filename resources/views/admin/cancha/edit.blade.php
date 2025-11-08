@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Modificar Datos de la Cancha: {{ $cancha->nombre }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active"><a href="">Modificar datos</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Modifique los campos del formulario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.cancha.update', $cancha->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Espacio Deportivo</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-landmark"></i></span>
                                            </div>
                                            <select name="espacio_deportivo_id" class="form-control" required>
                                                <option value="">Seleccione un espacio deportivo</option>
                                                @foreach($espacioDeportivos as $espacio)
                                                    <option value="{{ $espacio->id }}" {{ $cancha->espacio_deportivo_id == $espacio->id ? 'selected' : '' }}>
                                                        {{ $espacio->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('espacio_deportivo_id')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-pen-nib"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="nombre" value="{{ old('nombre', $cancha->nombre) }}" required>
                                        </div>
                                        @error('nombre')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Disciplinas -->
                            <div class="form-group">
                                <label for="disciplinaDeportivas">Disciplinas deportivas</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-running"></i></span>
                                    </div>
                                    <select name="disciplinaDeportivas[]" class="form-control" id="disciplinaDeportivas" multiple required>
                                        @foreach($disciplinaDeportivas as $disciplina)
                                            <option value="{{ $disciplina->id }}" {{ $cancha->disciplinaDeportivas->contains($disciplina->id) ? 'selected' : '' }}>
                                                {{ $disciplina->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('disciplinaDeportivas')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Descripción -->
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="descripcion" value="{{ old('descripcion', $cancha->descripcion) }}" required>
                                </div>
                                @error('descripcion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Capacidad y Precio -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="capacidad">Capacidad</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <input type="number" class="form-control" name="capacidad" value="{{ old('capacidad', $cancha->capacidad) }}" required>
                                        </div>
                                        @error('capacidad')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precioxhora">Precio por hora</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="precioxhora" value="{{ old('precioxhora', $cancha->precioxhora) }}" required>
                                        </div>
                                        @error('precioxhora')
                                            <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Imagen -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="imgcancha">Imagen cancha</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>
                                    <input type="file" class="form-control" name="imgcancha" accept="image/*" onchange="mostrarImagen(event)">
                                </div>
                                <center>
                                    <img id="preview" src="{{ $cancha->imgcancha ? asset('storage/' . $cancha->imgcancha) : '' }}" style="max-width: 200px; margin-top: 10px;">
                                </center>
                                @error('imgcancha')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                            <script>
                                const mostrarImagen = e => {
                                    const preview = document.getElementById('preview');
                                    if(e.target.files.length > 0){
                                        preview.src = URL.createObjectURL(e.target.files[0]);
                                    }
                                };
                            </script>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <a href="{{ route('admin.cancha.index') }}" class="btn btn-outline-secondary me-2">
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
    <script>
        $(function() {
            $('#disciplinaDeportivas').select2({
                theme: 'classic',
                placeholder: 'Seleccione una o varias disciplinas',
                allowClear: true,
                width: 'resolve'
            });
        });
    </script>
@stop
