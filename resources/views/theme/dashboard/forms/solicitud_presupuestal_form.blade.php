{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Envío de la Solicitud Presupuestal | ICATECH')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
 </style>
@endsection

@section('contenido')



{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Nueva Solicitud de Validación Presupuestal</h6>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                              <div class="col-md-4 mb-3">
                                <label for="validationServer01">N°. Memorándum</label>
                                <input type="text" class="form-control is-valid" id="no_memorandum" placeholder="N° Memorándum" required>
                                <div class="valid-feedback">
                                  Looks good!
                                </div>
                              </div>
                              <div class="col-md-4 mb-3">
                                <label for="validationServer02">Memorándum para Solicitud de pago</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="solicitudpago" name="solicitudpago" lang="es">
                                    <label class="custom-file-label" for="customFile">Seleccionar Archivo</label>
                                </div>
                              </div>
                              <div class="col-md-4 mb-3">
                                <label for="validationServerUsername">Solicitud de Suficiencia Presupuestal</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="suficienciapresupuestal" name="suficienciapresupuestal" lang="es">
                                    <label class="custom-file-label" for="customFile">Seleccionar Archivo</label>
                                </div>
                              </div>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i>
                                Enviar
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}
        
    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
