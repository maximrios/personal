<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<?=$vcMsjSrv; ?>
<form id="<?= $vcFormName; ?>" name="<?= $vcFormName; ?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#tabs-content">
    <div class="form-group col-lg-12">
        <label for="idTitulo">Titulo</label>
        <?=form_dropdown('idFormacionTitulo', $titulos, $Reg['idFormacionTitulo'], 'class="form-control"');?>
    </div>
    <div class="row">
        <div class="col-lg-12 buttons">
        <button type="submit" class="btn btn-primary pull-right" value="Guardar"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar cambios</button>
        <button type="" class="btn btn-danger pull-right" ic-post-to="formaciones/listado/<?=$this->session->userdata('idAgente');?>" ic-target="#tabs-content" value="Cancelar"><span class="glyphicon glyphicon-floppy-remove"></span>&nbsp;&nbsp;Cancelar</button>
    </div>
    <input type="hidden" id="idAgente" name="idAgente" value="<?=$agente['idAgente']?>">
    <input type="hidden" id="idPersona" name="idPersona" value="<?=$agente['idPersona']?>">
    <input type="hidden" id="idFormacion" name="idFormacion" value="<?=$Reg['idFormacion']?>">
    <input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
</form>
   