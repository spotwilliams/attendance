<div class="modal fade" id="{{$idModal}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{$titleModal}}</h4>
            </div>
            <div class="modal-body">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Agente</th>
                            <th>CUIT</th>
                            <th>Fecha</th>
                            <th>Presentismo</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="modal-agente"></td>
                            <td class="modal-cuit"></td>
                            <td class="modal-fecha"></td>
                            <td class="modal-presentismo"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12 form-group">
                    <label>Comentarios</label>
                    <textarea class="form-control modal-comentario" rows="3" placeholder="Comentarios de la fecha (400 caracteres máximo)..."></textarea>
                </div>
            </div>
            <input type="hidden" class="modal-id-agente"/>
            <input type="hidden" class="modal-id-tipo-presentismo"/>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary modal-save">Save changes</button>
            </div>
        </div>
    </div>
</div>