@extends('adminlte::page')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><b>Permisos del Rol: </b>{{ $role->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/admin/role') }}">Listado de roles</a></li>
            </ol>
        </div>
    </div>
</div>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-navy">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Permisos Registrados en el Sistema</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.role.updatePermiso', $role->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        @foreach($permisos as $grupo => $items)
                            <div class="col-md-4 col-sm-6 mb-3">
                                <!-- Minicard colores armonizados -->
                                <div class="card h-100 minicard-custom">
                                    <div class="card-header grupo-header p-2">
                                        <strong>{{ $grupo }}</strong>
                                    </div>
                                    <div class="card-body p-2 permisos-body">
                                        @foreach($items as $permiso)
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="permisos[]"
                                                       value="{{ $permiso->id }}"
                                                       id="permiso_{{ $permiso->id }}"
                                                       {{ $role->hasPermissionTo($permiso->name) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permiso_{{ $permiso->id }}">
                                                    {{ $permiso->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 text-right">
                        <a href="{{ url('/admin/role') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Guardar Permisos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .minicard-custom {
        border: 1px solid #a3c18a;
        background-color: #fdf6f0;
        min-height: 180px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .minicard-custom:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .grupo-header {
        background-color: #c1d3a3;
        color: #333;
    }

    .permisos-body {
        max-height: 180px;
        overflow-y: auto;
    }
</style>
@stop

@section('js')
<script> console.log("Permisos del Rol"); </script>
@stop
