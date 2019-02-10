@extends('layouts.app') @section('estilos')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
@endsection @section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-lg-3">
						<button class="btn btn-success btn-lg" id="btnExcel">
							XML
						</button>
					</div>
					<div class="col-lg-6">
						<h2 class="text-center">Facturas (Cuentas por Cobrar)</h2>
					</div>
					<div class="col-lg-3">
						<button class="btn btn-primary btn-block btn-lg" data-target="#ventana" data-toggle="modal" id="btnAgregar">
							Nueva Factura
							<img alt="" src="{{asset('imagenes/agregar.png')}}"/>
						</button>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-12">
						<div class="table-responsive-lg col-lg-12">
							<table class="table table-striped table-bordered table-sm" id="tblTabla">
								<thead>
									<th class="text-center">Numero</th>
									<th class="text-center">Movimiento</th>
									<th class="text-center">Fecha de creacion</th>
									<th class="text-center">Fecha de la factura</th>
									<th class="text-center">Total</th>
									<th class="text-center">Saldo</th>
									<th class="text-center">Editar</th>
									<th class="text-center">Eliminar</th>
								</thead>
								<tbody>
									@foreach($facturas as $factura)
									<tr>
										<td class="text-center">{{$factura->FacCxcNum}}</td>
										<td class="text-center">
											@if(isset($factura->movimiento))
											{{$factura->movimiento->RefCli}}
											@else
											Este movimiento ha sido eliminado
											@endif
										</td>
										<td class="text-center">{{$factura->FecCreFac}}</td>
										<td class="text-center">{{$factura->FecFac}}</td>
										<td class="text-center">{{$factura->TotFac}}</td>
										<td class="text-center">{{$factura->SalFac}}</td>
										<td class="text-center">
											<button class="btn btn-info btnEditar" value="{{$factura->FacCxcId}}" data-target="#ventana" data-toggle="modal">Editar</button>
										</td>
										<td class="text-center">
											<a href="{{url('FacturaCxc/eliminar/')}}/{{$factura->FacCxcId}}">
												<button class="btn btn-danger" onclick="return confirm('¿Seguro de que desea eliminar este registro?')">Eliminar</button>
											</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			@if(Session::has('message'))
			<div class="card-footer">
				<div class="alert alert-{{Session::get('class')}} alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">&times;</button>{{Session::get('message')}}</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection @include('FacturaCxc.modal') @section('scripts')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('js/tabla.js')}}"></script>
<script type="text/javascript" src="{{asset('js/facturacxc/data.js')}}"></script>
<script src="{{asset('js/facturacxc/editar.js')}}"></script>
@endsection
