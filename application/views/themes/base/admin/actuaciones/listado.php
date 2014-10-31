<?php
/**
 * @package Actuaciones
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<hr>
<div class="panel panel-default">
	<div class="panel-heading">Se encontraron <?=$resultado?> resultados en total</div>
		<div class="panel-body panel-collapse">
			
			<?= $vcGridView; ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('a.btn-accion').on('click', function(event) {
			//alert('hello');
			//$(this).viaAjax('send', {'url': 'administrator/actuaciones/guardar'});
			//$(this).viaAjax('send', {'url': $(this).attr('href')});
			event.preventDefault();
   			//$('.btn-accion').viaAjax();
		});
	});
</script>