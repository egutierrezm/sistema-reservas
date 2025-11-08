@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">AJUSTES DEL SISTEMA</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Ajustes</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-navy">
                <div class="card-header">
                    <h3 class="card-title">Llene los campos del formulario</h3>

                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.ajuste.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre del sistema</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-building"></i>
                                                    </span>
                                                </div>    
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre', $ajuste->nombre ?? '')}}" placeholder="Sistema de reserva patito" required>
                                            </div>
                                            @error('nombre')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror    
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Descripción</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-align-left"></i>
                                                    </span>
                                                </div>    
                                                <textarea class="form-control" name="descripcion" id="descripcion" rows="1" placeholder="Descripcion del negocio" required>{{ old('descripcion', $ajuste->descripcion ?? '') }}</textarea>
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
                                            <label for="sucursal">Sucursal</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="sucursal" id="sucursal" value="{{ old('sucursal', $ajuste->sucursal ?? '')}}" placeholder="Sucursal centro" required>
                                            </div>
                                            @error('sucursal')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sucursal">Telefono</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="telefono" id="telefono" value="{{ old('telefono', $ajuste->telefono ?? '')}}" placeholder="+591 21234567" required>
                                            </div>
                                            @error('telefono')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror  
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="direccion">Dirección</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-home"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', $ajuste->direccion ?? '')}}" placeholder="Dirección completa" required>
                                            </div>
                                            @error('direccion')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="correo">Correo Electrónico</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email" class="form-control" name="correo" id="correo" value="{{ old('correo', $ajuste->correo ?? '')}}" placeholder="alanbrito@gmail.com" required>
                                            </div>
                                            @error('correo')
                                                <small style="color: red">{{$message}}</small>
                                            @enderror  
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="logo">LOGO PRINCIPAL</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-image"></i>
                                            </span>
                                        </div>
                                        <input type="file" class="form-control" name="logo" id="logo" accept="image/" onchange="mostrarImagen(event)" @if(!isset($ajuste) || !$ajuste->logo) required @endif>
                                    </div>
                                    <center>
                                        @if(isset($ajuste) && $ajuste->logo)
                                            <img id="preview" src="{{ asset('storage/logos/'.$ajuste->logo) }}" style="max-width: 160px; margin-top: 10px;">
                                        @else
                                            <img id="preview" src="" style="max-width: 160px; margin-top: 10px;">
                                        @endif
                                    </center>
                                    @error('logo')
                                        <small style="color: red">{{$message}}</small>
                                    @enderror  
                                </div>
                                <script>
                                    const mostrarImagen = e => document.getElementById('preview').src = URL.createObjectURL(e.target.files[0]);
                                </script>
                            
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class=col-md-12>
                                <button type="submit" class="btn btn-primary float-right"><i class="fa fas-save"></i>GUARDAR</button>
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