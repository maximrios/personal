<div class="panel panel-default">
	<div class="panel-heading">Agregar Suscriptor</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-12">
            	<label for="nombreContacto">Nombre</label>
            	<input type="text" class="form-control" id="nombreContacto" name="nombreContacto" tabindex="1" placeholder="Nombre de contacto" value="<?=$Reg['nombreContacto']?>" readonly>
        	</div>
            <div class="form-group col-lg-12">
                <label for="emailContacto">Email</label>
                <input type="text" class="form-control" id="emailContacto" name="emailContacto" tabindex="2" placeholder="Email de contacto" value="<?=$Reg['emailContacto']?>" readonly>
            </div>
            <div class="form-group col-lg-12">
                <label for="telefonoContacto">Teléfono</label>
                <input type="text" class="form-control" id="telefonoContacto" name="telefonoContacto" tabindex="2" placeholder="Teléfono de contacto" value="<?=$Reg['telefonoContacto']?>" readonly>
            </div>
            <div class="form-group col-lg-12">
                <label for="mensajeContacto">Mensaje</label>
                <textarea class="form-control" id="mensajeContacto" name="mensajeContacto" placeholder="Noticia completa." readonly><?=$Reg['mensajeContacto']?></textarea>
            </div>
        	<div class="form-group col-lg-3">
            	<label for="fechaContacto">Fecha de contacto</label>
            	<input type="text" class="form-control fecha" id="fechaContacto" name="fechaContacto" placeholder="dd/mm/yyyy" value="<?=$Reg['fechaContacto']?>" readonly>
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="contactos/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Volver</button>
        	</div>
            <input type="hidden" id="idContacto" name="idContacto" value="<?=$Reg['idContacto']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('.fecha').datetimepicker({
        pickTime: false
    });
</script>