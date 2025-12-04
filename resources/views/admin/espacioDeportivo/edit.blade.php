@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Modificar Datos del Espacio Deportivo: {{ $espacioDeportivo->nombre }}</h1>
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
                    <h3 class="card-title">Llene los campos del formulario</h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.espacioDeportivo.update', $espacioDeportivo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    {{-- Administradores --}}
                                    @php
                                        $user = Auth::user();
                                        $roles = $user->roles->pluck('name');
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="administrador_espacio_id">Administrador del Espacio</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-cog"></i></span>
                                                </div>
                                                @if($user->roles->contains('ADMINISTRADOR'))
                                                    <select name="administrador_espacio_id" id="administrador_espacio_id" class="form-control" required>
                                                        <option value="">Seleccione un administrador</option>
                                                        @foreach($administradores as $admin)
                                                            <option value="{{ $admin->id }}" 
                                                                {{ old('administrador_espacio_id', $espacioDeportivo->administrador_espacio_id) == $admin->id ? 'selected' : '' }}>
                                                                {{ $admin->user->nombres }} {{ $admin->user->apellidos }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <input type="text" class="form-control" value="{{ $espacioDeportivo->administradorEspacio->user->nombres }} {{ $espacioDeportivo->administradorEspacio->user->apellidos }}" disabled>
                                                    <input type="hidden" name="administrador_espacio_id" value="{{ $espacioDeportivo->administrador_espacio_id }}">
                                                    @endif
                                            </div>
                                            @error('administrador_espacio_id')
                                                <small style="color: red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $espacioDeportivo->nombre) }}" placeholder="Nombre espacio deportivo" required>
                                            </div>
                                            @error('nombre')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <label for="direccion">Direccion</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-home"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', $espacioDeportivo->direccion) }}" placeholder="Direccion" required>
                                            </div>
                                            @error('direccion')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror  
                                        </div>
                                    </div>
        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="descripcion" id="descripcion" value="{{ old('descripcion', $espacioDeportivo->descripcion) }}" placeholder="Descripcion" required>
                                            </div>
                                            @error('descripcion')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="horaApertura">Hora de Apertura</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                                </div>
                                                <input type="time" name="horaApertura" id="horaApertura" class="form-control" value="{{ old('horaApertura', \Carbon\Carbon::parse($espacioDeportivo->horaApertura)->format('H:i')) }}" required>
                                            </div>
                                            @error('horaApertura')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="horaCierre">Hora de Cierre</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                                </div>
                                                <input type="time" name="horaCierre" id="horaCierre" class="form-control" value="{{ old('horaCierre', \Carbon\Carbon::parse($espacioDeportivo->horaCierre)->format('H:i')) }}" required>
                                            </div>
                                            @error('horaCierre')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
        
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="imgespacio">Imagen cancha</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-image"></i></span>
                                        </div>
                                        <input type="file" class="form-control" name="imgespacio" accept="image/*" onchange="mostrarImagen(event)">
                                    </div>
                                    <center>
                                        <img id="preview" src="{{ $espacioDeportivo->imgespacio ? asset('storage/' . $espacioDeportivo->imgespacio) : '' }}" style="max-width: 200px; margin-top: 10px;">
                                    </center>
                                    @error('imgespacio')
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
                                <a href="{{ route('admin.espacioDeportivo.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Regresar
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Actualizar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .input-group-text i {
            color: navy;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop