<style>
    .dz-size {
        display: none;
    }
</style>
<div class="panel panel-default">
	<div class="panel-heading">Subir archivo <a href="#" ic-post-to="noticias/listado" style="" ic-target="#main_content" class="pull-right"><span class="glyphicon glyphicon-circle-arrow-left"></span>&nbsp;&nbsp;Volver</a></div>
	<div class="panel-body">
        <div class="alert alert-info" role="alert">
            Arrastre el archivo que desea agregar hasta el espacio de lineas punteadas o haga clic en dicho espacio y seleccione el archivo a subir.<br>Las imágenes no deben superar 3 MB de tamaño máximo.
        </div>
        <?=$vcMsjSrv;?>
        <div class="row">
            <div class="input-group col-lg-9">
                <input type="text" class="form-control" id="nombreCursoMaterial" name="nombreCursoMaterial" placeholder="Nombre del archivo" value="">
                <span class="input-group-btn"><button class="btn btn-default btn-seleccionar" type="button" disabled>Seleccionar archivo</button></span>
            </div>
            <div class="col-lg-2 pull-right">
                <button class="btn btn-primary start pull-right">Subir archivo</button>    
            </div>
        </div>
        

        <!--<link href="../assets/themes/base/dropzone/css/dropzone.css" type="text/css" rel="stylesheet" />
        <script src="../assets/themes/base/dropzone/dropzone.js"></script>-->

        <input type="hidden" id="idCursoMaterial" name="idCursoMaterial" value="<?=$Reg['idCursoMaterial']?>">
        <input type="hidden" id="padreCursoMaterial" name="padreCursoMaterial" value="<?=$Reg['padreCursoMaterial']?>">
        <input type="hidden" id="status" name="status" value="">
        <input type="hidden" id="message" name="message" value="">

        <div id="template" class="table table-striped">
            
        </div>

        
        
        <!--<div id="template" class="row">
            <div>
                <span class="preview"><img data-dz-thumbnail /></span>
            </div>
            <div>
                <p class="name" data-dz-name></p>
                <strong class="error text-danger" data-dz-errormessage></strong>
            </div>
            <div>
                <p class="size" data-dz-size></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                    <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                </div>
            </div>
            <div>
                <button class="btn btn-primary start">
                    <span>Started</span>
                </button>
                <button data-dz-remove class="btn btn-warning cancel">
                    <span>Cancel</span>
                </button>
                <button data-dz-remove class="btn btn-danger delete">
                    <span>Delete</span>
                </button>
            </div>
        </div>-->
    </div>
</div>
<script type="text/javascript">
//    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone(document.body, { 
        //Dropzone.options.myDropzone = false;
        paramName: 'userfile[]',
        url: "capacitacion/upload",
        'sending': function(file, xhr, formData) {
            formData.append("idCursoMaterial", $('#idCursoMaterial').val());
            formData.append("nombreCursoMaterial", $('#nombreCursoMaterial').val());
            formData.append("padreCursoMaterial", $('#padreCursoMaterial').val());
        },
        clickable: '.btn-seleccionar',
        previewsContainer: '#template',
        /*previewTemplate: '<div id="listado" class="dz-preview dz-file-preview"><div class="dz-details"><div class="row"><div class="data-dz-filename col-lg-8"><label data-dz-name class="col-lg-6"></label></div><div class="dz-progress col-lg-4"><span class="dz-upload" data-dz-uploadprogress><div id="total-progress" class="progress"><div class="progress-bar progress-bar-striped active"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"><span>45% Complete</span></div></div></span></div></div><div class="row"><div class="input-group col-lg-12"><input type="text" class="form-control" id="nombreCursoMaterial" name="nombreCursoMaterial" placeholder="Nombre del archivo" value=""><span class="input-group-btn"><button class="btn btn-primary start" type="button">Subir archivo</button></span></div></div><div class="dz-size" style="display:none;" data-dz-size></div><img data-dz-thumbnail /></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',*/
        success: function(file, response){
            /*var obj = $.parseJSON(response);
            return true;*/
            //alert('termino');
        },
        /*error: function(file, response) {
            return false;
        },*/
        autoProcessQueue: false,
    });

    myDropzone.on("addedfile", function(file) {
        //file.previewElement.addEventListener("click", function() { myDropzone.removeFile(file); });
        // Hookup the start button
        $('.start').on('click', function() {
            myDropzone.processQueue(file); 
        });
    });
    myDropzone.on("totaluploadprogress", function(progress) {
        $("#total-progress .progress-bar").css('width', progress+'%');
        $("#total-progress .progress-bar span").html(progress+'% Cargado');
    });
    $('#nombreCursoMaterial').on('change', function() {
        $('.btn-seleccionar').attr('disabled', false);
    });
    /*$('#form_upload').on('beforeSend.ic', function() {
        myDropzone.processQueue();
    });*/

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