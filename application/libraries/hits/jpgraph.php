<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jpgraph {
    protected $colores = array('#4865DA');
    public function __construct() {
    	require_once (APPPATH.'third_party/jpgraph/src/jpgraph.php');
    }
    public function pie($x, $y, $w, $h, $title='Grafico'){
        require_once (APPPATH.'third_party/jpgraph/src/jpgraph_pie.php');
		$grafico = new PieGraph($w, $h);
		$grafico->title->Set($title);
		$grafico->title->SetFont(FF_UBUNTU, FS_BOLD, 14);
		$p1 = new PiePlot($x);
		$p1->SetLegends($y);
		$grafico->legend->Pos(0.1,0.9);
		$p1->SetCenter(0.4);
		$grafico->Add($p1);
		return $grafico->Stroke();
    }
} 