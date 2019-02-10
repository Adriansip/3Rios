@extends('layouts.app') @section('estilos')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection @section('content') @if(Session::has('message'))
<div class="alert alert-{{Session::get('class')}} alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>{{Session::get('message')}}</div>
@endif
<h2 class="text-center">Eventos</h2>
<hr>
@foreach($movimientos as $movimiento)
<div class="row">
	<div class="col-lg-12">
		<div class="row">
			@if(Auth::check() && (Auth::user()->hasRole('Administrador')||Auth::user()->hasRole('Capturador')))
			<div class="col-lg-8">
				@else
				<div class="col-lg-12">
					@endif
					<div class="alert alert-primary">
						<h3 class="text-left">Logística Tres Ríos - Reporte de Status de Servicio en Transito
						</h3>
					</div>
				</div>
				@if(Auth::check() && (Auth::user()->hasRole('Administrador')||Auth::user()->hasRole('Capturador')))
				<div class="col-lg-4">
					<button class="btn btn-primary btn-block btn-lg btnNuevo mb-4" data-target="#ventana" data-toggle="modal" data-evento="{{$movimiento}}">
						Añadir Evento
						<img alt="" src="{{asset('imagenes/agregar.png')}}"/>
					</button>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="alert alert-warning">
		<h4 class="text-left">Destino/Localidad:
			<strong>{{$movimiento->cliente_localidad->cliente->NomCli}}
				({{$movimiento->cliente_localidad->NomLoc}})</strong>
		</h4>
		<h5 class="text-left">Fecha de Servicio
			<strong>
				<?php
			setlocale(LC_ALL,"es_ES","esp");
			echo $fecha = strftime( "%d de %B de %Y - %T ",strtotime($movimiento->created_at) );
			?>
			</strong>
		</h5>
		<h5 class="text-left">Codigo Minigrip:
			<strong>
				{{$movimiento->RefCli}}</strong>
		</h5>
		<h5>
		Observacion: <strong>{{$movimiento->ObsMov}}</strong>
		</h5>
	</div>
	@foreach($movimiento->eventos as $evento)
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4 border-dark">
				<div class="card-header">
					<h3 class="text-center">Datos del Movimiento</h3>
				</div>
				<div class="card-body">
					<h5>
						<p>
							@if($evento->fase_movimiento->PriFas && Auth::check() && (Auth::user()->hasRole('Administrador')||Auth::user()->hasRole('Capturador')))
							<strong>{{$evento->fase_movimiento->FasMov}}:
							</strong>
							@elseif(!$evento->fase_movimiento->PriFas)
							<strong>{{$evento->fase_movimiento->FasMov}}
								@if($loop->index>0){{$loop->index}}@endif:
							</strong>
							@endif
							<p class="font-weight-bolder">
								<?php
							setlocale(LC_ALL,"es_ES","esp");
							echo $fecha = strftime( "%d de %B de %Y / %T ",strtotime($evento->created_at) );
							?>
								/
								{{$evento->ObsEve}}</p>
						</p>
					</h5>
					@if(Auth::check() && (Auth::user()->hasRole('Administrador')||Auth::user()->hasRole('Capturador')))
					<p class="card-text">Mesa de control:
						<strong>{{$evento->user->name}}/L3R
						</strong>
					</p>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endforeach
	<br>
	<hr>
	@endforeach @include('Evento.modal') @endsection @section('scripts')
	<script src="{{asset('js/evento/agregar.js')}}"></script>
	@endsection
