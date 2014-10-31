<style type="text/css">
    #myId {
        min-height: 300px;
    }
    #imagenesGaleria figure {
        border: 1px solid #CCCCCC;
        display: inline-block;
        padding: 0.5em;
        max-width: 175px;
        text-align: center;
    }
    #imagenesGaleria figure img {
        max-width: 100%;
    }
    #imagenesGaleria figure hr {
        margin: 1em auto;
    }
    #imagenesGaleria figure figcaption {
        margin: 0.3em auto;
        text-align: center;
        padding-left: 0;
    }
    .fancybox-overlay {
        z-index: 99999!important;
    }
</style>
<?php if($imagenes) { ?>
<link href="../assets/themes/base/fancybox/jquery.fancybox.css" type="text/css" rel="stylesheet" />
<script src="../assets/themes/base/fancybox/jquery.fancybox.js"></script>
<script type="text/javascript">
    $(".fancybox").fancybox();
</script>
<div class="panel panel-default">
    <div class="panel-heading">Imagenes asociadas a la galería <?=$galeria['nombreGaleria']?></div>
    <div class="panel-body" id="imagenesGaleria">
        <?= $vcMsjSrv; ?>
        <?php foreach ($imagenes as $imagen) { ?>
            <figure>
                <img src=".<?=$imagen['thumbGaleriaMedia']?>">
                <hr>
                <figcaption class="row">
                    <!--<a href=""><span class="glyphicon glyphicon-pencil"></span></a>-->
                    <a href=".<?=$imagen['pathGaleriaMedia']?>" class="fancybox"><span class="glyphicon glyphicon-zoom-in"></span></a>
                    <a href="#" ic-post-to="galerias/eliminarImagen/<?=$imagen['idGaleriaMedia']?>" ic-target="#main_content"><span class="glyphicon glyphicon-trash"></span></a>
                </figcaption>
            </figure>
        <?php } ?>
    </div>
</div>
<?php } ?>
<div class="panel panel-default">
    <div class="panel-heading">Agregar Imagenes a la galeria <?=$galeria['nombreGaleria']?></div>
    <div class="panel-body" id="myId">
        <?= $vcMsjSrv; ?>
        <link href="../assets/themes/base/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
		<script src="../assets/themes/base/dropzone/dropzone.js"></script>
        <input type="hidden" id="idGaleria" name="idGaleria" value="<?=$galeria['idGaleria']?>">    
    </div>
    <div class="botones col-lg-12">
        <button type="button" ic-post-to="galerias/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Volver</button>
    </div>
</div>
<!--<div class="panel panel-default">
    <div class="panel-heading">Embed Video</div>
    <div class="panel-body">
        <?= $vcMsjSrv; ?>
		<form ic-post-to="galerias/check_youtube" ic-target="#embed-video">
			<div class="form-group col-lg-12">
            	<label for="embedLink">Embed a video</label>
  				<input type="text" class="form-control" id="embedLink" name="embedLink" placeholder="http://www.youtube.com/watch?v=Zx4Hjq6KwO0">
        	</div>
        	<div class="botones col-lg-12">
        		<button type="button" ic-post-to="eventos/listado" ic-target="#main_content" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Cancelar</button>
        		<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-<?=$video_icon?>"></span>&nbsp;&nbsp;<?=$video_legend?></button>
        	</div>
        	<input type="hidden" id="vcForm" name="vcForm" value="asdasd">
		</form>
		<div id="embed-video">

		</div>
    </div>
</div>-->
<script type="text/javascript">
    $("div#myId").dropzone({ 
        paramName: 'userfile[]',
        url: "galerias/upload",
        'sending': function(file, xhr, formData) {
            formData.append("idGaleria", $('#idGaleria').val());
        }
    });
    //$(document).ready(function() {
        
    //});
	/*$("#myId").dropzone({ 
        paramName: 'userfile[]',
		url: "galerias/upload" ,
        method: 'post',
        'accept': function(file, done) {
            done("Imagen subida correctamente.");
        },
		'sending': function(file, xhr, formData) {
			formData.append("idGaleria", $('#idGaleria').val());
		}
	});*/
</script>