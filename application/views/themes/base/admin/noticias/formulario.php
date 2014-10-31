<style type="text/css">
    #myId {
        width: 100%;
        min-height: 150px;
        background: #d2d2d2;
    }
</style>
<div class="panel panel-default">
	<div class="panel-heading">Agregar Noticia</div>
	<div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="<?=$formAction?>" ic-target="#main_content">
			<div class="form-group col-lg-12">
            	<label for="tituloNoticia">Titulo</label>
            	<input type="text" class="form-control" id="tituloNoticia" name="tituloNoticia" tabindex="1" placeholder="Titulo de Noticia" value="<?=$Reg['tituloNoticia']?>" autofocus>
        	</div>
            <div class="form-group col-lg-12">
                <label for="epigrafeNoticia">Epígrafe</label>
                <input type="text" class="form-control" id="epigrafeNoticia" name="epigrafeNoticia" tabindex="2" placeholder="Epígrafe de Noticia" value="<?=$Reg['epigrafeNoticia']?>">
            </div>
            <div class="form-group col-lg-12">
                <label for="descripcionNoticia">Descripción</label>
                <?php
                    $config_mini = array();  
                    $config_mini['toolbar'] = array(
                        array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'),
                        array('Bold', 'Italic', 'Underline', 'Strike' ,'-', 'Link', 'Unlink'),
                        array('Table', 'HorizontalRule', 'SpecialChar'),
                    );
                    echo $this->ckeditor->editor("descripcionNoticia", htmlspecialchars_decode($Reg['descripcionNoticia']), $config_mini);
                ?>
            </div>
        	<div class="form-group col-lg-2">
            	<label for="fechaDesdeNoticia">Fecha de Publicación</label>
            	<input type="text" class="form-control fecha" id="fechaDesdeNoticia" name="fechaDesdeNoticia" tabindex="4" placeholder="dd/mm/yyyy" value="<?=$Reg['fechaDesdeNoticia']?>">
        	</div>
            <div class="col-lg-12" id="myId">
                <link href="../assets/themes/base/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
                <script src="../assets/themes/base/dropzone/dropzone.js"></script>
            </div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="noticias/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button id="btn-guardar" type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;&nbsp;Guardar</button>
        	</div>
            <div class="botones col-lg-12">
            
            </div>
            <input type="hidden" id="idNoticia" name="idNoticia" value="<?=$Reg['idNoticia']?>">
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
        </div>
	</div>
</div>
<script type="text/javascript">
    //
    $('#btn-guardar').on('click', function() {
        var cadena = $('#cke_descripcionNoticia iframe').contents().find('body').html();
        $('#descripcionNoticia').val(cadena);
    });
    $("div#myId").dropzone({ 
        paramName: 'userfile[]',
        url: "noticias/upload",
        'success': function(file, response) {
            var input = JSON.parse(response);

            alert(input[0]['file_path']);
        }
    });
    $('.fecha').datetimepicker({
        pickTime: false
    });
</script>