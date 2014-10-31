<div class="panel panel-default">
	<div class="panel-heading">Información de Actuación<a data-toggle="collapse" href="#prueba"></a></div>
		<div class="panel-body panel-collapse">
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

<div class="btn-group buttons">
	<a href="#" ic-post-to="actuaciones/consulta" class="btn btn-danger btn-accion" ic-target="#main_content"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Volver a la búsqueda de actuaciones</a>
</div>
<div class="btn-group buttons">
  	<a href="administrator/actuaciones/formulario/<?=$actuacion['idActuacion']?>" rel="{'idActuacion': <?=$actuacion['idActuacion']?>}" class="btn btn-primary btn-accion" target="accion" <?=($available)? '':'disabled'?>><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Modificar actuación</a>
  	<a href="actuaciones/historial/<?=$actuacion['idActuacion']?>" class="btn btn-success" target="_blank"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Imprimir informe completo</a>
  	<a href="#" ic-post-to="<?=base_url("administrador/pases/listado/".$actuacion['idActuacion'])?>" ic-target="#historial" class="btn btn-info btn-accion"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;Ver historial de pases</a>
</div>
<div id="historial" class="clearfix">
</div>