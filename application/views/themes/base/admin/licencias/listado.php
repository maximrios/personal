<?php
/**
 * @package Licencias
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
  			<div class="panel-heading">Resumen</div>
  			<div class="panel-body">
  				<div class="col-lg-6">
    				<div class="panel panel-default">
	  					<div class="panel-heading">Remanentes</div>
  						<div class="panel-body">
  							<ul class="listado-licencias">
	  							<?php foreach ($licencias as $licencia) { ?>
	  							<li><span><?=$licencia['nombreLicencia']?></span></li>
	  							<?php } ?>
	  						</ul>
  						</div>
  					</div>
  				</div>
  				<div class="col-lg-6">
  					<div class="panel panel-default">
	  					<div class="panel-heading">Usufructuados</div>
  						<div class="panel-body">
	  						<ul class="listado-licencias">
	  							<?php foreach ($licencias as $licencia) { ?>
	  							<li><span><?=$licencia['nombreLicencia']?></span></li>
	  							<?php } ?>
	  						</ul>
  						</div>
  					</div>
  				</div>
  			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<form id="form-search-gridview" name="form-search-gridview" ic-post-to="licencias/listado" ic-target="#main_content">
			<div class="input-group search-gridview pull-right">
	    		<input type="text" id="buscarGridview" name="buscarGridview" class="form-control" placeholder="Buscar..." value="<?=$txtvcBuscar?>" autofocus>
    			<span class="input-group-btn">
			    	<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
	    		</span>
			</div>
			<a href="#" ic-post-to="licencias/formulario" ic-target="#main_content" class="btn btn-primary pull-right">Agregar nueva licencia</a>
		</form>	
		
	</div>
</div>
<?=$vcMsjSrv?>
		<?=$vcGridView;?>
