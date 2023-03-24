{{-- modal de envio de sulicitud--}}
@if (isset($v->id))
    <div class="modal fade" id="exampleModal-{{ $v->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ENVIAR REQUISICIÓN DE MATERIALES</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿REALMENTE DESEA ENVIAR LA REQUICISIÓN?
            </div>
            <div class="modal-footer">
                {!! Form::open(['method' => 'GET', 'route' => ['requisicion.update', 'id' => base64_encode($v->id)]]) !!}
                    {!!
                        Form::button(
                            '<i class="fas fa-send"></i> Enviar', 
                            ['class' => 'btn btn-success', 'type' => 'submit']
                        )
                    !!}
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                {!! Form::close() !!}
            </div>
            </div>
        </div>
    </div>
@endif
{{-- modal de envio de solicitud END --}}