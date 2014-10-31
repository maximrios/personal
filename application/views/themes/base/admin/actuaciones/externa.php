<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
    $registro = ((int) $Reg['idActuacion'] != 0)? true:false;
    $interno = ($this->autenticacion->idMesaEstructura() == 30)? false:true;
?>
    <?= $vcMsjSrv; ?>
    <form id="formu" name="<?=$vcFormName;?>" action="<?=$vcFrmAction;?>" method="post" target="contenido-abm">
        <div class="form-group col-lg-7">
            <label for="idActuacionTipo">Tipo de Actuacion</label>
            <?=form_dropdown('idActuacionTipo', $tipos, $Reg['idActuacionTipo'], 'class="form-control"');?>
        </div>
        <div class="form-group col-lg-5">
            <label for="fechaCreacionActuacion">Fecha de Creación (SICE)</label>
            <div class="input-group date" id="fechaDesde" style="width:150px;">
            	<input type="text" id="fechaCreacionActuacion" name="fechaCreacionActuacion" class="form-control" placeholder="dd/mm/yyyy" value="<?=$Reg['fechaCreacionActuacion']?>">
      			<span class="input-group-btn">
        			<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
      			</span>
    		</div>
        </div>
        <div class="form-group col-lg-1">
            <label for="cdsSICE">CDS</label>
            <input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=$Reg['cdsSICE']?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="idcdsSICE">CDS</label>
            <?=form_dropdown('idcdsSICE', $estructuras_cds, '', 'class="form-control"');?>
            <!--<input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=$Reg['cdsSICE']?>">-->
        </div>
        <div class="form-group col-lg-1">
            <label>IUD</label>
            <input type="text" class="form-control col-lg-1" id="iudSICE" name="iudSICE" value="<?=$Reg['iudSICE']?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="idIniciador">Organismo | Area Iniciadora</label>
            <?=form_dropdown('idIniciador', array(), $Reg['idIniciador'], 'class="form-control"');?>
        </div>
        <div class="form-group col-lg-2">
            <label>Número</label>
            <input type="text" class="form-control col-lg-1" id="numeroSICE" name="numeroSICE" value="<?=$Reg['numeroSICE']?>">
        </div>
        <div class="form-group col-lg-1">
            <label>Período</label>
            <input type="text" class="form-control col-lg-1" id="periodoSICE" name="periodoSICE" value="<?=$Reg['periodoSICE']?>">
        </div>
        <div class="form-group col-lg-1">
            <label>Corresp.</label>
            <input type="text" class="form-control col-lg-1" id="correspondeSICE" name="correspondeSICE" value="<?=$Reg['correspondeSICE']?>">
        </div>
        <div class="form-group col-lg-12">
            <label for="caratulaActuacion">Carátula | Extracto</label>
            <textarea id="caratulaActuacion" name="caratulaActuacion" class="form-control" placeholder="Carátula" rows="5"><?=$Reg['caratulaActuacion']?></textarea>
        </div>
        <div class="form-group col-lg-12">
            <label for="observacionesActuacion">Observaciones</label>
            <textarea id="observacionesActuacion" name="observacionesActuacion" class="form-control" placeholder="Observaciones" rows="5"><?=$Reg['observacionesActuacion']?></textarea>
        
            <div class="panel panel-primary clearfix" style="margin-top:1em;">
                <div class="panel-heading">Remitente<?=($Reg['idActuacion'] > 0)? '<a href="#" class="remove"><span class="glyphicon glyphicon-remove pull-right"></span></a>':''?></div>
                <div class="panel-body panel-collapse">
                

        <div class="form-group col-lg-4">
            <label for="foliosActuacion">Folios con los que se recibe</label>
            <input type="text" id="foliosActuacion" name="foliosActuacion" class="form-control"  style="width:50px;" placeholder="N°" value="<?=$Reg['foliosActuacion']?>">
        </div>
        <div class="col-lg-11 col-lg-offset-11">
        </div>
        <div class="form-group col-lg-1">
            <label for="cdsRemitenteActuacion">CDS</label>
            <input type="text" class="form-control col-lg-1" id="cdsRemitenteActuacion" name="cdsRemitenteActuacion" value="<?=$Reg['cdsRemitenteActuacion']?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="idcdsRemitenteActuacion">CDS</label>
            <?=form_dropdown('idcdsRemitenteActuacion', $estructuras_cds, '', 'class="form-control"');?>
            <!--<input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=$Reg['cdsSICE']?>">-->
        </div>
    	<div class="form-group col-lg-1">
            <label>IUD</label>
            <input type="text" class="form-control col-lg-1" id="iudRemitenteActuacion" name="iudRemitenteActuacion" value="<?=$Reg['iudRemitenteActuacion']?>" readonly>
        </div>
        <div class="form-group col-lg-5">
            <label for="idRemitenteActuacion">Organismo | Area Remitente</label>
            <?=form_dropdown('idRemitenteActuacion', $estructuras_rem, $Reg['idRemitenteActuacion'], 'class="form-control"');?>
        </div>
	
		</div>
            </div>

        <div class="col-lg-12 botones">
            
            <?php if($Reg['idActuacion'] > 0) { ?>
                <button class="btn btn-danger remove pull-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
            <?php } 
            else { ?>
                <a ic-post-to="actuaciones/consulta" ic-target="#main_content" href="#" class="btn btn-danger btn-accion"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</a>
            <?php } ?>
            <button id="btnGuardar" class="btn btn-primary btn-accion pull-right"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        </div>
		<input type="hidden" id="idActuacion" name="idActuacion" value="">
		<input type="hidden" id="tipoActuacion" name="tipoActuacion" value="2"/>
        <input type="hidden" id="iudEstructura" name="iudEstructura" value="<?=$this->autenticacion->iudMesaEstructura()?>">
        <input type="hidden" id="idEstructura" name="idEstructura" value="<?=$this->autenticacion->idMesaEstructura()?>">
		<input type="hidden" id="vcForm" name="vcForm" value="<?= $vcFormName; ?>" />
    </form>

<script type="text/javascript">
	/*$('#btnGuardar').on('click', function(event) {
        var data = $('#formu').serialize();
        $('#formu').viaAjax('send', {'url': 'administrator/actuaciones/guardar', 'vars':data});
        event.preventDefault();
    });*/

    /*var actuacion = function() {
        var data = $('#formu').serialize();
        $('#formu').viaAjax('send', {'url': 'administrator/actuaciones/guardar', 'vars':data});
        event.preventDefault(); 
    }*/
    $('#idcdsSICE').on('change', function(){
        $.ajax({
            url: 'administrador/actuaciones/dependienteCDS',
            data: 'cdsEstructura='+$(this).val(),
            dataType: 'json',
            type: 'post',
            success: function(data) {
                $('#idIniciador').html(data);
            },
        });
    });
    $('#idcdsRemitenteActuacion').on('change', function(){
        $.ajax({
            url: 'administrador/actuaciones/dependienteCDS',
            data: 'cdsEstructura='+$(this).val(),
            dataType: 'json',
            type: 'post',
            success: function(data) {
                $('#idRemitenteActuacion').html(data);
            },
        });
    });
    
	$('#idIniciador').on('change', function() {
		$('#idRemitenteActuacion').val($(this).val());
	});
	$('#fechaDesde').datetimepicker({
		pickTime: false
	});
	$('#iudSICE').on('change', function() {
        $.ajax({
            url:    'administrador/actuaciones/buscarMesa',
            type:   'post',
            data:   'iud='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                if(data) {
                    $('#idIniciador').val($.trim(data.idEstructura));
                    $('#iudSICE').val($.trim(data.iudEstructura));
                    $('#cdsSICE').val($.trim(data.cdsEstructura));
                }
                else {
                    alert('El numero de mesa no existe.\nVerifique a comuniquese con el Area de Tecnologias Informatica')
                    $('#idIniciador').val('');
                    $('#iudSICE').val('');
                    $('#cdsSICE').val('');
                    $('#iudSICE').focus();
                }
            }
        })
    });
    $('#idIniciador').on('change', function() {
        $.ajax({
            url:    'administrador/actuaciones/buscarMesaId',
            type:   'post',
            data:   'id='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                if(data) {
                    $('#idIniciador').val($.trim(data.idEstructura));
                    $('#iudSICE').val($.trim(data.iudEstructura));
                    $('#cdsSICE').val($.trim(data.cdsEstructura));
                }
                else {
                    alert('El numero de mesa no existe.\nVerifique a comuniquese con el Area de Tecnologias Informatica')
                    $('#idIniciador').val('');
                    $('#iudSICE').val('');
                    $('#cdsSICE').val('');
                    $('#iudSICE').focus();
                }
            }
        })
    });
</script>
