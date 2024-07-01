@extends('layouts.app')

@section('template_title')
Woo Tiendas
@endsection

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Error!</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div class="wrap">
		<main class="content-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class=" cards">
						<div class="card card-center">
							<div class="card-header">Errores en la Instalación</div>
							<div class="card-body">
								<h1>¡¡¡ERROR!!!</h1>
								<p class="error-message">Falta cargar los datos en la tabla Configs.</p>
								<p class="error-message">Comuníquese con el administrador</p>
								<a href="/" class="btn btn-danger">Volver atrás</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>
</body>

</html>

@endsection