<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (isset($title)) ? $title : 'Plantilla de Reporte de Bitácora' }}</title>
    <style>
        header {
            position: fixed;
            left: 0px;
            top: -110px;
            right: 0px;
            color: black;
            text-align: center;
            line-height: 30px;
            height: 100px;
        }
        footer {
            position: fixed;
            left: 0px;
            bottom: -30px;
            right: 0px;
            height: 100px;
            text-align: center;
            line-height: 60px;
            display: block;
        }
        body{font-family: sans-serif;  margin-bottom: 70px;}
        @page {
            margin-left: 30px;
		    margin-right: 30px;
            margin-top: 35px;
        }
        table{
            width: 100%;
        }
    </style>
   @yield('contenido_css')
</head>
<body>
    <footer>
        <div style="position: relative;";>
            <img style=" position: absolute;" src='data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/reportes/footervertical.jpeg'))) }}' width="100%">
        </div>
    </footer>
   @yield('contenido')
   @yield('contentJS')
</body>
</html>
