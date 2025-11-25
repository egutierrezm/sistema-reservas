@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE DEPORTISTAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Deportistas</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">

            <div class="alert alert-info">
                Los deportistas se crean desde la sección 
                <strong>Usuarios</strong> asignándoles el rol 
                <em>DEPORTISTA</em>.
            </div>

            <div class="card card-outline card-navy">
                <div class="card-header" style="background-color: #CCF3EA;">
                    <h3 class="card-title"><b>Deportistas Registrados</b></h3>
                </div>

                <div class="card-body bg-dark">
                    <div class="table-responsive">
                        <table id="table1" class="table table-dark table-bordered table-striped table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 15px">Nro</th>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Celular</th>
                                    <th>Club</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($deportistas as $deportista)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $deportista->user->nombres }}</td>
                                        <td>{{ $deportista->user->apellidos }}</td>
                                        <td>{{ $deportista->user->celular }}</td>
                                        <td>{{ $deportista->club ?? 'No asignado' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.deportista.show', $deportista->id) }}"
                                               class="btn-icon-circle btn-view mr-1" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.deportista.edit', $deportista->id) }}"
                                               class="btn-icon-circle btn-edit mr-1" title="Editar club">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay deportistas registrados.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos de las acciones */
        .btn-icon-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border 0.15s ease, color 0.15s ease;
        }
        .btn-view { background-color: #0062ff; border-color: #1f72aa; }
        .btn-edit { background-color: #44ce42; border-color: #27ae60; }
        .btn-pay  { background-color: #a461d8; border-color: #8e44ad; }
        .btn-delete { background-color: #fc5a5a; border-color: #c0392b; }
        .btn-icon-circle:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .btn-icon-circle:hover i {
            color: #ffffff;
        }

        /* Estilos de la tabla */
        table.dataTable thead {
            /* background-color: #001737;
            color: #ffffff; */
            text-align: center;
        }

        .btn-info { background-color: #17a2b8; border: none; }
        .btn-success { background-color: #28a745; border: none; }
    </style>
@stop

@section('js')
    <script>
        $(function(){
            $("#table1").DataTable({
                "pageLength": 5,
                "ordering": false,
                "language": {
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ deportistas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 deportistas",
                    "infoFiltered": "(filtrado de _MAX_ deportistas en total)",
                    "lengthMenu": "Mostrar _MENU_ deportistas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false
            });
        });
    </script>
@stop
