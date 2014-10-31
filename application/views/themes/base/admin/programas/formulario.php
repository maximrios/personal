<div class="panel panel-default">
	<div class="panel-heading">Agregar Programa</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-12">
            	<label for="nombrePrograma">Nombre</label>
            	<input type="text" class="form-control" id="nombrePrograma" name="nombrePrograma" tabindex="1" placeholder="Nombre del programa" value="<?=$Reg['nombrePrograma']?>" autofocus>
        	</div>
            <div class="form-group col-lg-12">
                <label for="descripcionPrograma">Descripción</label>
                <?php
                    $config_mini = array();  
                    $config_mini['toolbar'] = array(
                        array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                        array('Bold', 'Italic', 'Underline', 'Strike' ,'-', 'Link', 'Unlink'),
                        array('Table', 'HorizontalRule', 'SpecialChar'),
                    );
                    echo $this->ckeditor->editor("descripcionPrograma", htmlspecialchars_decode($Reg['descripcionPrograma']), $config_mini);
                ?>
                
            </div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="programas/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button id="btn-guardar" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <div class="botones col-lg-12">
            
            </div>
            <input type="hidden" id="idPrograma" name="idPrograma" value="<?=$Reg['idPrograma']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
	</div>
</div>
<script type="text/javascript">
    $('#btn-guardar').on('click', function() {
        var cadena = $('#cke_descripcionPrograma iframe').contents().find('body').html();
        $('#descripcionPrograma').val(cadena);
    });
</script>