<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Panel de Administracion</title>
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/nav-wizard.bootstrap.css">
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>dropzone/css/dropzone.css">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/bootstrap-switch.css">
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/hits.css">
    <link rel="stylesheet" href="<?=config_item('ext_theme_folder')?>css/personal.css">
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/jquery.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/moment.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/bootstrap-switch.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/hits.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/intercooler.min.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/bootstrap-datetimepicker.es.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>dropzone/dropzone.js"></script>
    <script type="text/javascript" src="<?=config_item('ext_theme_folder')?>js/bootbox.js"></script>
    
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-vertical">
                    <span class="sr-only">Navegacion</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?=$PanelInfo['titulo'];?></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href=""><span class="glyphicon glyphicon-bell"></span></a></li>
                <!--<li class="navbar-imagen"><a href="#" class=""><img src="../assets/images/agentes/<?=$this->autenticacion->dniPersona()?>.jpg"></a></li>-->
                <li class="dropdown">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$this->autenticacion->apellidoPersona().', '.$this->autenticacion->nombrePersona();?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?=site_url('administrador/auth/logout')?>"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;Cerrar Sesi&oacute;n</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <header>
    </header>
    <div id="wrapper" class="active">
        <div id="sidebar-wrapper" class="sidebar-holder">
            <div class="sidebar-imagen-perfil">
                <div class="imagen-perfil">
                    <?php if(file_exists('assets/images/agentes/'.$this->autenticacion->dniPersona().'.jpg')) { ?>
                        <img src="<?=base_url('assets/images/agentes/'.$this->autenticacion->dniPersona().'.jpg');?>" alt="">
                    <?php } 
                    else { ?>
                        <img src="<?=base_url('assets/images/agentes/noimage.jpg');?>" alt="">
                    <?php } ?>
                </div>
            </div>
            <ul class="sidebar-nav" id="sidebar"> 
                <?=$menu?>    
            </ul>
            <ul class="sidebar-nav" id="sidebar-logout">
                <li class="sidebar-brand"><a href="<?=site_url('administrador/auth/logout')?>">Cerrar Sesi&oacute;n<span id="main_icon" class="glyphicon glyphicon-off"></span></a></li>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <div class="page-content inset">
                <br>
                <div class="row">
                    <div id="main_content" class="col-md-12" style="padding-top:5px;">
                        <?=$main_content;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html>