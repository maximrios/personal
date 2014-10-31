<div class="panel panel-default">
	<div class="panel-heading">Agregar Suscriptor</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
            <div class="form-group col-lg-6">
                <label for="nombrePersona">Nombre</label>
                <input type="text" class="form-control" id="nombrePersona" name="nombrePersona" tabindex="1" placeholder="Nombre de suscriptor" value="<?=$Reg['nombrePersona']?>">
            </div>
			<div class="form-group col-lg-6">
            	<label for="apellidoPersona">Apellido</label>
            	<input type="text" class="form-control" id="apellidoPersona" name="apellidoPersona" tabindex="2" placeholder="Apellido de suscriptor" value="<?=$Reg['apellidoPersona']?>">
        	</div>
            <div class="form-group col-lg-12">
                <label for="emailPersona">Email</label>
                <input type="text" class="form-control" id="emailPersona" name="emailPersona" tabindex="3" placeholder="Email de suscriptor" value="<?=$Reg['emailPersona']?>">
            </div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="newsletter/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <input type="hidden" id="idPersona" name="idPersona" value="<?=$Reg['idPersona']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('.fecha').datetimepicker({
        pickTime: false
    });
</script>