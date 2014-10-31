<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
	<div class="panel panel-default">
    <div class="panel-heading">Información de Actuación<a data-toggle="collapse" href="#prueba"></a></div>
        <div class="panel-body panel-collapse">
            <?=$vcMsjSrv?>
            <span class="col-lg-12">Tipo de Actuación: <?=$actuacion['nombreActuacionTipo']?></span>
            <span class="col-lg-6">N° de Actuación SICE: <?=$actuacion['referenciaActuacion']?></span>
            <span class="col-lg-6">N° de Actuación SGA (SiGeP): <?=$actuacion['codigoActuacion']?></span>
            <span class="col-lg-12">Iniciador: (<?=$actuacion['iudIniciador']?>) - <?=$actuacion['nombreIniciador']?></span>
            <span class="col-lg-12">Remitente: (<?=$actuacion['iudRemitente']?>) - <?=$actuacion['nombreRemitente']?></span>
            <span class="col-lg-12">Carátula: <?=$actuacion['caratulaActuacion']?></span>
            <span class="col-lg-12">Cantidad de Folios: <?=$actuacion['foliosActuacion']?></span>

            
            <span class="col-lg-6">Area en la que se encuentra: <?=$actuacion['nombreEstructuraActual']?></span>
            <span class="col-lg-6">Estado de Actuación: <?=$actuacion['nombreActuacionEstado']?></span>
        </div>
    </div>
</div>
    <form id="form-recepcion" name="form-recepcion" ic-post-to="recibir" ic-target="#main_content">
    	<input type="hidden" id="idActuacionPase" name="idActuacionPase" value="<?=$pase['idActuacionPase']?>">
    	<input type="hidden" id="idActuacion" name="idActuacion" value="<?=$pase['idActuacion']?>">
        <div class="botones">
            <a href="#" ic-post-to="pbandeja" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</a>
            <button class="btn btn-primary pull-right btn-accion"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Recibir Pase</button>    
        </div>
    </form>