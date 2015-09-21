<?php
/**
 * @package Agentes
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<div class="row">
	<div class="col-lg-12">
		<form id="form-search-gridview" name="form-search-gridview" ic-post-to="formaciones/formulario/0/<?=$idAgente?>" ic-target="#main_content">
			<a href="#" ic-post-to="formaciones/formulario/0/<?=$idAgente?>" ic-target="#tabs-content" class="btn btn-primary pull-right">Agregar nueva formación</a>
		</form>		
	</div>
</div>
<?=$vcMsjSrv?>
<?=$vcGridView;?>