<div class="panel panel-default">
    <div class="panel-heading">Ficha personal .::</div>
    <div class="panel-body">
        <figure class="info-agente">
            <div class="imagen-agente">
                <img src="http://lorempixel.com/100/100/business/">
            </div>
            <figcaption>
                <ul>
                    <li><?=$agente['nombreCompletoPersona']?></li>
                    <li>Correo electrónico : <?=$agente['emailPersona']?></li>
                    <li>Interno N° : <?=$agente['internoAgente']?></li>
                </ul>
            </figcaption>
        </figure>
        <a href="#" ic-post-to="agentes/listado" ic-target="#main_content" class="btn btn-primary pull-right">Cambiar de agente</a>
    </div>
</div>
<ul id="tabs">
    <li><a href="#" ic-post-to="<?=site_url('administrador/agentes/listado');?>" ic-target="#tabs-content" class="color-rosado"><span class="glyphicon glyphicon-book"></span><span>&nbsp;&nbsp;</span></a></li>
    <li id="current"><a href="#" ic-post-to="<?=site_url('administrador/licencias/listado/'.$this->session->userdata('idAgente'));?>" ic-target="#tabs-content" title="Licencias" class="color-turquesa"><span class="glyphicon glyphicon-calendar"></span><span>&nbsp;&nbsp;Licencias</span></a></li>
    <li><a href="#" ic-post-to="<?=site_url('administrador/formaciones/listado/'.$this->session->userdata('idAgente'));?>" ic-target="#tabs-content" title="Fomración académica" class="color-celeste"><span class="glyphicon glyphicon-book"></span><span>&nbsp;&nbsp;Formacion académica</span></a></li>
    <li><a href="#" title="Situación laboral" ic-post-to="<?=site_url('administrador/agentes/situacion/'.$this->session->userdata('idAgente'));?>" ic-target="#tabs-content" class="color-verde"><span class="glyphicon glyphicon-briefcase"></span><span>&nbsp;&nbsp;Situación laboral</span></a></li>
    <li><a href="#" title="Datos personales" ic-post-to="<?=site_url('administrador/agentes/formulario/'.$this->session->userdata('idAgente'));?>" ic-target="#tabs-content" class="color-azul"><span class="glyphicon glyphicon-user"></span><span>&nbsp;&nbsp;Datos personales</span></a></li>
</ul>
 
<div id="content">
	<div id="tabs-content" ic-trigger-on="load" ic-verb="POST" ic-src="agentes/formulario/<?=$agente['idAgente']?>" ic-target="#tabs-content">
	</div>
</div>