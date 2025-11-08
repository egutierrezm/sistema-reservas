@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"><b>Bienvenido: </b>{{ Auth::user()->name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=""><b>Rol: {{ Auth::user()->roles->pluck('name')->implode(', ') }} </b></a> </li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <a href="{{ route('admin.role.index') }}">
                            <img src="{{ asset('images/roles.gif') }}" width="100%" alt="Roles" />
                        </a>
                    </span>
                <div class="info-box-content">
                    <span class="info-box-text">Roles registrados</span>
                    <span class="info-box-number">{{ $totalRoles }}</span>
                </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <a href="{{ route('admin.user.index') }}">
                            <img src="{{ asset('images/users.gif') }}" width="100%" alt="Users" />
                        </a>
                    </span>
                <div class="info-box-content">
                    <span class="info-box-text">Usuarios registrados</span>
                    <span class="info-box-number">{{ $totalUsers }}</span>
                </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info">
                        <a href="{{ route('admin.espacioDeportivo.index') }}">
                            <img src="{{ asset('images/espacios.gif') }}" width="100%" alt="Espacios" />
                        </a>
                    </span>
                <div class="info-box-content">
                    <span class="info-box-text">Espacios registrados</span>
                    <span class="info-box-number">{{ $totalEspacios }}</span>
                </div>
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