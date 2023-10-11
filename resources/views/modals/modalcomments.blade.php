<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #621132;">
                <h5 class="modal-title" id="exampleModalFullscreenLabel">Cargar Comentarios</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            {!! Form::open(['method' => 'POST', 'id' => 'frmModal']) !!}
            <div class="modal-body">

                <label for="conductor">Conductor</label>
                <input type="text" name="conductor" id="conductor" class="form-control typeahead" autocomplete="off">
                <label for="floatingTextarea">Comentarios</label>
                <textarea class="form-control" name="comentario" id="floatingTextarea"></textarea>

            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-success" id="submitmodaladdcomment" value="Cargar">
            </div>
            {!! Form::hidden('idtemporal','', ['id'=> 'temporalId']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
