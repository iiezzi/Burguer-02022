@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0"; ?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/pedido/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
    function fsalir() {
        location.href = "/admin/sistema/menu";
    }
</script>
@endsection
@section('contenido')
<form id="form1" method="POST">
    <div class="row">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
        <div class="form-group col-lg-6">
            <label>Fecha: *</label>
            <input type="date" id="txtFecha" name="txtFecha" class="form-control" required value="{{$pedido->fecha}}">
        </div>
        <div class="form-groupo col-lg-6">
            <label>Descripción: *</label>
            <textarea value="txtDescripcion" name="txtDescripcion" class="form-control"  required></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-groupo col-lg-6">
            <label>Total: *</label>
            <input type="number" id="txtTotal" name="txtTotal" class="form-control" value="{{$pedido->total}}" required>
        </div>
        <div class="form-groupo col-lg-6">
            <label>Sucursal: *</label>
            <select name="lstSucursal" id="lstSucursal" class="form-control" required>
                <option disabled selected>Seleccionar</option>
            @foreach ($aSucursales as $item)
                <option value="{{ $item->idsucursal }}">{{ $item->nombre }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-groupo col-lg-6">
            <label>Cliente: *</label>
            <select name="lstCliente" id="lstCliente" class="form-control"required>
                <optiondisabled selected>Seleccionar</option>
                @foreach ($aClientes as $item)
                <option value="{{ $item->idcliente }}">{{ $item->nombre }} {{ $item->apellido }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-groupo col-lg-6">
            <label>Estado: *</label>
            <select name="lstEstado" id="lstEstado" class="form-control"required>
                <option disabled selected>Seleccionar</option>
                @foreach ($aEstados as $item)
                <option value="{{ $item->idestado }}">{{ $item->nombre }}</option>
            @endforeach
            </select>
        </div>
    </div>
</form>
</div>
<div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">¿Deseas eliminar el registro actual?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/pedido/eliminar') }}",
            data: {
                id: globalId
            },
            async: true,
            dataType: "json",
            success: function(data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }
</script>
@endsection