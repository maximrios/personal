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
    function line($title='Bar Chart')
    {
    	require_once (APPPATH.'third_party/jpgraph/src/jpgraph_line.php');
        require_once (APPPATH.'third_party/jpgraph/src/jpgraph_bar.php');
        require_once (APPPATH.'third_party/jpgraph/src/jpgraph_mgraph.php');
        $ydata = array(11,3,8,12,5,1,9,13,5,7);

		// Create the graph. These two calls are always required
		$graph = new Graph(350,250);
		$graph->SetScale('textlin');

		// Create the linear plot
		$lineplot=new LinePlot($ydata);
		$lineplot->SetColor('blue');

		// Add the plot to the graph
		$graph->Add($lineplot);

		// Display the graph
		return $graph->Stroke();
    }
} 