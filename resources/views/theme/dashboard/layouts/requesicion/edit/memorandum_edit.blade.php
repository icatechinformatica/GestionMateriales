{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / Edición Memorándum'), 'titlePage' => __('SIRMAT | Edición de Memorandum de Requisición')])

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
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p>
                    <a href="{{ route('requisicion.index') }}" class="btn btn-warning">
                        <i class="fas fa-undo"></i>
                        Regresar
                    </a>
                </p>
                {{-- formulario --}}
                {!! Form::open(['method' => 'PUT', 'class' => 'form needs-validation', 'route' => ['requisicion.memo.update', 'id' => $id_requisicion], 'files' => true, 'novalidate']) !!}
                <div class="row g-2">
                    <div class="col-md">
                       @foreach ($getMemo as $k => $v)
                       <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                          <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              {{ $v->tipo }}
                            </button>
                          </h2>
                          <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="accordion-body">
                              <strong>MOSTRAR DOCUMENTO...</strong>
                              <a class="btn btn-primary btn-circle btn-sm" href="{{ route('document.download', ['idmemo' => base64_encode($v->id)]) }}" target="_blank">
                                <i class="fas fa-download"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                       @endforeach
                    </div>
                </div>
                <hr>
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::label('ARCHIVO DE MEMORANDUM', 'ARCHIVO DE MEMORANDUM', ['for' => 'memoupdate', 'class' => 'control-label']) !!}
                        {!! Form::file('memoupdate', ['id' => 'memoupdate', 'class' => 'form-control']) !!}
                        <div class="invalid-feedback">
                            Proveer Autoriza 
                        </div>
                    </div>
                </div>
                <input type="hidden" name="idRequisicion" id="idRequisicion" value="{{ base64_encode($id_requisicion) }}">
                <br>
                {!!
                    Form::button(
                        '<i class="fas fa-upload"></i> Modificar', 
                        ['class' => 'btn btn-danger', 'type' => 'submit']
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
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
