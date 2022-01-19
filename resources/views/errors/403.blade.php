@extends('errors.error_layout')

@section('contenido')
    <h1>403</h1>
    <div>
        <p>> <span>CODIGO DE ERROR</span>: "<i>HTTP 403 Forbidden</i>"</p>
        <p>> <span>DESCRIPCIÓN DEL ERROR</span>: "<i>Acceso Denegado. No tiene permiso para acceder a esta página en este servidor</i>"</p>
        <p>> <span>POSIBLE ERROR CAUSADO POR</span>: [<b>ejecutar acceso prohibido, acceso de lectura prohibido, acceso de escritura prohibido, ssl requerido, ssl 128 requerido, dirección IP rechazada, certificado de cliente requerido, acceso al sitio denegado, demasiados usuarios, configuración no válida, cambio de contraseña, mapeador denegado acceso, certificado de cliente revocado, directorio listado denegado, licencias de acceso de cliente excedidas, el certificado de cliente no es de confianza o no es válido, el certificado de cliente ha caducado o aún no es válido, el inicio de sesión del pasaporte falló, el acceso a la fuente se denegó, se denegó la profundidad infinita, demasiadas solicitudes de la misma IP de cliente ...</b>...]</p>
        <p>> <span>ALGUNAS PÁGINAS DE ESTE SERVIDOR A LAS QUE TIENE PERMISO DE ACCESO</span>: [<a href="/">Página de Inicio</a> ...]</p>
    </div>

    <a class="avatar" href="javascript:;" title="Acceso Restringido"><img src="{{ asset('assets/img/images/forbidden.png') }}"/></a>
@endsection