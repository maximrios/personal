<?php
	$vcFormName = antibotHacerLlave();
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
	$vcFrmAction = (!empty($vcFrmAction))? $vcFrmAction: '';
    $registro = ((int) $Reg['idActuacion'] != 0)? true:false;
    $interno = ($this->autenticacion->idMesaEstructura() == 30)? false:true;
?>
<div class="panel panel-default clearfix">
    <div class="panel-heading">Formulario Alta de Actuación<?=($Reg['idActuacion'] > 0)? '<a href="#" class="remove"><span class="glyphicon glyphicon-remove pull-right"></span></a>':''?></div>
    <div class="panel-body panel-collapse">
        <?= $vcMsjSrv; ?>
	    <form id="<?=$vcFormName;?>" name="<?=$vcFormName;?>" action="<?=$vcFrmAction;?>" method="post" target="contenido-abm" enctype="multipart/form-data">
        <?php if($Reg['idActuacion']) { ?>
            <div class="form-group col-lg-12">
                <label for="numeroActuacion">N° interno de Actuación</label>
                <input type="text" id="numeroActuacion" name="numeroActuacion" class="form-control" value="<?=$Reg['codigoActuacion']?>" autofocus>
            </div>
        <?php } 
        else { 
            $check = ($this->autenticacion->idMesaEstructura() == 30)? 'checked':'';
            $check = ($this->input->post('tipoActuacion') == 2 || $tipo == 2)? 'checked':'';
            if ($this->input->post('tipoActuacion') == 2 || $tipo == 2) {
                $check = 'checked';
                $read = '';
            }
            else {
                $check = '';
                $read = 'readonly';
            }

            $read = ($this->autenticacion->idMesaEstructura() == 30)? '':'readonly';
            $val = ($this->autenticacion->idMesaEstructura() == 30)? 1:0;
            ?>
            <div class="form-group col-lg-12">
                <label for="my-checkbox">Actuación</label><br>
                <input type="checkbox" class="form-control" id="tipoActuacionSel" value="<?=$val?>" name="tipoActuacionSel" <?=$check.' '.$read?>>
            </div>
        <?php } ?>
        </form>
        <div id="testing">
            <?=$content?>
        </div>


<script type="text/javascript">
    
    $(document).on('ready', function() {
        $('#btnGuardar').on('click', function(event) {
            var data = $('#formu').serialize();
            $('#formu').viaAjax('send', {'url': 'administrador/actuaciones/guardar', 'vars':data});
            event.preventDefault();
        });
    });
    
    /*if (<?=$this->autenticacion->idMesaEstructura()?> != 30) {
        $('input[name="tipoActuacion"]').removeAttr('checked');
        $('input[name="tipoActuacion"]').attr('readonly', 'readonly');
        $('input[name="tipoActuacion"]').val(0);

        $('#idIniciador').val($('#idEstructura').val());
        $('#idIniciador').attr('disabled', true);


        $('#iudSICE').val($('#iudEstructura').val());
        $('#iudSICE').attr('readonly', 'readonly');

        $('#cdsSICE').attr('readonly', 'readonly');
        $('#numeroSICE').attr('readonly', 'readonly');
        $('#periodoSICE').attr('readonly', 'readonly');
        $('#correspondeSICE').attr('readonly', 'readonly');

        $('#idRemitenteActuacion').val($('#idEstructura').val());
        $('#idRemitenteActuacion').attr('disabled', true);
        $('#iudRemitenteActuacion').val($('#iudEstructura').val());
        $('#iudRemitenteActuacion').attr('readonly', 'readonly');
            
    }*/
    $('input[name="tipoActuacionSel"]').bootstrapSwitch({
        onText: 'Ext',
        offText: 'Int',
    });
    $('input[name="tipoActuacionSel"]').on('switchChange.bootstrapSwitch', function(event, state) {
        if(state.value == true) {
            $('#testing').load('actuaciones/externa');
        }
        else {
            $('#testing').load('actuaciones/interna');
        }
        /*cambiarEstructura(state.value);
        if(state.value == true) {
            $(this).val(1);
            $('#idIniciador').val(0);
            $('#idIniciador').removeAttr('disabled');
            $('#iudSICE').val('');
            $('#iudSICE').removeAttr('readonly');

            $('#cdsSICE').removeAttr('readonly');
            $('#numeroSICE').removeAttr('readonly');
            $('#periodoSICE').removeAttr('readonly');
            $('#correspondeSICE').removeAttr('readonly');

            $('#idRemitenteActuacion').val(0);
            $('#idRemitenteActuacion').removeAttr('disabled');
            $('#iudRemitenteActuacion').val('');
            $('#iudRemitenteActuacion').removeAttr('readonly');
            
            $('#fechaCreacionActuacion').val('');
            $('#fechaCreacionActuacion').attr('readonly', false);
        }
        else {
            $(this).val(0);
            $('#idIniciador').val($('#idEstructura').val());
            //$('#idIniciador').attr('disabled', true);
            $('#iudSICE').val($('#iudEstructura').val());
            $('#iudSICE').attr('readonly', 'readonly');

            $('#cdsSICE').attr('readonly', 'readonly');
            $('#numeroSICE').attr('readonly', 'readonly');
            $('#periodoSICE').attr('readonly', 'readonly');
            $('#correspondeSICE').attr('readonly', 'readonly');

            $('#idRemitenteActuacion').val($('#idEstructura').val());
            $('#idRemitenteActuacion').attr('disabled', true);
            $('#iudRemitenteActuacion').val($('#iudEstructura').val());
            $('#iudRemitenteActuacion').attr('readonly', 'readonly');
            
            var fullDate = new Date();
            var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
            var currentDate = fullDate.getDate() + "/" + twoDigitMonth + "/" + fullDate.getFullYear();
            $('#fechaCreacionActuacion').val(currentDate);
            $('#fechaCreacionActuacion').attr('readonly', 'readonly');
        }*/
        
    });
    $('#iudSICE').on('change', function() {
        $.ajax({
            url:    'administrator/actuaciones/buscarMesa',
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
            url:    'administrator/actuaciones/buscarMesaId',
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
    $('#iudRemitenteActuacion').on('change', function() {
        $.ajax({
            url:    'administrator/actuaciones/buscarMesa',
            type:   'post',
            data:   'iud='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                if(data) {
                    $('#idRemitenteActuacion').val($.trim(data.idEstructura));
                    $('#iudRemitenteActuacion').val($.trim(data.iudEstructura));
                }
                else {
                    alert('El numero de mesa no existe.\nVerifique a comuniquese con el Area de Tecnologias Informatica')
                    $('#idRemitenteActuacion').val('');
                    $('#iudRemitenteActuacion').val('');
                    $('#iudRemitenteActuacion').focus();
                }
            }
        })
    });
    $('#idRemitenteActuacion').on('change', function() {
        $.ajax({
            url:    'administrator/actuaciones/buscarMesaId',
            type:   'post',
            data:   'id='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                if(data) {
                    $('#idRemitenteActuacion').val($.trim(data.idEstructura));
                    $('#iudRemitenteActuacion').val($.trim(data.iudEstructura));
                }
                else {
                    alert('El numero de mesa no existe.\nVerifique a comuniquese con el Area de Tecnologias Informatica')
                    $('#idRemitenteActuacion').val('');
                    $('#iudRemitenteActuacion').val('');
                    $('#iudRemitenteActuacion').focus();
                }
            }
        })
    });
    var cambiarEstructura = function(value) {
        $.ajax({
            url:    'administrator/actuaciones/estructuras',
            type:   'post',
            data:   'tipo='+value,
            dataType: 'json',
            success: function(data) {
                $('#idIniciador').html(data);
                $('#idIniciador').val(<?=$this->autenticacion->idMesaEstructura()?>);
            }
        })
    }
    var cambiarTipos = function() {
        $.ajax({
            url:    'administrator/actuaciones/tipos',
            type:   'post',
            data:   'tipo='+value,
            dataType: 'json',
            success: function(data) {
                $('#idIniciador').html(data);
                //$('#idIniciador').val(<?=$this->autenticacion->idMesaEstructura()?>);
            }
        })    
    }
    $('.remove').on('click', function(event){
        event.preventDefault();
        $('#accion').empty();
    });
</script>