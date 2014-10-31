<div class="panel panel-default">
    <div class="panel-heading">Editar titulo de galeria</div>
    <div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-12">
            	<label for="nombreGaleria">Titulo de Galeria</label>
            	<input type="text" class="form-control" id="nombreGaleria" name="nombreGaleria" placeholder="Nombre completo de la galeria" value="<?=$Reg['nombreGaleria']?>">
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="galerias/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <input type="hidden" id="idGaleria" name="idGaleria" value="<?=$Reg['idGaleria']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
    </div>
</div>