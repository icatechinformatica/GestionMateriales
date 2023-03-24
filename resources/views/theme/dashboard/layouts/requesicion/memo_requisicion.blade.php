{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / Memo Requisición Partida Presupuestal'), 'titlePage' => __('SIRMAT | Nueva Requisición de Materiales')])

@section('contenidoCss')
<style>
    .ck-editor__editable
    {
       min-height: 400px !important;
       max-height: 400px !important;
    }
</style>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-lg-1 mb-4"></div>
        <div class="col-lg-10 mb-4">
            <div class="bd-example">
                @if (count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p>
                    <a href="{{ route('requisicion.index') }}" class="btn btn-warning">
                        <i class="fas fa-undo"></i>
                        Regresar
                    </a>
                </p>
                {{-- formulario --}}
                {!! Form::open(['method' => 'post', 'class' => 'form needs-validation', 'route' => 'requisicion.memo.store', 'files' => true, 'novalidate', 'enctype' => 'multipart/form-data']) !!}
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::label('ARCHIVO DE MEMORANDUM', 'ARCHIVO DE MEMORANDUM', ['for' => 'textmemorandum', 'class' => 'control-label']) !!}
                        {!! Form::file('textmemorandum', ['id' => 'textomemorandum', 'class' => 'form-control']) !!}
                        <div class="invalid-feedback">
                            Proveer Autoriza 
                        </div>
                    </div>
                </div>
                <input type="hidden" name="idRequisicion" id="idRequisicion" value="{{ base64_encode($id) }}">
                <hr>
                {!!
                    Form::button(
                        '<i class="fas fa-upload"></i> Enviar', 
                        ['class' => 'btn btn-success', 'type' => 'submit']
                    )
                !!}
                {!! Form::close() !!}
            </div>
        </div>
        {{-- incluir mensaje --}}
        @include('theme.dashboard.messages.flash_message')
        {{-- incluir mensaje END --}}
        <div class="col-lg-1 mb-4"></div>
    </div>
@endsection

@section('contenidoJavaScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/ckeditor/translations/es.js') }}"></script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
