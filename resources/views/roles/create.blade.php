@extends('layouts/dashboard')
@section('title', 'Crear de roles')
@section('contenido')

    <div class="card mt-3">
        <h5 class="card-header">Crear roles</h5>
        <div class="card-body">
            <form action="{{ route('rol.store') }}" method="post" class="row needs-validation" novalidate>
                @csrf

                <div class="form-group col-md-6">
                    <label for="nombreOpcion">Nombre: *</label>
                    <input type="text" class="form-control {{ $errors->has('nombreOpcion') ? 'is-invalid' : '' }}"
                        name="nombreOpcion" id="nombreOpcion" required>
                    @if ($errors->has('nombreOpcion'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nombreOpcion') }}
                        </div>
                    @endif
                </div>


                <div class="form-group col-md-6">
                    <label for="descripcion_opcion">Descripción: *</label>
                    <input type="text" class="form-control {{ $errors->has('descripcion_opcion') ? 'is-invalid' : '' }}"
                        name="descripcion_opcion" id="descripcion_opcion" required>
                    @if ($errors->has('descripcion_opcion'))
                        <div class="invalid-feedback">
                            {{ $errors->first('descripcion_opcion') }}
                        </div>
                    @endif
                </div>
                

                <div class="form-group col-md-12 mt-3">
                    <input type="submit" class="btn btn-primary" value="Crear rol">
                    <a href="{{ route('roles') }}" class="btn btn-dark">Regresar</a>
                </div>
            </form>
        </div>
    </div>

@endsection
