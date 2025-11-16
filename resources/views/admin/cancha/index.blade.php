@extends('adminlte::page')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">LISTADO DE CANCHAS</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Canchas</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-navy">
                <div class="card-header" style="background-color: #CCF3EA;">
                    <h3 class="card-title"><b>Canchas Registradas</b></h3>

                    <!-- /.card-tools -->
                    <div class="card-tools">
                        <a href="{{ route('admin.cancha.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Crear Cancha</a>
                    </div>
                </div>
                
                <!-- /.card-header -->
                <div class="card-body" style="background-color: #f0f5e8;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="table1" class="table table-bordered table-striped table-hover table-sm">
                                    <thead>
                                        <th style="width: 10px">Nro</th>
                                        <th>Espacio deportivo</th>
                                        <th>Cancha</th>
                                        <th>Disciplina</th>
                                        <th>Capacidad</th>
                                        <th>Precio x hora</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach($canchas as $cancha)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $cancha->espacioDeportivo->nombre }}</td>
                                            <td>{{ $cancha->nombre }}</td>
                                            <td>
                                                <div class="mt-2 p-2 border rounded bg-light text-center text-truncate" style="display: inline-block; min-width: 150px; border-color: orange !important; font-size: 0.875rem;">
                                                    @foreach($cancha->disciplinaDeportivas as $disciplina)
                                                        <div>{{ $disciplina->nombre }}</div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>{{ $cancha->capacidad }}</td>
                                            <td>{{ $cancha->precioxhora }}</td>
                                            <td class="d-flex justify-content-center">
                                                @if(!$cancha->deleted_at)
                                                    <a href="{{ route('admin.cancha.show', $cancha->id) }}" class="btn-icon-circle btn-view mr-1" title="Ver detalles">
                                                        <i class="fas fa-eye me-1"></i>
                                                    </a>
                                                    <a href="{{ route('admin.cancha.edit', $cancha->id) }}" class="btn-icon-circle btn-edit mr-1" title="Editar cancha">
                                                        <i class="fas fa-edit me-1"></i>
                                                    </a>
                                                    <form action="{{ route('admin.cancha.destroy', $cancha->id) }}" method="POST"
                                                        id="miFormulario{{ $cancha->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-icon-circle btn-delete mr-1"
                                                            onclick="preguntar{{$cancha->id}}(event)"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash-alt me-1"></i>
                                                        </button>
                                                    </form>
                                                    <script>
                                                        function preguntar{{ $cancha->id }}(event) {
                                                            event.preventDefault();
                                                            console.log('clic detectado');
                                                            Swal.fire({
                                                                title: '¿Desea eliminar este registro?',
                                                                text: '',
                                                                icon: 'question',
                                                                showDenyButton: true,
                                                                confirmButtonText: 'SI',
                                                                confirmButtonColor: '#a5161d',
                                                                denyButtonColor: '#270a0a',
                                                                denyButtonText: 'NO',
                                                            }).then((result) => {
                                                                if(result.isConfirmed){
                                                                    document.getElementById('miFormulario{{ $cancha->id }}').submit();
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                @else
                                                    <form action="{{ route('admin.cancha.restore', $cancha->id) }}" method="POST"
                                                        id="miFormulario{{ $cancha->id }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning btn-sm"
                                                            onclick="preguntar{{$cancha->id}}(event)">
                                                            <i class="fas fa-trash-alt me-1"></i> Restaurar cancha
                                                        </button>
                                                    </form>
                                                    <script>
                                                        function preguntar{{ $cancha->id }}(event) {
                                                            event.preventDefault();
                                                            console.log('clic detectado');
                                                            Swal.fire({
                                                                title: '¿Desea restaurar esta cancha?',
                                                                text: '',
                                                                icon: 'question',
                                                                showDenyButton: true,
                                                                confirmButtonText: 'SI',
                                                                confirmButtonColor: '#a5161d',
                                                                denyButtonColor: '#270a0a',
                                                                denyButtonText: 'NO',
                                                            }).then((result) => {
                                                                if(result.isConfirmed){
                                                                    document.getElementById('miFormulario{{ $cancha->id }}').submit();
                                                                }
                                                            });
                                                        }
                                                    </script>
                                                @endif


                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
            background-color: #001737;
            color: #ffffff;
            text-align: center;
        }

        #table1_wrapper .dt-buttons {
            background-color: transparent;
            box-shadow: none;
            border: none;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        #table1_wrapper .btn {
            color: #fff;
            border-radius: 4px;
            padding: 5px 15px;
            font-size: 14px;
        }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-info { background-color: #17a2b8; border: none; }
        .btn-warning { background-color: #ffc107; color: #212529; border: none; }
        /* .btn-default { background-color: #6e7176; color: #212529; border: none; } */

        .badge-fuchsia {
            background-color: #ADFF2F;
            color: black;
        }

    </style>
@stop

@section('js')
    <script>
        $(function(){
            $("#table1").DataTable({
                "pageLength":5,
                "ordering": false,
                "language":{
                    "emptyTable": "No hay informacion",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Canchas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Canchas",
                    "infoFiltered": "(Filtrado de _MAX_ total Canchas)",
                    "lengthMenu": "Mostrar _MENU_ Canchas",
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
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                
            });
        });
    </script>
@stop