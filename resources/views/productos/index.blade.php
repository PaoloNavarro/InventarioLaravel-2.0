@extends('layouts/dashboard')
@section('title', 'Administrar productos')
@section('afterCss') <style>
        .pocos_productos>* {
            --bs-table-accent-bg: rgb(255, 185, 185) !important;
            color: rgb(45, 45, 45) !important;
        }
    </style>
@endsection

@section('contenido')

    <div class="card mt-3">
        <h5 class="card-header">Administración de productos</h5>
        <div class="card-body">
            <a href="{{ route('producto.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i>
                Agregar
            </a>

            <div class="col-md-4 mx-auto text-center mb-3">
                <label class="mb-2" for="filtro-bloqueo">Filtrar por Estado:</label>
                <select id="filtro-bloqueo" class="form-select">
                    <option>Seleccionar...</option>
                    <option value="no-bloqueados">No Bloqueados</option>
                    <option value="bloqueados">Bloqueados</option>
                </select>
            </div>

            <div class="table-responsive">
                <table id="miTabla" class="table text-nowrap mb-0 align-middle table-striped table-bordered">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th class="border-bottom-0">
                                <b>Nombre</b>
                            </th>
                            <th>
                                Imagen
                            </th>

                            <th class="border-bottom-0">
                                <b>Cantidad</b>
                            </th>
                            <th class="border-bottom-0">
                                <b>Estante</b>
                            </th>
                            <th class="border-bottom-0">
                                <b>Unidad de medida</b>
                            </th>

                            @if ($filtro === 'bloqueados')
                                <th class="border-bottom-0">
                                    <b>Bloqueado por</b>
                                </th>
                            @endif

                            <th>
                                <b>Acciones</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                            <tr>
                                <td class="border-bottom-0">
                                    {{ $producto->nombre }}
                                </td>

                                <!-- Agrega esta celda para mostrar la imagen -->
                                <td class="border-bottom-0">
                                    <img src="{{ $producto->img_path ? asset('storage/upload/productos/' . $producto->img_path) : asset('storage/upload/default.png') }}"
                                        alt="{{ $producto->nombre }}" class="img-thumbnail" width="100">
                                </td>

                                <td class="border-bottom-0">
                                    {{ $producto->cantidad }}
                                </td>

                                <td class="border-bottom-0">
                                    {{ $producto->estante->estante }}
                                </td>
                                <td class="border-bottom-0">
                                    {{ $producto->medida->nombre }}
                                </td>


                                @if ($filtro === 'bloqueados')
                                    <td class="border-bottom-0">
                                        {{ $producto->bloqueado_por }}
                                    </td>
                                @endif

                                <td style="height:auto !important;">

                                    <div class="d-flex gap-2">

                                        @if ($filtro !== 'bloqueados')
                                            <a href="{{ route('producto.detail', $producto->producto_id) }}"
                                                class="btn btn-warning">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('producto.edit', $producto->producto_id) }}"
                                                class="btn btn-primary">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('producto.destroy', $producto->producto_id) }}"
                                                method="POST" id="block-form-{{ $producto->producto_id }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="action" value="update">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="confirmBlock({{ $producto->producto_id }})">
                                                    <i class="fa-solid fa-lock"></i>
                                                </button>
                                            </form>
                                        @endif


                                        @if ($filtro === 'bloqueados')
                                            <form action="{{ route('producto.unblock', $producto->producto_id) }}"
                                                method="POST" id="unblock-form-{{ $producto->producto_id }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-warning"
                                                    onclick="confirmUnblock({{ $producto->producto_id }})">
                                                    <i class="fa-solid fa-unlock"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


@section('AfterScript')

    <script>
        $(document).ready(function() {
            $("#filtro-bloqueo").on("change", function() {
                var filtro = $(this).val();
                var url = "{{ route('productos') }}?filtro=" + filtro;
                window.location.href = url;
            });
        });
    </script>


@endsection
