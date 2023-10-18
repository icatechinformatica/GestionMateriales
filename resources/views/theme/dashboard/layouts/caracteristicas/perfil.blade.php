@extends('theme.dashboard.main', ['breadcrum' => __('SIRMAT / PERFIL DE USUARIO'), 'titlePage' => __('SIRMAT | Perfil de Usuario')])
{{-- sección contenido CSS --}}
@section('contenidoCss')
    <link rel="stylesheet" href="{{ asset('css/avatar.css') }}">
@endsection
{{-- sección contenido CSS END --}}
{{-- sección contenido --}}
@section('contenido')
    <div class="row">

        <div class="col-lg-4 order-lg-3">

            <div class="card shadow mb-4">
                <div class="card-profile-image mt-4">
                    <figure class="rounded-circle avatar avatar font-weight-bold"
                        style="font-size: 60px; height: 180px; width: 180px;" data-initial="{{ Auth::user()->name[0] }}">
                    </figure>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h6 class="font-weight-bold">{{ mb_strtoupper(Auth::user()->name, 'utf-8') }}</h6>
                                <p>Perfil</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                @include('messages.flash-message')
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

        <div class="col-lg-4 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mi Información </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('perfil.update.info', ['id' => base64_encode($idUser)]) }}" autocomplete="off"
                        method="POST">
                        @method('PUT')
                        @csrf

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Nombre Completo<span
                                                class="small text-danger">*</span>
                                        </label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            placeholder="Nombre" value="{{ old('name', Auth::user()->name) }}"
                                            autocomplete="off" />


                                        @if ($errors->has('name'))
                                            <span class="invalid feedback small text-danger" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Correo Electrónico<span
                                                class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email"
                                            placeholder="example@example.com"
                                            value="{{ old('email', Auth::user()->email) }}" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Actualizar Registros</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-4 order-lg-2">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Contraseña</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('perfil.update.password', ['id' => base64_encode($idUser)]) }}"
                        autocomplete="off" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="pl-lg-4">

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="password">Nueva Contraseña</label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Contraseña" />

                                        @if ($errors->has('password'))
                                            <span class="invalid feedback text-danger small" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="confirm_password">Confirmar
                                            Contraseña</label>
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="password_confirmation" placeholder="Confirmar Contraseña" />

                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid feedback text-danger small" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Guardar Contraseña</button>
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
