@extends('layouts.app')

@section('template_title')
{{ __('Create') }} Woo Tienda
@endsection

@section('content')
<?php #var_dump($woo_tiendas);die(); 
?>
<section class="content container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="card card-default">
				<div class="card-header">
					<span class="card-title">{{ __('Create') }} Woo Tienda1</span>
				</div>
				<div class="card-body bg-white">
					<form method="POST" action="http://localhost:8000/woo-tiendas-store" role="form" enctype="multipart/form-data">
						@csrf
						@include('woo-tienda.form')
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection