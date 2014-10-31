<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?php echo $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
		<div class="row">
			<div class="form-group col-lg-12">
				<label for="idAgente">Licencia</label>
				<?php echo form_dropdown('idAgente', $agentes, $Reg['idAgente'], ' tabindex="6" required class="form-control"');?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-12">
				<label for="idEcivil">Licencia</label>
				<?php echo form_dropdown('idLicencia', $licencias, $Reg['idLicencia'], ' tabindex="6" required class="form-control"');?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-6">
				<label for="desdeAgenteLicencia">Desde</label>
				<input type="text" id="desdeAgenteLicencia" name="desdeAgenteLicencia" tabindex="12" placeholder="dd/mm/aaaa" value="<?php echo $Reg['desdeAgenteLicencia'];?>" class="form-control fecha">
			</div>
			<div class="form-group col-lg-6">
				<label for="hastaAgenteLicencia">Hasta</label>
				<input type="text" id="hastaAgenteLicencia" name="hastaAgenteLicencia" tabindex="12" placeholder="dd/mm/aaaa" value="<?php echo $Reg['hastaAgenteLicencia'];?>" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 buttons">
				<input type="hidden" id="idAgenteLicencia" name="idAgenteLicencia" value="<?php echo $Reg['idAgenteLicencia'];?>">
            	<button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar cambios</button>
            	<button type="" class="btn btn-danger pull-right" ic-post-to="licencias/listado" ic-target="#main_content" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>
        	</div>
		</div>
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
</div>
<script>
	/*$('.fecha').datepicker({
		format: 'dd/mm/yyyy',
	}).on('changeDate', function (ev) {
    	$(this).datepicker('hide');
	});*/
	/*$("#uploadBtn").on('onchange', function () {
    	document.getElementById("uploadFile").value = this.value;
	});*/


	//$('#idPais').on('change', selects);
	/*$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
		}
	});*/
	/*$("#nombrePersona").autocomplete({
		source: "administrator/personas/obtenerAutocompletePersonas",
		minLength: 3,
		select: function(event, ui){
			$('#idPersona').val(ui.item.id);
			var seleccion = ui.item.id;
			$.ajax({
				type: 'post',
				url: "administrator/agentes/formulario",
				data: 'idPersona='+seleccion
			})
		}
	});*/
</script>