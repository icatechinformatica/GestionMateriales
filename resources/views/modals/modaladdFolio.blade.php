<div class="modal fade" id="addFolios" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-white" style="background-color: #621132;">
            <h5 class="modal-title" id="exampleModalFullscreenLabel">Denominación del vale</h5>
        </div>
        <div class="modal-body">
            <form id="formDelete" action="" method="post">
                <select id="selectedFolio" name="select" class="form-control">
                    <option value="" selected>--seleccionar--</option>
                    {{-- @foreach ($getDenominacion as $item => $value)
                        <option value="{{ $value['denominacion'] }}">{{ $value['denominacion'] }}</option>
                    @endforeach --}}
                </select>
                <br>
                <a  class="btn btn-success" id="cargarFolios">
                   <i class="fas fa-plus"></i> Agregar!
                </a>
            </form>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" data-dismiss="modal" aria-label="Close">Cancelar</a>
        </div>
      </div>
    </div>
</div>
