@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">DATOS DEL USUARIO</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/user') }}">Listado de usuarios</a></li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-info h-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i>Información Personal</h3>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4"><i class="fas fa-user fa-fw mr-1"></i>Nombre completo</dt>
                        <dd class="col-sm-8">{{ $usuario->nombres }} {{ $usuario->apellidos }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-id-card fa-fw mr-1"></i>Documento</dt>
                        <dd class="col-sm-8">{{ $usuario->tipoDocumento }} - {{ $usuario->nroDocumento }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-envelope fa-fw mr-1"></i>Correo Electrónico</dt>
                        <dd class="col-sm-8">{{ $usuario->email }}</dd>

                        <dt class="col-sm-4"><i class="fas fa-birthday-cake fa-fw mr-1"></i>Fecha de nacimiento</dt>
                        <dd class="col-sm-8">{{ \Carbon\Carbon::parse($usuario->fechaNaci)->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</dd>
                        
                        <dt class="col-sm-4"><i class="fas fa-venus-mars fa-fw mr-1"></i>Género</dt>
                        <dd class="col-sm-8">{{ $usuario->genero }}</dd>
                        
                        <dt class="col-sm-4"><i class="fas fa-mobile-alt fa-fw mr-1"></i>Celular</dt>
                        <dd class="col-sm-8">{{ $usuario->celular ?? 'No registrado' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-info card-outline h-100">
                <div class="card-body box-profile text-center">
                    @if($usuario->foto)
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('storage/' . $usuario->foto) }}"
                            alt="Foto de perfil de {{ $usuario->nombres }}">
                    @else
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ 'https://ui-avatars.com/api/?name=' . urlencode($usuario->nombres) . '&color=7F9CF5&background=EBF4FF' }}"
                            alt="Foto de perfil de {{ $usuario->nombres }}">
                    @endif
                    <h3 class="profile-username">{{ $usuario->name }}</h3>
                    <p class="text-muted">
                        <span class="badge badge-primary">{{ $usuario->getRoleNames()->implode(', ') }}</span>
                    </p>
                    @if($usuario->estado == 1)
                        <span class="badge badge-success">Activo</span>
                    @else
                        <span class="badge badge-danger">Inactivo</span>
                    @endif
                    <hr>
                    <strong><i class="fas fa-calendar-alt mr-1"></i>Fecha de Creación</strong>
                    <p class="text-muted">
                        {{ $usuario->created_at->isoFormat('dddd, D [de] MMMM [de] YYYY, h:mm A') }}
                    </p>
                </div>
            </div>
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