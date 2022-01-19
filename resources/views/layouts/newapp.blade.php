{{-- creado por DANIEL MÉNDEZ CRUZ --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('title', 'Inicio de Sesión') }}</title>
    {{-- iconos --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.1/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor/animate/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/vendor/css-hamburgers/hamburgers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/util.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/login/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free/css/all.min.css') }}">
</head>
<body>
    {{-- plantilla formulario --}}
    <div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('assets/login/images/gas_control.png') }}" alt="IMG">
				</div>
                @yield('content')
			</div>
		</div>
	</div>
    {{-- contenido javascript --}}
    <script src="{{asset('assets/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/bootstrap-5.0.1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/popper.js') }}"></script>
    <script src="{{ asset('assets/login/tilt/tilt.jquery.min.js') }}"></script>
    <script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
    <script src="{{ asset('assets/login/js/main.js') }}"></script>
</body>
</html>