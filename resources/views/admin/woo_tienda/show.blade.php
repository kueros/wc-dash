@extends('layouts.app')

@section('template_title')
{{ $config->name ?? __('Show') . " " . __('Store') }}
@endsection

@section('content')
<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
					<div class="float-left">
						<span class="card-title">Mostrar Tienda</span>
					</div>
					<div class="float-right">
						<a class="btn btn-primary btn-sm" href="{{ route('woo_tiendas/index') }}"> {{ __('Back') }}</a>
					</div>
				</div>
				<div class="card-body bg-white">
					<div class="form-group mb-2 mb20">
						<strong>Nombre:</strong>
						{{ $woo_tiendas->shop }}
					</div>
					<div class="form-group mb-2 mb20">
						<strong>Cuit:</strong>
						{{ $woo_tiendas->cuit }}
					</div>
					<div class="form-group mb-2 mb20">
						<strong>Estado:</strong>
						{{ $woo_tiendas->state }}
					</div>
					<div class="form-group mb-2 mb20">
						<strong>Token:</strong>
						{{ $woo_tiendas->token }}
					</div>
					<div class="form-group mb-2 mb20">
						<strong>Shopify Cli ID:</strong>
						{{ $woo_tiendas->cli_id }}
					</div>

				</div>
			</div>
		</div>
	</div>
</section>
@endsection