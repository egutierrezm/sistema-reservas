@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">ASIGNACIÓN DE CONTROLADORES A CANCHAS</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Asignaciones</li>
                </ol>
            </div>
        </div>
    </div>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-navy">
                <div class="card-header" style="background-color: #CCF3EA;">
                    <h3 class="card-title"><b>Asignaciones Registradas</b></h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.asignacion.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva asignación
                        </a>
                    </div>
                </div>
                
                <div class="card-body bg-dark">
                    <div class="table-responsive">
                        <table id="table1" class="table table-dark table-bordered table-striped table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nro</th>
                                    <th>Espacio Deportivo</th>
                                    <th>Cancha</th>
                                    <th>Controlador</th>
                                    <th>Fecha de servicio</th>
                                    <th>Turno</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignaciones as $asignacion)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $asignacion->cancha->espacioDeportivo->nombre }}</td>
                                        <td>{{ $asignacion->cancha->nombre }}</td>
                                        <td>{{ $asignacion->controlador->user->nombres }} {{ $asignacion->controlador->user->apellidos }}</td>
                                        <td>{{ $asignacion->fechaAsignacion }}</td>
                                        <td>{{ $asignacion->turnoAsignado }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ route('admin.asignacion.show', $asignacion->id) }}" 
                                               class="btn-icon-circle btn-view mr-1" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.asignacion.edit', $asignacion->id) }}" 
                                               class="btn-icon-circle btn-edit mr-1" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.asignacion.destroy', $asignacion->id) }}" 
                                                  method="POST" id="formDelete{{ $asignacion->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon-circle btn-delete" 
                                                        onclick="confirmDelete({{ $asignacion->id }})"
                                                        title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .btn-view { background-color: #0062ff; }
    .btn-edit { background-color: #44ce42; }
    .btn-delete { background-color: #fc5a5a; }
    .btn-icon-circle:hover {
        transform: scale(1.15);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .btn-icon-circle:hover i {
        color: #ffffff;
    }

    table.dataTable thead { background-color: #001737; color: #fff; text-align: center; }
</style>
@stop

@section('js')
<script>
    $(function(){
        $("#table1").DataTable({
            "pageLength": 5,
            "ordering": true,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Asignaciones",
                "infoEmpty": "Mostrando 0 a 0 de 0 Asignaciones",
                "infoFiltered": "(Filtrado de _MAX_ total)",
                "lengthMenu": "Mostrar _MENU_ Asignaciones",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados",
                "paginate": { 
                    "first": "Primero", 
                    "last": "Último", 
                    "next": "Siguiente", 
                    "previous": "Anterior" 
                }
            },
        });
    });

    function confirmDelete(id) {
        event.preventDefault();
        Swal.fire({
            title: '¿Eliminar esta asignación?',
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: 'SI',
            denyButtonText: 'NO',
            confirmButtonColor: '#a5161d',
        }).then((result) => {
            if(result.isConfirmed){
                document.getElementById('formDelete' + id).submit();
            }
        });
    }
</script>
@stop
