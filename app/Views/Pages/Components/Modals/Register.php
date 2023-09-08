<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title" id="registerModalLabel">Crear una cuenta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" id="registerForm">
                <div class="modal-body">

                    <div class="response"></div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="usernameReg" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="usernameReg" id="usernameReg" placeholder="Usuario" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="firstname" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Nombre" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="lastname" class="form-label">Apellido</label>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellido" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Correo Electrónico" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="passwordReg" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="passwordReg" id="passwordReg" placeholder="Contraseña" autofocus required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Registrarse</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Register Modal -->