<!--AGREGAR -->
<div class="modal fade" id="addnew">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>AGREGAR HORARIO</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="horario_add.php">
					<div class="form-group">
						<label for="time_in" class="col-sm-3 control-label">Hora Entrada</label>
						<div class="col-sm-9">
							<div class="bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="time_in" name="time_in" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="time_out" class="col-sm-3 control-label">Hora Salida</label>

						<div class="col-sm-9">
							<div class="bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="time_out" name="time_out" required>
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
				<button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Guardar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- EDITAR -->
<div class="modal fade" id="edit">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>ACTUALIZAR HORARIO</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="horario_edit.php">
					<input type="hidden" id="timeid" name="id">
					<div class="form-group">
						<label for="edit_time_in" class="col-sm-3 control-label">Hora Entrada</label>

						<div class="col-sm-9">
							<div class="bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="edit_time_in" name="time_in">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="edit_time_out" class="col-sm-3 control-label">Hora Salida</label>

						<div class="col-sm-9">
							<div class="bootstrap-timepicker">
								<input type="text" class="form-control timepicker" id="edit_time_out" name="time_out">
							</div>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
				<button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Actualizar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- BORRAR -->
<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>ELIMINAR HORARIO</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="horario_del.php">
					<input type="hidden" id="del_timeid" name="id">
					<div class="text-center">
						<p>¿Está seguro de que desea eliminar este horario?</p>
						<h2 id="del_schedule" class="bold"></h2>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
				<button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div>