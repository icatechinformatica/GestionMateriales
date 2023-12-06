
{{-- MODAL DE INSERCIÓN DETALLES DE FACTURA DMC --}}
<div class="modal fade" id="modalBillingTheme" tabindex="-1" role="dialog" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #621132;">
                <h5 class="modal-title" id="exampleModalFullscreenLabel">Agregar Detalle de la Factura</h5>
            </div>
            <div class="modal-body">
                <form id="FormBilling" name="FormBilling">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            {!! Form::label('clave_producto', 'Clave Producto') !!}
                            <div class="custom-file">
                                {!! Form::text('clave_producto','',['class'=> 'form-control '.($errors->has('clave_producto') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'clave_producto']) !!}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            {!! Form::label('cantidad', 'Cantidad') !!}
                            <div class="custom-file">
                                {!! Form::text('cantidad', '', ['class' => 'form-control '.($errors->has('cantidad') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'cantidad']) !!}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            {!! Form::label('clave_unidad', 'Clave Unidad') !!}
                            <div class="custom-file">
                                {!! Form::text('clave_unidad', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'clave_unidad']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            {!! Form::label('descripcion', 'Descripción') !!}
                            <div class="custom-file">
                                {!! Form::textarea('descripcion', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'descripcion', 'cols' => 11, 'rows' => 3]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            {!! Form::label('valor_unitario', 'Valor Unitario') !!}
                            <div class="custom-file">
                                {!! Form::text('valor_unitario', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'valor_unitario']) !!}
                                @error('valor_unitario')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            {!! Form::label('impuestos', 'Impuestos') !!}
                            <div class="custom-file">
                                {!! Form::text('impuestos', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'impuestos']) !!}
                                @error('impuestos')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            {!! Form::label('importe', 'Importe') !!}
                            <div class="custom-file">
                                {!! Form::text('importe', '', ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'importe']) !!}
                                @error('importe')
                                    <div class="alert alert-danger mt-1 mb-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" type="submit" id="addBilling">Agregar</button>
                    <input type="hidden" name="FormDetalleFactura" id="idFormDetalleFactura">
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="#" data-dismiss="modal" aria-label="Close">Cancelar</a>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DE INSERCIÓN DETALLES DE FACTURA DMC END --}}
