
<div class="panel panel-default">
<div class="panel-heading">Listado de Eventos</div>
	<div id="panel-body" class="panel-body">
		<?=$vcMsjSrv;?>
		<div class="row">
			<a href="#" class="btn btn-primary pull-right" ic-trigger-on="click" ic-verb="POST" ic-src="capacitacion/archivos/<?=$nodo['idCursoMaterial']?>" ic-target="#main_content"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Cargar archivo</a>&nbsp;
			<?php //if($nodo['idCursoMaterial'] == 1) { ?>
				<!--<a href="#" class="btn btn-primary pull-right" ic-trigger-on="click" ic-verb="POST" ic-src="capacitacion/formulario" ic-target="#main_content"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Crear curso</a>-->
			<?php //} 
			//else { ?>
				<a href="#" class="btn btn-primary pull-right" ic-trigger-on="click" ic-verb="POST" ic-src="capacitacion/carpeta/<?=$nodo['idCursoMaterial']?>" ic-target="#main_content"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;Crear modulo</a>
			<?php //} ?>
		</div>
		
		<?= $vcGridView; ?>
	</div>
</div>
