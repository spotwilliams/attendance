<div class="modal fade" id="{{$idModal}}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{$titleModal}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="box box-warning">
                            <div class="box-body box-profile">
                                <h4 class="profile-username text-center">Datos relevantes</h4>
                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>Agente</b> <a class="pull-right modal-agente"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>CUIT</b> <a class="pull-right modal-cuit"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Fecha</b> <a class="pull-right modal-fecha"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Licencia</b> <a class="pull-right modal-presentismo"></a>
                                    </li>


                                </ul>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="col-xs-7 table-responsive">
                        <table class="table table-striped table-comentario">
                            <thead>
                            <tr>
                                <th>Comentario</th>
                                <th>Fecha y Hora</th>
                                <th>Usuario</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 form-group">
                        <textarea class="form-control modal-comentario" rows="3"
                                  placeholder="Comentarios de la fecha (400 caracteres máximo)"></textarea>
                    </div>
                </div>
            </div>
            <input type="hidden" class="modal-id-agente"/>
            <input type="hidden" class="modal-id-presentismo"/>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary modal-save">Guardar comentario</button>
            </div>
        </div>
    </div>
</div>