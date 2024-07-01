<div id="appointmentModal" class="modal fade appointment-modal" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Agendar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" name="professional-phone" value="">
                <input type="hidden" name="message" value="">
                <p id="modalAppointmentName" class="text-center"></p>
                <p class="text-center">Preencha os campos abaixo para pre-agendar um horário.</p>
                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="name" type="text" class="form-control" name="name" placeholder="Nome" required>
                    </div>
                </div>
                <div class="form-group row mt-1">
                    <div class="col-md-12">
                        <input id="phone" type="text" class="form-control" name="phone" placeholder="Telefone" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" onclick="sendAppointment()">Encaminhar</button>
            </div>
        </div>
    </div>
</div>