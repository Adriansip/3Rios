@extends('layouts.modal')
@section('titulo')
Nueva Unidad
@endsection
@section('body')
<form action="TipoUnidad/agregar" method="post" id="frmAgregar">
    {{csrf_field()}}
    <div class="row">
        <div class="col-lg-12">
            <label for="descripcion">Descripcion</label>
            <input type="text" class="form-control" placeholder="Tipo de unidad" name="DesTipUni" value="{{old('DesTipUni')}}">

            <label for="capacidadminima">Capacidad Minima</label>
            <input type="text" class="form-control" placeholder="Capacidad en Toneladas (T)" name="CapMinUni" value="{{old('CapMinUni')}}">

            <label for="capacidadmaxima">Capacidad Minima</label>
            <input type="text" class="form-control" placeholder="Capacidad en Toneladas (T)" name="CapMaxUni" value="{{old('CapMaxUni')}}">

            <label for="observacion">Observacion</label>
            <input type="text" class="form-control" placeholder="Observaciones" name="ObsTipUni" value="{{old('ObsTipUni')}}">
        </div>
    </div>
    <input type="submit" class="btn btn-success btn-block btn-lg mt-4" value="Agregar" id="btnCrear">
</form>
@endsection
