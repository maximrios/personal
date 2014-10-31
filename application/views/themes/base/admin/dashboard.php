<style type="text/css">
.jpgraph-content {
    text-align: center;
}
.jpgraph-pie {
    width: 100%!important;
}
</style>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Ausentismo</div>
            <div class="panel-body panel-collapse jpgraph-content">
                <img src="admin/ausentismo" class="jpgraph-pie">
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Ausentismo</div>
            <div class="panel-body panel-collapse jpgraph-content">
                <img src="admin/ausentismo" class="jpgraph-pie">
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Ausentismo</div>
            <div class="panel-body panel-collapse jpgraph-content">
                <img src="admin/ausentismo" class="jpgraph-pie">
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Novedades hoy<a data-toggle="collapse" href="#novedades"><span class="glyphicon glyphicon-minus pull-right"></span></a></div>
  			<div id="novedades" class="panel-body panel-collapse">
  				<table class="table table-striped">
  					<thead>
  						<tr>
  							<th>Agente</th>
  							<th>Novedad</th>
  							<th>F. Desde</th>
  							<th>F. Hasta</th>
                            <th>F. Retorno</th>
  						</tr>
  					</thead>
                    <tbody>
                        <?php foreach ($novedades as $novedad) { ?>
                            <tr>
                                <td><?=$novedad['nombreCompletoPersona']?></td>
                                <td><?=$novedad['nombreLicencia']?></td>
                                <td><?=GetDateFromISO($novedad['desdeAgenteLicencia'])?></td>
                                <td><?=GetDateFromISO($novedad['hastaAgenteLicencia'])?></td>
                                <td><?=GetDateFromISO($novedad['retornoAgenteLicencia'])?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
  				</table>
                <div class="row">
                    <a href="admin/parte" target="_blank" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;Imprimir parte diario</a>    
                </div>
  			</div>
  		</div>
	</div>
</div>
<div class="row">
  	<?php if($hoy) { ?>
  		<div class="col-lg-6">
  			<div class="panel panel-default">
				<div class="panel-heading">Cumpleaños hoy (<?=count($hoy)?>)<a data-toggle="collapse" href="#hoy"><span class="glyphicon glyphicon-minus pull-right"></span></a></div>
  				<div id="hoy" class="panel-body panel-collapse">
  					<?php foreach ($hoy as $agente) { ?>
					<figure class="cumpleanos-agentes-hoy">
						<div class="cumpleanos-imagen">
							<img src="assets/images/agentes/16000754.jpg">	
						</div>
						<!--<img src="<?=$agente['pathPersona']?>" width="100">-->
						<figcaption>
							<span><?=$agente['apellidoPersona'].', '.$agente['nombrePersona']?></span>
                            <span><?=$agente['denominacionCargo']?></span>
                            <span><?=$agente['nombreArea']?></span>
                            <span>Email : <a href="mailto:<?=$agente['emailPersona']?>"><?=$agente['emailPersona']?></a></span>
                            <span>Interno N° : <?=$agente['internoAgente']?></span>
						</figcaption>
					</figure>
  					<?php } ?>
  				</div>
  			</div>
  		</div>
  	<?php } ?>
  	<?php if($proximos) { ?>
  		<div class="<?=($hoy)? 'col-lg-6':'col-lg-12'?>">
			<div class="panel panel-default">
				<div class="panel-heading">Próximos cumpleaños del mes (<?=count($proximos)?>)<a data-toggle="collapse" href="#proximos"><span class="glyphicon glyphicon-minus pull-right"></span></a></div>
  				<div id="proximos" class="panel-body panel-collapse">
  					<ul class="cumpleanos-agentes-proximos">
						<?php foreach ($proximos as $agente) { ?>
						<li><img src="<?=$agente['pathPersona']?>"><span><?=$agente['apellidoPersona'].', '.$agente['nombrePersona']?> | <?=substr(GetDateFromISO($agente['nacimientoPersona']),0,5)?></span></li>
  						<?php } ?>
  					</ul>
  				</div>
  			</div>
  		</div>
  	<?php } ?>
</div>
  		