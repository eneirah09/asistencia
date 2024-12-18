<!-- AGREGAR -->
<div class="modal fade" id="addnew">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>NUEVA DEDUCCION</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="deducciones_add.php">
					<div class="form-group">
						<label for="description" class="col-sm-3 control-label">Descripción</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="description" name="description" required>
						</div>
					</div>
					<div class="form-group">
						<label for="amount" class="col-sm-3 control-label">Monto</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="amount" name="amount" required>
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
				<h4 class="modal-title"><b>Actualizar Deducción</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="deducciones_edit.php">
					<input type="hidden" class="decid" name="id">
					<div class="form-group">
						<label for="edit_description" class="col-sm-3 control-label">Descripción</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="edit_description" name="description">
						</div>
					</div>
					<div class="form-group">
						<label for="edit_amount" class="col-sm-3 control-label">Monto</label>

						<div class="col-sm-9">
							<input type="text" class="form-control" id="edit_amount" name="amount">
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

<!-- ELIMINAR -->
<div class="modal fade" id="delete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>ELIMINAR DEDUCCION</b></h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" method="POST" action="deducciones_del.php">
					<input type="hidden" class="decid" name="id">
					<div class="text-center">
						<p>¿Está seguro de que desea eliminar esta deducción?</p>
						<h2 id="del_deduction" class="bold"></h2>
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