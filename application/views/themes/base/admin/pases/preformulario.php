<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
<style type="text/css">
    .botones a {
        margin: 0.5em;
    }
</style>
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
    <div class="botones">
        <a href="comprobante/<?=$pase['idActuacionPase']?>" target="_blank" class="btn btn-success pull-right"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Imprimir Boleta de Pase</a>
        <a ic-post-to="pendientes" ic-target="#main_content" href="#" class="btn btn-primary"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;&nbsp;Volver</a>    
    </div>
    
