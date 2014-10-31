<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends Ext_AutController {
	function __construct() {
		parent::__construct();
		$this->load->model('sigep/agentes_model', 'agentes');
		$this->load->model('sigep/licencias_model', 'licencias');
	}
	public function index() {
		$aData = array();
		$aData['proximos'] = $this->agentes->cumpleanosProximosAgentes();
		$aData['hoy'] = $this->agentes->cumpleanosHoyAgentes();
		$aData['novedades'] = $this->licencias->obtener();
		$this->_content = $this->load->view('admin/dashboard',$aData,true);
		$this->_menu = menu_ul('inicio');
		parent::index();
	}
	public function parte() {
		$this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $aData = array();
        $aData['agentes'] = $this->agentes->obtener();
        $this->load->view('admin/reportes/parte', $aData);
	}
	public function ausentismo() {
		$this->load->library('hits/Jpgraph', array(), 'jpgraph');
		$x = $this->licencias->novedadesLicencias();
		$aData = array(
			'titulo' => 'Ausentismo'
			, 'x' => array_values($x['cantidad'])
			, 'y' => array('Informatica', 'Economia', 'Filosofia')
			, 'w' => 310
			, 'h' => 260
		);
		/*$x = array(12, 16, 34);
		$y = array('Informatica', 'Economia', 'Filosofia');*/
		$bar_graph = $this->jpgraph->pie($aData['x'], $aData['y'], $aData['w'], $aData['h'], $aData['titulo']);
        echo $bar_graph;
	}
}
?>