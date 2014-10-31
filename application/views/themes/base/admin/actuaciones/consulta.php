<?php
    $vcFormName = antibotHacerLlave();
?>
<a href="#" ic-post-to="actuaciones/formulario" id="btn-nuevo" style="margin-bottom:1em;" class="btn btn-primary btn-accion" ic-target="#main_content"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Alta de Actuación</a>
<!--<a href="actuaciones/inscripcion" target="_blank" class="btn btn-primary">Reporte inscripcion</a>-->
<div class="panel panel-default">
	<div class="panel-heading">Búsqueda de actuaciones</div>
		<div class="panel-body panel-collapse">
			<?= $vcMsjSrv; ?>
 			<div>
 				<form id="formu" name="<?=$vcFormName?>" ic-post-to="<?=$vcFrmAction?>" ic-target="#listado">
 					<div class="form-group col-lg-2">
            			<label>CDS <span class="aclaracion">(SICE | SGA)</span></label>
            			<input type="text" class="form-control col-lg-1" id="cdsSICE" name="cdsSICE" value="<?=$Reg['cdsSICE']?>">
                    </div>
 					<div class="form-group col-lg-2">
            			<label>IUD <span class="aclaracion">(SICE | SGA)</span></label>
            			<input type="text" class="form-control col-lg-1" id="iudSICE" name="iudSICE" value="">
        			</div>
        			<div class="form-group col-lg-2">
            			<label>Número <span class="aclaracion">(SICE | SGA)</span></label>
            			<input type="text" class="form-control col-lg-1" id="numeroSICE" name="numeroSICE" value="">
        			</div>
        			<div class="form-group col-lg-1">
            			<label>Período</label>
            			<input type="text" class="form-control col-lg-1" id="periodoSICE" name="periodoSICE" value="" minlength="4" maxlength="4">
        			</div>
        			<div class="form-group col-lg-1">
            			<label>Corresp.</label>
            			<input type="text" class="form-control col-lg-1" id="correspondeSICE" name="correspondeSICE" value="">
        			</div>
        			<div class="form-group col-lg-2">
            			<label>Fecha Desde</label>
            			<div class="input-group date" id="fechaDesde">
            				<input type="text" class="form-control col-lg-1" id="fechaDesde" name="fechaDesde" placeholder="dd/mm/yyyy">
      						<span class="input-group-btn">
        						<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
      						</span>
    					</div>
        			</div>
        			<div class="form-group col-lg-2">
            			<label>Fecha Hasta</label>
            			<div class="input-group date" id="fechaHasta">
            				<input type="text" class="form-control col-lg-1" id="fechaHasta" name="fechaHasta" placeholder="dd/mm/yyyy">
      						<span class="input-group-btn">
        						<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
      						</span>
    					</div>
        			</div>
        			<div class="form-group col-lg-4">
            			<label>Tipo de Actuación</label>
                        <?=form_dropdown('idActuacionTipo', $tipos, '', 'class="form-control col-lg-4"');?>
                    </div>
        			<div class="form-group col-lg-5">
            			<label>Criterio</label>
            			<input type="text" class="form-control col-lg-1" id="caratulaActuacion" name="caratulaActuacion" value="<?=$Reg['caratulaActuacion']?>" placeholder="Ingrese un criterio de busqueda">
        			</div>
        			<div class="col-lg-12 botones">
                        <a href="administrator/actuaciones" id="btnCancelar" class="btn btn-danger pull-right hidden"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar búsqueda</a>
        				<button type="submit" id="btnBuscar" class="btn btn-primary pull-right btn-accion"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Buscar</button>
        			</div>
                    <input type="hidden" id="vcForm" name="vcForm" value="<?=$vcFormName?>">
 				</form>
 			</div>
       	</div>
	</div>
</div>
<div id="listado"></div>
<script type="text/javascript">
	$('#fechaDesde').datetimepicker({
		pickTime: false
	});
    $('#fechaHasta').datetimepicker({
    	pickTime: false
    });
    $("#fechaDesde").on("dp.change",function (e) {
        $('#fechaHasta').data("DateTimePicker").setMinDate(e.date);
    });
    $("#fechaHasta").on("dp.change",function (e) {
		$('#fechaDesde').data("DateTimePicker").setMaxDate(e.date);
    });
</script>