<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?php echo $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
		<div class="row">
			<div class="form-group col-md-6 col-lg-12">
				<label for="nombreEstructura">Nombre completo de la estructura</label>
				<input type="text" id="nombreEstructura" name="nombreEstructura" tabindex="1" placeholder="Nombre completo de la estructura." value="<?php echo $Reg['nombreEstructura']?>" required class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 buttons">
            	<button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar cambios</button>
            	<button type="" class="btn btn-danger pull-right" ic-post-to="estructuras/listado/<?=$Reg['parentEstructura']?>" ic-target="#main_content" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>
        	</div>
		</div>
		<input type="hidden" id="parentEstructura" name="parentEstructura" value="<?php echo $Reg['parentEstructura']?>" />
		<input type="hidden" id="idEstructura" name="idEstructura" value="<?php echo $Reg['idEstructura']?>" />
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
	</form>
</div>