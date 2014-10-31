<div class="panel panel-default">
	<div class="panel-heading">Agregar Evento</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-8">
            	<label for="nombreEvento">Nombre</label>
            	<input type="text" class="form-control" id="nombreEvento" name="nombreEvento" placeholder="Nombre del evento" value="<?=$Reg['nombreEvento']?>">
        	</div>
        	<div class="form-group col-lg-2">
            	<label for="fechaDesdeEvento">Fecha Desde</label>
            	<input type="text" class="form-control fecha" id="fechaDesdeEvento" name="fechaDesdeEvento" placeholder="dd/mm/yyyy" value="<?=$Reg['fechaDesdeEvento']?>">
        	</div>
        	<div class="form-group col-lg-2">
            	<label for="fechaHastaEvento">Fecha Hasta</label>
            	<input type="text" class="form-control fecha" id="fechaHastaEvento" name="fechaHastaEvento" placeholder="dd/mm/yyyy" value="<?=$Reg['fechaHastaEvento']?>">
        	</div>
        	<div class="form-group col-lg-12">
            	<label for="descripcionEvento">Descripción</label>
            	<textarea class="form-control" id="descripcionEvento" name="descripcionEvento" placeholder="Describa las actividades a realizar en el evento"><?=$Reg['descripcionEvento']?></textarea>
        	</div>
        	<div class="form-group col-lg-6">
            	<label for="domicilioEvento">Domicilio</label>
            	<input type="text" class="form-control" id="domicilioEvento" name="domicilioEvento" placeholder="Domicilio del evento" value="<?=$Reg['domicilioEvento']?>">
        	</div>
        	<div class="form-group col-lg-3">
            	<label for="telefonoEvento">Teléfono</label>
            	<input type="text" class="form-control" id="telefonoEvento" name="telefonoEvento" placeholder="Solo números. Ej.:3874212121" value="<?=$Reg['telefonoEvento']?>">
        	</div>
        	<div class="form-group col-lg-3">
            	<label for="emailEvento">Email</label>
            	<input type="email" class="form-control" id="emailEvento" name="emailEvento" placeholder="ejemplo@servidor.com" value="<?=$Reg['emailEvento']?>">
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="eventos/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <input type="hidden" id="idEvento" name="idEvento" value="<?=$Reg['idEvento']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('.fecha').datetimepicker({
        pickTime: false
    });
</script>