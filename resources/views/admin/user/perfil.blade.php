@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">MI PERFIL</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-11">
            <div class="card card-navy">
                <div class="card-header">
                    <h3 class="card-title">Informacion del perfil</h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.user.actualizarPerfil') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" value="{{ $usuario->id }}" hidden>
                        <div class="row">
                            {{-- Datos del perfil --}}
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Rol</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                                </div>
                                                <select name="rol" class="form-control" id="rol" disabled>
                                                    <option value="">Seleccione un rol</option>
                                                    @foreach($roles as $role)
                                                        @if(!($role->name == 'ADMINISTRADOR'))
                                                            <option value="{{ $role->name }}"
                                                                {{ old('rol', $usuario->getRoleNames()->implode(', ')) == $role->name ? 'selected' : '' }}>
                                                                {{ $role->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('rol')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror 
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nombres">Nombres</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="nombres" id="nombres" value="{{ old('nombres', $usuario->nombres) }}" placeholder="Nombres" required>
                                            </div>
                                            @error('nombres')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror 
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="apellidos">Apellidos</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" placeholder="Apellidos" required>
                                            </div>
                                            @error('apellidos')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="email">Correo Electrónico</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                </div>
                                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $usuario->email) }}" placeholder="Correo Electrónico" required>
                                            </div>
                                            @error('email')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_documento">Tipo de Documento</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <select class="form-control" name="tipoDocumento" id="tipoDocumento" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="CI" {{ old('tipoDocumento', $usuario->tipoDocumento) == 'CI' ? 'selected' : '' }}>CI</option>
                                                    <option value="CIE" {{ old('tipoDocumento', $usuario->tipoDocumento) == 'CIE' ? 'selected' : '' }}>CIE</option>
                                                    <option value="Pasaporte" {{ old('tipoDocumento', $usuario->tipoDocumento) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                                </select>
                                            </div>
                                            @error('tipoDocumento')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="nrodocumento">Número de Documento</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="nroDocumento" id="nroDocumento" value="{{ old('nroDocumento', $usuario->nroDocumento) }}" placeholder="Número de Documento" required>
                                            </div>
                                            @error('nroDocumento')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control" name="fechaNaci" id="fechaNaci" value="{{ old('fechaNaci', $usuario->fechaNaci) }}" required>
                                            </div>
                                            @error('fechaNaci')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="celular">Celular</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="celular" id="celular" value="{{ old('celular', $usuario->celular) }}" placeholder="Celular" required="">
                                            </div>
                                            @error('celular')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
        
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="genero">Género</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                </div>
                                                <select class="form-control" name="genero" id="genero" required="">
                                                    <option value="">Seleccione...</option>
                                                    <option value="Masculino" {{ old('genero', $usuario->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino" {{ old('genero', $usuario->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                </select>
                                            </div>
                                            @error('genero')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            {{-- Fotografia --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="foto">Fotografia</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-image"></i>
                                            </span>
                                        </div>
                                        <input type="file" class="form-control" name="foto" id="foto" accept="image/*" onchange="mostrarImagen(event)">
                                    </div>
                                    <center>
                                        @if(isset($usuario) && $usuario->foto)
                                            <img id="preview" src="{{ asset('storage/fotos/'.$usuario->foto) }}" style="max-width: 160px; margin-top: 10px;">
                                        @else
                                            <img id="preview" src="" style="max-width: 160px; margin-top: 10px;">
                                        @endif
                                    </center>
                                    @error('foto')
                                        <small style="color: red">{{$message}}</small>
                                    @enderror  
                                </div>
                                <script>
                                    const mostrarImagen = e => document.getElementById('preview').src = URL.createObjectURL(e.target.files[0]);
                                </script>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title"><b>Seguridad de la contraseña</b></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="passwordActual">Contraseña actual</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                        </div>
                                                        <input type="password" class="form-control" name="passwordActual"
                                                            id="passwordActual" placeholder="Ingresa tu contraseña actual">
                                                    </div>
                                                    @error('passwordActual')
                                                        <small style="color: red">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="passwordNuevo">Nueva contraseña</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                        </div>
                                                        <input type="password" class="form-control" name="passwordNuevo"
                                                            id="passwordNuevo" placeholder="Ingresa tu nueva contraseña">
                                                    </div>
                                                    @error('passwordNuevo')
                                                        <small style="color: red">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="passwordConfirmacion">Confirmar nueva contraseña</label>
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                                                        </div>
                                                        <input type="password" class="form-control" name="passwordConfirmacion"
                                                            id="passwordConfirmacion" placeholder="Confirma tu nueva contraseña">
                                                    </div>
                                                    @error('passwordConfirmacion')
                                                        <small style="color: red">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Regresar
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Guardar cambios
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
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop