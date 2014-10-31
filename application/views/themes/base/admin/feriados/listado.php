<?php
/**
 * @package Feriados
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
$vcGridView = (!empty($vcGridView))? $vcGridView: '';
$vcNombreList = (!empty($vcNombreList))? $vcNombreList: 'Agentes';
$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: '';
?>
<div class="row">
	<form id="form-search-gridview" name="form-search-gridview" ic-post-to="feriados/listado" ic-target="#main_content">
		<div class="input-group search-gridview pull-right">
	    	<input type="text" id="buscarGridview" name="buscarGridview" class="form-control" placeholder="Buscar..." value="<?=$txtvcBuscar?>" autofocus>
    		<span class="input-group-btn">
		    	<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
	    	</span>
		</div>
		<a href="#" ic-post-to="feriados/formulario" ic-target="#main_content" class="btn btn-primary pull-right">Agregar nuevo feriado</a>
	</form>	
</div>
<?=$vcMsjSrv?>
<?=$vcGridView;?>
<script type="text/javascript">
	$('.eliminar').on('beforeSend.ic', function(event){
		event.preventDefault();
		bootbox.confirm("Are you sure?", function(result) {
			//Example.show("Confirm result: "+result);
		}); 
		
    });
</script>