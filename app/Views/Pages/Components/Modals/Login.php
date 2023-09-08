<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form role="form" id="loginForm">
                <div class="modal-body">

                    <div class="response"></div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Usuario" autofocus required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="loginBtn" class="btn btn-primary"><i class="fa fa-sign-in"></i> Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Login Modal -->