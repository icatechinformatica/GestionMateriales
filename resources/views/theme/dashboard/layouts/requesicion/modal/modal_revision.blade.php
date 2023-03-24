{{-- modal para revisión blade --}}
  <div class="modal fade" id="modalRevision-" tabindex="-1" aria-labelledby="modalRevisionLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalRevisionLabel"></h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="text" class="form-control" id="variable">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          {!! Form::open(['route' => 'requisicion.revision.enviarRetorno', 'method' => 'POST']) !!}
            <button type="submit" class="btn btn-success">Enviar</button>
            <input type="hidden" class="form-control" id="variable" name="variable_envio">
            <input type="hidden" class="form-control" id="valor" name="valorRequisicion">
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>  
{{-- modal para revisión blade END --}}