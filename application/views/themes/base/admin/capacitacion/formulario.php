<div class="panel panel-default">
	<div class="panel-heading">Agregar Carpeta</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-8">
            	<label for="nombreEvento">Nombre</label>
            	<input type="text" class="form-control" id="nombreEvento" name="nombreEvento" placeholder="Nombre del evento" value="<?=$Reg['nombreEvento']?>">
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="capacitacion/listado/" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
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