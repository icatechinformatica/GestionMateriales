<div class="modal fade" id="modaldelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header text-white" style="background-color: #621132;">
            <h5 class="modal-title" id="exampleModalFullscreenLabel">¡Atención!</h5>
        </div>
        <div class="modal-body">
            <form id="formDelete" action="" method="post">
                @method('DELETE')
                @csrf
                <h6>Eliminar Elemento de la factura</h6>
                <p>¿Desea Eliminar el siguiente registro?</p>
                <p id="cp"></p>
                <input type="hidden" name="valorId" id="valorId">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-trash"></i> Eliminar!
                </button>
            </form>
        </div>
        <div class="modal-footer">
            <a class="btn btn-primary" href="#"  aria-label="Close">Cancelar</a>
        </div>
      </div>
    </div>
</div>
