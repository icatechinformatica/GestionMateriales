<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (isset($titlePage)) ? $titlePage : 'Plantilla de tablero de Administración SIRMAT' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-5.0.1/css/bootstrap.css') }}">
    {{-- estilos layouts --}}
    {{-- iconos --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- iconos END --}}
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free/css/all.min.css') }}">
    <link href="{{ asset('assets/css_/sb-admin-2.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css_/common.css') }}">
    {{-- yield script css --}}
    @section('contenidoCss')

    @endsection
    {{-- yield script css --}}
</head>
<body id="page-top">
    {{-- CONTENEDOR DE SCROLLER --}}
    <!-- Page Wrapper -->
    <div id="wrapper">

      {{-- sidebar --}}
        @include('theme.dashboard.sidebar')
      {{-- sidebar END --}}


      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">

          <!-- Main Content -->
          <div id="content">

              {{-- topbar --}}
                @include('theme.dashboard.nav')
              {{-- topbar END --}}


              <!-- Begin Page Content -->
              <div class="container-fluid">

                 {{-- Page Heading BreadCrumb --}}
                  @include('theme.dashboard.breadcrumb')

                 {{-- contenido --}}
                  @yield('contenido')
              </div>
              <!-- /.container-fluid -->

          </div>
         {{-- Main Content END --}}


          {{-- pie de página --}}
          @include('theme.dashboard.footer')
          {{-- fin de pie de página --}}


      </div>
      <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

     {{-- Desplazarse hasta el botón superior --}}

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Desplazarse hasta el botón superior END--}}

    @include('theme.dashboard.modal')
    {{-- CONTENEDOR DE SCROLLER END --}}
    <script src="{{asset('assets/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/bootstrap-5.0.1/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js_/sb-admin-2.min.js') }}"></script>
    {{-- SECCIÓN DE CONTENIDO JAVASCRIPT --}}
    @yield('contenidoJavaScript')
</body>
</html>
