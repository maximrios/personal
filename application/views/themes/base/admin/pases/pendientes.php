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
	<div class="panel-heading">Bandeja de Entrada</div>
		<div class="panel-body panel-collapse">
			<?= $vcGridView; ?>
		</div>
	</div>
</div>