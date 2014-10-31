<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<?php echo $vcMsjSrv; ?>
	<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
		<div class="row">
			<div class="form-group col-md-6 col-lg-8">
				<label for="dniPersona">Documento</label>
				<input type="text" id="dniPersona" name="dniPersona" tabindex="1" placeholder="Numero de documento. Sin puntos." value="<?php echo $Reg['dniPersona']?>" class="form-control" readonly>
			</div>
		</div>
    	<div class="row">
			<div class="form-group col-md-6 col-lg-6">
				<label for="nombrePersona">Nombre</label>
				<input type="text" id="nombrePersona" name="nombrePersona" tabindex="2" placeholder="Nombre/s del Agente" value="<?php echo $Reg['nombrePersona']?>"class="form-control" readonly>
			</div>
			<div class="form-group col-md-6 col-lg-6">
				<label for="apellidoPersona">Apellido</label>
				<input type="text" id="apellidoPersona" name="apellidoPersona" tabindex="3" placeholder="Apellido/s del Agente" value="<?php echo $Reg['apellidoPersona']?>"class="form-control" readonly>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-lg-6">
				<label for="idMotivoAntecedente">Motivo</label>
				<?php echo form_dropdown('idMotivoAntecedente', $motivos, '', ' tabindex="7" required class="form-control"');?>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-md-6 col-lg-6">
				<label for="desdeAgenteAntecedente">Fecha desde antecedente</label>
				<input type="text" id="desdeAgenteAntecedente" name="desdeAgenteAntecedente" tabindex="5" placeholder="dd/mm/yyyy" value="" required class="fecha form-control">
			</div>
			<div class="form-group col-md-6 col-lg-6">
				<label for="desdeAgenteAntecedente">Fecha hasta antecedente</label>
				<input type="text" id="desdeAgenteAntecedente" name="desdeAgenteAntecedente" tabindex="5" placeholder="dd/mm/yyyy" value="" required class="fecha form-control">
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 form-group">
				<label for="observacionesAgenteAntecedente">Observaciones</label>
				<textarea id="observacionesAgenteAntecedente" name="observacionesAgenteAntecedente" class="form-control"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 buttons">
            	<button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Dar de baja</button>
            	<button type="" class="btn btn-danger pull-right" ic-post-to="agentes/listado" ic-target="#main_content" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>
        	</div>
		</div>
		<input type="hidden" id="idPersona" name="idPersona" value="<?php echo $Reg['idPersona']?>" />
		<input type="hidden" id="idAgente" name="idAgente" value="<?php echo $Reg['idAgente']?>" />
		<input type="hidden" id="idTipoDni" name="idTipoDni" value="1">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
<script type="text/javascript">
	/*$('.fecha').datepicker({
		format: 'dd/mm/yyyy',
	}).on('changeDate', function (ev) {
    	$(this).datepicker('hide');
	});*/
</script>