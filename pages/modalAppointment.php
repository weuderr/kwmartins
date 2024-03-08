<div id="appointmentModal" class="modal fade appointment-modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agendar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" name="professional-phone" value="">
                <input type="hidden" name="message" value="">
                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Nome</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">Telefone</label>
                    <div class="col-md-6">
                        <input id="phone" type="text" class="form-control" name="phone" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="sendAppointment()">Encaminhar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>