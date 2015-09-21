<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?php echo $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
		<div class="row">
			<div class="form-group col-md-6 col-lg-8">
				<label for="passwordUsuario">Contraseña</label>
				<input type="password" id="passwordUsuario" name="passwordUsuario" tabindex="1" placeholder="Contraseña anterior" value="" required class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-lg-8">
				<label for="npasswordUsuario">Nueva contraseña</label>
				<input type="password" id="npasswordUsuario" name="npasswordUsuario" tabindex="1" placeholder="Nueva contraseña" value="" required class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-lg-8">
				<label for="rnpasswordUsuario">Repetir nueva contraseña</label>
				<input type="password" id="rnpasswordUsuario" name="rnpasswordUsuario" tabindex="1" placeholder="Numero de documento. Sin puntos." value="" required class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 buttons">
            	<button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar cambios</button>
            	<a href="<?=site_url('administrador/agentes')?>" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</a>
        	</div>
		</div>
		<input type="hidden" id="idUsuario" name="idUsuario" value="<?= $this->autenticacion->idUsuario()?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>