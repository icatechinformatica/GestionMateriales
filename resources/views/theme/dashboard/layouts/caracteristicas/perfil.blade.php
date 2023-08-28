@extends('theme.dashboard.main', ['breadcrum' => __( 'SIRMAT / PERFIL DE USUARIO'), 'titlePage' => __( 'SIRMAT | Perfil de Usuario')])
{{-- sección contenido CSS --}}
@section('contenidoCss')
    <style>
        .avatar{
            background:#4e73df;
            border-radius:50%;
            color:#fff;
            display:inline-block;
            font-size:16px;
            font-weight:300;
            margin:0;
            position:relative;
            vertical-align:middle;
            line-height:1.28;
            height:45px;
            width:45px
        }
        .avatar.avatar-xs{
            font-size:6px;height:15px;width:15px
        }
        .avatar.avatar-sm{
            font-size:12px;height:30px;width:30px
        }
        .avatar.avatar-lg{font-size:23px;height:60px;width:60px}
        .avatar.avatar-xl{font-size:30px;height:75px;width:75px}
        .avatar img{border-radius:50%;height:100%;position:relative;width:100%;z-index:1}
        .avatar .avatar-icon{background:#fff;bottom:14.64%;height:50%;padding:.1rem;position:absolute;right:14.64%;transform:translate(50%,50%);width:50%;z-index:2}
        .avatar .avatar-presence{bottom:14.64%;padding:.1rem;position:absolute;right:14.64%;transform:translate(50%,50%);z-index:2;background:#bcc3ce;border-radius:50%;box-shadow:0 0 0 .1rem #fff;height:.5em;width:.5em}
        .avatar .avatar-presence.online{background:#1cc88a}
        .avatar .avatar-presence.busy{background:#e74a3b}
        .avatar .avatar-presence.away{background:#f6c23e}
        .avatar[data-initial]::before{color:currentColor;content:attr(data-initial);left:50%;position:absolute;top:50%;transform:translate(-50%,-50%);z-index:1}
        .rounded-circle{border-radius:50%!important}
        .card-profile-image{text-align:center}.card-profile-image img{margin:8px 0;max-width:180px;border-radius:.35rem;transition:all .2s ease-in-out}
    </style>
@endsection
{{-- sección contenido CSS END --}}
{{-- sección contenido --}}
@section('contenido')
    <div class="row">

        <div class="col-lg-4 order-lg-2">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold" style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}"></figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h6 class="font-weight-bold">{{  mb_strtoupper(Auth::user()->name, 'utf-8') }}</h6>
                                <p>Perfil</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card-profile-stats">
                                <span class="heading">&nbsp;</span>
                                <span class="description">&nbsp;</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-profile-stats">
                                <span class="heading">&nbsp;</span>
                                <span class="description">&nbsp;</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-8 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mi cuenta</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">Información de Usuario</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nombre Completo<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Correo Electrónico<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" placeholder="example@example.com" value="{{ old('email', Auth::user()->email) }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="new_password">Nueva Contraseña</label>
                                        <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirmar Contraseña</label>
                                        <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirmar Contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="idUser" id="idUser" value="{{ base64_encode($idUser) }}">
                        <br>
                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
{{-- sección contenido END --}}
