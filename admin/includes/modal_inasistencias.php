<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Agregar Nueva Inasistencia</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="inasistencias_add.php">
                    <div class="form-group">
                        <label for="employee_id" class="col-sm-3 control-label">Empleado</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="employee_id" name="employee_id" required>
                                <option value="" selected>- Seleccionar -</option>
                                <?php
                                $sql = "SELECT * FROM employees";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['firstname']) . ' ' . htmlspecialchars($row['lastname']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="datepicker_add" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_add" name="date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="absence_type" class="col-sm-3 control-label">Tipo de Inasistencia</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="absence_type" name="absence_type_id" required>
                                <option value="" selected>- Seleccionar -</option>
                                <?php
                                $sql = "SELECT * FROM absence_types";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['description']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                   <!--  <div class="form-group">
                        <label for="reason" class="col-sm-3 control-label">Razón</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="reason" name="reason"></textarea>
                        </div>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="add">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Editar Inasistencia</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="inasistencias_edit.php">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="datepicker_edit" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-9">
                            <div class="date">
                                <input type="text" class="form-control" id="datepicker_edit" name="date" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_absence_type" class="col-sm-3 control-label">Tipo de Inasistencia</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_absence_type" name="absence_type_id" required>
                                <?php
                                $sql = "SELECT * FROM absence_types";
                                $query = $conn->query($sql);
                                while ($row = $query->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['description']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="edit_reason" class="col-sm-3 control-label">Razón</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="edit_reason" name="reason"></textarea>
                        </div>
                    </div> -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" name="edit">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Eliminar Inasistencia</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="inasistencias_del.php">
                    <input type="hidden" id="del_id" name="id">
                    <div class="text-center">
                        <p>¿Estás seguro de eliminar esta inasistencia?</p>
                        <h2 id="del_employee_name" class="bold"></h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger" name="delete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
