<style type="text/css">
    #myId {
        background: #f9f9f9;
        border: 3px dashed #d0d0d0;
        color: #d2d2d2;
        min-height: 100px;
        
    }
</style>
<div class="panel panel-default">
	<div class="panel-heading">Subir archivo <a href="#" ic-post-to="noticias/listado" style="" ic-target="#main_content" class="pull-right"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;&nbsp;Volver</a></div>
	<div class="panel-body">
        <div class="alert alert-info" role="alert">
            Arrastre el archivo que desea agregar hasta el espacio de lineas punteadas o haga clic en dicho espacio y seleccione el archivo a subir.<br>Las imágenes no deben superar 3 MB de tamaño máximo.
        </div>
        <?=$vcMsjSrv;?>
        <form id="form_upload" ic-post-to="<?=$formAction?>" ic-target="#main_content">
        <!--<form action="<?=$formAction?>" method="post" target="#main_content">-->
        <div class="row">
            <div class="form-group">
                <label for="nombreCursoMaterial">Nombre del archivo</label>
                <input type="text" class="form-control" id="nombreCursoMaterial" name="nombreCursoMaterial" placeholder="Nombre del archivo" value="<?=$Reg['nombreCursoMaterial']?>">
            </div>
        </div>
        <div class="col-lg-12" id="myId">
            <link href="../assets/themes/base/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
            <script src="../assets/themes/base/dropzone/dropzone.js"></script>
        </div>
        <div class="form-group">
            <button id="btn_upload" class="btn btn-primary">Subir archivo</button>
        </div>
        <input type="hidden" id="idCursoMaterial" name="idCursoMaterial" value="<?=$Reg['idCursoMaterial']?>">
        <input type="hidden" id="padreCursoMaterial" name="padreCursoMaterial" value="<?=$Reg['padreCursoMaterial']?>">
        <input type="hidden" id="status" name="status" value="">
        <input type="hidden" id="message" name="message" value="">
        </form>
	</div>
</div>
<script type="text/javascript">
    var myDropzone = new Dropzone("div#myId", { 
        paramName: 'userfile[]',
        url: "capacitacion/upload",
        'sending': function(file, xhr, formData) {
            formData.append("idCursoMaterial", $('#idCursoMaterial').val());
            formData.append("nombreCursoMaterial", $('#nombreCursoMaterial').val());
            formData.append("padreCursoMaterial", $('#padreCursoMaterial').val());
        },
        /*success: function(file, response){
            var obj = $.parseJSON(response);
            return true;
        },
        error: function(file, response) {
            return false;
        },*/
        autoProcessQueue: false,
    });
    $('#form_upload').on('beforeSend.ic', function() {
        myDropzone.processQueue();
    });

    /*$("div#myId").dropzone({ 
        paramName: 'userfile[]',
        url: "capacitacion/upload",
        'sending': function(file, xhr, formData) {
            formData.append("idCursoMaterial", $('#idCursoMaterial').val());
            formData.append("nombreCursoMaterial", $('#nombreCursoMaterial').val());
        },
        'success': function() {
            var input = $('#padreCursoMaterial').val();
            $('#main_content').load('capacitacion/listado/'+input);
        }
    });*/
</script>