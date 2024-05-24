<!-- Modal -->
<div class="modal fade" id="modalAsignarEquipo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignar Equipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmAsignaEquipo" method="POST" onsubmit="return asignarEquipo()">
                    <div class="form-group row">
                        <label for="idPersona" class="col-sm-3 col-form-label">Nombre de Persona</label>
                        <div class="col-sm-9">
                            <select name="idPersona" id="idPersona" class="form-control" required>
                                <option value="">Selecciona una opción</option>
                                <?php
                                $sql = "SELECT persona.id_persona, CONCAT(persona.paterno, ' ', persona.materno, ' ', persona.nombre) AS nombre
                                        FROM t_persona AS persona
                                        INNER JOIN t_usuarios AS usuario ON persona.id_persona = usuario.id_persona AND usuario.id_rol = 1
                                        ORDER BY persona.paterno";
                                $respuesta = mysqli_query($conexion, $sql);
                                while ($mostrar = mysqli_fetch_array($respuesta)) {
                                    echo "<option value='{$mostrar['id_persona']}'>{$mostrar['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="idEquipo" class="col-sm-3 col-form-label">Tipo de Equipo</label>
                        <div class="col-sm-9">
                            <select name="idEquipo" id="idEquipo" class="form-control" required>
                                <option value="">Selecciona una opción</option>
                                <?php
                                $sql = "SELECT id_equipo, nombre FROM t_cat_equipo ORDER BY nombre";
                                $respuesta = mysqli_query($conexion, $sql);
                                while ($mostrar = mysqli_fetch_array($respuesta)) {
                                    echo "<option value='{$mostrar['id_equipo']}'>{$mostrar['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marca" class="col-sm-3 col-form-label">Marca</label>
                        <div class="col-sm-9">
                            <input type="text" name="marca" id="marca" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="modelo" class="col-sm-3 col-form-label">Modelo</label>
                        <div class="col-sm-9">
                            <input type="text" name="modelo" id="modelo" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="color" class="col-sm-3 col-form-label">Color</label>
                        <div class="col-sm-9">
                            <input type="text" name="color" id="color" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                        <div class="col-sm-9">
                            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="memoria" class="col-sm-3 col-form-label">Memoria</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="memoria" name="memoria">
                        </div>
                        <label for="discoDuro" class="col-sm-3 col-form-label">Disco Duro</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="discoDuro" name="discoDuro">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="procesador" class="col-sm-3 col-form-label">Procesador</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="procesador" name="procesador">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Asignar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
