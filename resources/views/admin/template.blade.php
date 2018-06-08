<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>NLC Admin</title>
		<link rel="icon" href="{{ asset('img/logo.png') }}">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('fa/css/fontawesome-all.min.css') }}" rel="stylesheet">
	</head>
	<body style="font-family:Roboto, sans-serif">
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="/admin">
					<img src="{{ asset('img/schematics.png') }}" height="56" style="margin-right:20px;">
					NLC Admin
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#user_menu" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="user_menu">
					<ul class="nav navbar-nav">
						<li class="nav-item active"><a class="nav-link" href="#">Daftar Peserta</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Daftar Paket</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Daftar Soal</a></li>
					</ul>
					<ul class="nav navbar-nav" style="margin-left:auto">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								@yield('userstatus')
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="user_menu">
								@yield('usermenu')
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container" style="margin-top:110px">
			@yield('content')
		</div>
		<script src="{{ asset('js/app.js') }}"></script>
	</body>
</html>
