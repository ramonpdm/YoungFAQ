<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title" id="registerModalLabel">Crear una cuenta</h5>
                <button tabindex="-3" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="registerForm">
                <div class="modal-body">
                    <div id="registerResponse">
                    </div>
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="Usuario" type="text" id="usernameReg" name="username" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Nombre completo" type="text" id="fullnameReg" name="fullname" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Correo electrónico" type="email" id="emailReg" name="email" autofocus required>
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Contraseña" type="password" id="passwordReg" name="password" required>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="register">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="registerBtn" type="submit" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i> Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Register Modal -->