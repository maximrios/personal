<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
    $registro = ((int) $Reg['idActuacion'] != 0)? true:false;
    $interno = ($this->autenticacion->idMesaEstructura() == 30)? false:true;
?>
    <?= $vcMsjSrv; ?>
	<form id="formu" name="<?=$vcFormName;?>" ic-post-to="<?=$vcFrmAction;?>" method="post" ic-target="#main_content">
        <div class="form-group col-lg-7">
            <label for="idActuacionTipo">Tipo de Actuacion</label>
            <?=form_dropdown('idActuacionTipo', $tipos, 4, 'class="form-control" disabled');?>
        </div>
        <?php
        $fecha = ($Reg['fechaCreacionActuacion'])? $Reg['fechaCreacionActuacion']:date('d/m/Y');
        ?>
        <div class="form-group col-lg-5">
            <label for="fechaCreacionActuacion">Fecha de Creación</label>
            <input type="text" id="fechaCreacionActuacion" name="fechaCreacionActuacion" class="form-control" style="width:150px;" placeholder="Fecha de Recepción." value="<?=$fecha?>" readonly>
        </div>
        <div class="form-group col-lg-1">
            <label for="cdsSICE">CDS</label>
            <input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=($Reg['cdsSICE'])? $Reg['cdsSICE']:$this->autenticacion->cdsMesaEstructura()?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="cdsSICE">CDS</label>
            <?=form_dropdown('cdsSICE', $estructuras_cds, 1, 'class="form-control" disabled');?>
            <!--<input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=$Reg['cdsSICE']?>">-->
        </div>
        <div class="form-group col-lg-1">
            <label>IUD</label>
            <input type="text" class="form-control col-lg-1" id="iudSICE" name="iudSICE" value="<?=($Reg['iudSICE'])? $Reg['iudSICE']:$this->autenticacion->iudMesaEstructura()?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="idIniciador">Organismo | Area Iniciadora</label>
            <?=form_dropdown('idIniciador', $estructuras, ($Reg['idIniciador'])? $Reg['idIniciador']:$this->autenticacion->idMesaEstructura(), 'class="form-control" disabled');?>
        </div>
        <div class="form-group col-lg-2 <?=(!$Reg['numeroSICE'])? 'hidden':''?>">
            <label>Número</label>
            <input type="text" class="form-control col-lg-1" id="numeroSICE" name="numeroSICE" value="<?=$Reg['numeroSICE']?>">
        </div>
        <div class="form-group col-lg-1">
            <label>Período</label>
            <input type="text" class="form-control col-lg-1" id="periodoSICE" name="periodoSICE" value="<?=($Reg['periodoSICE'])? $Reg['periodoSICE']:date('Y')?>" readonly>
        </div>
        <div class="form-group col-lg-1 <?=(!$Reg['numeroSICE'])? 'hidden':''?>">
            <label>Corresp.</label>
            <input type="text" class="form-control col-lg-1" id="correspondeSICE" name="correspondeSICE" value="<?=$Reg['correspondeSICE']?>">
        </div>
        <div class="form-group col-lg-12">
            <label for="caratulaActuacion">Carátula | Extracto</label>
            <textarea id="caratulaActuacion" name="caratulaActuacion" class="form-control" placeholder="Carátula | Extracto" rows="5"><?=$Reg['caratulaActuacion']?></textarea>
        </div>
        <div class="form-group col-lg-12">
            <label for="observacionesActuacion">Observaciones</label>
            <textarea id="observacionesActuacion" name="observacionesActuacion" class="form-control" placeholder="Observaciones" rows="5"><?=$Reg['observacionesActuacion']?></textarea>
        </div>
		<!--<div class="form-group col-lg-5">
    		<label for="fechaCreacionActuacion">Fecha de Creación | Recepción</label>
			<input type="text" id="fechaCreacionActuacion" name="fechaCreacionActuacion" class="form-control" placeholder="Fecha de Recepción." value="<?=$Reg['fechaCreacionActuacion']?>">
    	</div>-->
        
        <div class="form-group col-lg-4">
            <label for="foliosActuacion">Folios</label>
            <input type="text" id="foliosActuacion" name="foliosActuacion" class="form-control"  style="width:80px;" placeholder="Cantidad" value="<?=$Reg['foliosActuacion']?>">
        </div>
        <div class="col-lg-11 col-lg-offset-11">
            
        </div>
        <div class="col-lg-12 botones">
            <!--<input id="btnnuevo" type="submit" class="btn btn-primary btn-accion pull-right" value="Guardar"/>-->
            
            <a ic-post-to="actuaciones/consulta" ic-target="#main_content" href="#" class="btn btn-danger btn-accion"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</a>
            <button id="btnGuardar" class="btn btn-primary btn-accion"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        </div>
		<input type="hidden" id="idActuacion" name="idActuacion" value="">
        <input type="hidden" id="idActuacionTipo" name="idActuacionTipo" value="4">
        <input type="hidden" id="iudEstructura" name="iudEstructura" value="<?=$this->autenticacion->iudMesaEstructura()?>">
        <input type="hidden" id="idEstructura" name="idEstructura" value="<?=$this->autenticacion->idMesaEstructura()?>">
        <!--<input type="hidden" id="nombreEstructura" name="nombreEstructura" value="<?=$this->lib_ubicacion->nombreEstructura()?>">
        <input type="hidden" id="idUsuario" name="idUsuario" value="<?=$Reg['idUsuario']?>">-->
        <input type="hidden" id="idIniciador" name="idIniciador" value="<?=$this->autenticacion->idMesaEstructura()?>
        ">
        <input type="hidden" id="idRemitenteActuacion" name="idRemitenteActuacion" value="<?=$this->autenticacion->idMesaEstructura()?>
        ">
        <input type="hidden" id="iudRemitenteActuacion" name="iudRemitenteActuacion" value="<?=$this->autenticacion->iudMesaEstructura()?>">
        <input type="hidden" id="tipoActuacion" name="tipoActuacion" value="1"/>
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>
<script type="text/javascript">
	$('#caratulaActuacion').focus();
	//$(document).on('ready', function() {
        $('#btnGuardar').on('click', function(event) {
            var data = $('#formu').serialize();
            $('#formu').viaAjax('send', {'url': 'administrator/actuaciones/guardar', 'vars': data, 'type':'post'});
            event.preventDefault();
        });
    //});
</script>