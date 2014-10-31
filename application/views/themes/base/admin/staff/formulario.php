<div class="panel panel-default">
	<div class="panel-heading">Agregar Persona a Staff</div>
	<div class="panel-body">
        <ul class="nav nav-pills nav-wizard">
            <li class="active"><a href="#" data-toggle="tab">1. Datos personales</a><div class="nav-arrow"></div></li>
            <li><div class="nav-wedge"></div><a href="#" data-toggle="tab" disabled>2. Imagen de perfil</a></li>
        </ul>
        <?=$mensajeServer?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-5">
            	<label for="nombrePersona">Nombre</label>
            	<input type="text" class="form-control" id="nombrePersona" name="nombrePersona" placeholder="Nombre/s completo/s" value="<?=$Reg['nombrePersona']?>">
        	</div>
            <div class="form-group col-lg-5">
                <label for="apellidoPersona">Apellido</label>
                <input type="text" class="form-control" id="apellidoPersona" name="apellidoPersona" placeholder="Apellido/s completo/s" value="<?=$Reg['apellidoPersona']?>">
            </div>
        	<div class="form-group col-lg-2">
            	<label for="nacimientoPersona">Fecha de Nacimiento</label>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" class="form-control fecha" id="nacimientoPersona" name="nacimientoPersona" placeholder="dd/mm/yyyy" value="<?=$Reg['nacimientoPersona']?>">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
        	</div>
        	<div class="form-group col-lg-8">
            	<label for="domicilioPersona">Domicilio</label>
                <input type="text" class="form-control" id="domicilioPersona" name="domicilioPersona" placeholder="Domicilio completo" value="<?=$Reg['domicilioPersona']?>">
        	</div>
        	<div class="form-group col-lg-2">
            	<label for="telefonoPersona">Teléfono fijo</label>
            	<input type="text" class="form-control" id="telefonoPersona" name="telefonoPersona" placeholder="Solo números. Ej.:3874212121" value="<?=$Reg['telefonoPersona']?>">
        	</div>
            <div class="form-group col-lg-2">
                <label for="celularPersona">Teléfono celular</label>
                <input type="text" class="form-control" id="celularPersona" name="celularPersona" placeholder="Solo números. Ej.:3874212121" value="<?=$Reg['celularPersona']?>">
            </div>
        	<div class="form-group col-lg-3">
            	<label for="emailPersona">Email</label>
            	<input type="email" class="form-control" id="emailPersona" name="emailPersona" placeholder="ejemplo@servidor.com" value="<?=$Reg['emailPersona']?>">
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="staff/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('.fecha').datetimepicker({
        pickTime: false
    });
</script>