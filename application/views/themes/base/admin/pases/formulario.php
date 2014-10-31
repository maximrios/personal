<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
?>
    <div class="panel panel-default">
        <div class="panel-heading">Información de Actuación<a data-toggle="collapse" href="#prueba"></a></div>
            <div class="panel-body panel-collapse">
                <span class="col-lg-12">Tipo de Actuación: <?=$actuacion['nombreActuacionTipo']?></span>
                <span class="col-lg-6">N° de Actuación SICE: <?=$actuacion['referenciaActuacion']?></span>
                <span class="col-lg-6">N° de Actuación SGA (SiGeP): <?=$actuacion['codigoActuacion']?></span>
                <span class="col-lg-12">Iniciador: (<?=$actuacion['iudIniciador']?>) - <?=$actuacion['nombreIniciador']?></span>
                <span class="col-lg-12">Remitente: (<?=$actuacion['iudRemitente']?>) - <?=$actuacion['nombreRemitente']?></span>
                <span class="col-lg-12">Carátula: <?=$actuacion['caratulaActuacion']?></span>
                <span class="col-lg-12">Cantidad de Folios: <?=$actuacion['foliosActuacion']['foliosActuacion']?></span>

            
                <span class="col-lg-6">Area en la que se encuentra: <?=$actuacion['nombreEstructuraActual']?></span>
                <span class="col-lg-6">Estado de Actuación: <?=$actuacion['nombreActuacionEstado']?></span>
            </div>
        </div>
    </div>

	<?=$vcMsjSrv; ?>
	<form id="<?=$vcFormName;?>" name="<?=$vcFormName;?>" ic-post-to="<?=$vcFrmAction;?>" ic-target="#main_content">
    	<div class="form-group col-lg-12">
    		<label for="nombreOrigen">Remitente</label>
			<input type="text" id="nombreOrigen" name="nombreOrigen" tabindex="1" class="form-control" placeholder="Nombre del Area de Origen." value="<?=$this->autenticacion->nombreMesaEstructura()?>" readonly>
    	</div>
        <div class="form-group col-lg-12">
            <label for="idDestino">Destino</label>
            <?=form_dropdown('idDestino', $mesas, $Reg['idDestino'], 'tabindex="2" class="form-control"');?>
        </div>
        <!--<div class="form-group col-lg-1">
            <label for="foliosActuacionPase">Folios </label>
            <input type="text" id="foliosActuacion" name="foliosActuacion" tabindex="3" class="form-control" value="<?=$actuacion['foliosActuacion']?>">
        </div>-->
        <div class="form-group col-lg-2">
            <label for="foliosActuacionPase">Folios agregados</label>
            <input type="text" id="foliosActuacionPase" name="foliosActuacionPase" tabindex="3" class="form-control" placeholder="Cantidad" value="<?=$Reg['foliosActuacionPase']?>">
        </div>
        <div class="form-group col-lg-12">
            <label for="idTipoPase">Motivo</label>
            <?=form_dropdown('idTipoPase', $tipos, $Reg['idTipoPase'], 'tabindex="2" class="form-control"');?>
        </div>
    	<div class="form-group col-lg-12">
    		<label for="observacionActuacionPase">Observaciones</label>
            <textarea id="observacionActuacionPase" name="observacionActuacionPase" tabindex="4" class="form-control" placeholder="Utilice esta campo para consignar solo ajustes relevantes del trámite" rows="3"><?=$Reg['observacionActuacionPase']?></textarea>
    	</div>
        <div class="col-lg-12 botones">
            <!--<input id="btnnuevo" type="submit" class="btn btn-primary btn-accion pull-right" value="Guardar"/>    -->
            <a ic-post-to="pendientes" ic-target="#main_content" href="#" class="btn btn-danger btn-accion"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</a>
            <button type="submit" class="btn btn-primary btn-accion"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Generar Pase</button>
        </div>
        <input type="hidden" id="idActuacionPase" name="idActuacionPase" value="<?=$Reg['idActuacionPase']?>">
		<input type="hidden" id="idActuacion" name="idActuacion" value="<?=$actuacion['idActuacion']?>">
        <input type="hidden" id="idPaseEstado" name="idPaseEstado" value="<?=$Reg['idPaseEstado']?>">
        <input type="hidden" id="fechaEnvioActuacionPase" name="fechaEnvioActuacionPase" value="<?=$Reg['fechaEnvioActuacionPase']?>">
        <input type="hidden" id="idOrigen" name="idOrigen" value="<?=$this->autenticacion->idMesaEstructura()?>">
        <input type="hidden" id="idUsuarioRemitente" name="idUsuarioRemitente" value="<?=$this->autenticacion->idUsuario()?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
