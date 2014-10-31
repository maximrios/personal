<div class="panel panel-default">
	<div class="panel-heading">Datos de contacto</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
            <div class="form-group col-lg-12">
                <label for="nombreCliente">Nombre</label>
                <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" tabindex="2" placeholder="Nombre de cliente" value="<?=$Reg['nombreCliente']?>" readonly>
            </div>
            <div class="form-group col-lg-12">
                <label for="domicilioCliente">Domicilio</label>
                <input type="text" class="form-control" id="domicilioCliente" name="domicilioCliente" tabindex="1" placeholder="Domicilio de contacto" value="<?=$Reg['domicilioCliente']?>" autofocus>
            </div>
            <div class="form-group col-lg-12">
                <label for="telefonoCliente">Teléfono 1</label>
                <input type="text" class="form-control" id="telefonoCliente" name="telefonoCliente" tabindex="2" placeholder="Teléfono de contacto" value="<?=$Reg['telefonoCliente']?>">
            </div>
            <div class="form-group col-lg-12">
                <label for="celularCliente">Teléfono 2</label>
                <input type="text" class="form-control" id="celularCliente" name="celularCliente" tabindex="3" placeholder="Teléfono de contacto" value="<?=$Reg['celularCliente']?>">
            </div>
            <div class="form-group col-lg-12">
                <label for="emailCliente">Email</label>
                <input type="text" class="form-control" id="emailCliente" name="emailCliente" tabindex="4" placeholder="Email de contacto" value="<?=$Reg['emailCliente']?>">
            </div>
        	<div class="botones col-lg-12">
        		<button id="btn-guardar" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <input type="hidden" id="idCliente" name="idCliente" value="<?=$Reg['idCliente']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/intercooler.min.js"></script>