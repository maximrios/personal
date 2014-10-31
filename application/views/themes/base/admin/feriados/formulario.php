<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<div class="forms">
	<?php echo $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
		<div class="row">
			<div class="form-group col-lg-4">
				<label for="fechaFeriado">Fecha</label>
				<input type="text" id="fechaFeriado" name="fechaFeriado" tabindex="12" placeholder="dd/mm/aaaa" value="<?php echo $Reg['fechaFeriado'];?>" class="form-control fecha">
			</div>
			<div class="form-group col-lg-8">
				<label for="motivoFeriado">Motivo</label>
				<input type="text" id="motivoFeriado" name="motivoFeriado" tabindex="12" placeholder="Motivo del feriado" value="<?php echo $Reg['motivoFeriado'];?>" class="form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 buttons">
				<input type="hidden" id="idFeriado" name="idFeriado" value="<?php echo $Reg['idFeriado'];?>">
            	<button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar cambios</button>
            	<button type="" class="btn btn-danger pull-right" ic-post-to="feriados/listado" ic-target="#main_content" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>
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