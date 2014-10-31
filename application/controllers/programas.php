<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Programas extends Ext_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('layout_model', 'layout');
	}
	public function index() {
		$this->load->helper('text');
		$aData['breadcrumb'] = '<a href="#">Inicio</a> / Programas';
		$aData['programas'] = $this->layout->obtenerProgramas();
		$this->_menu = 'programas';
		$this->_content = $this->load->view('programas', $aData, true);
		parent::index();
	}
	public function programa($idPrograma) {
		$aData['programa'] = $this->layout->obtenerProgramasUno($idPrograma);
		$aData['breadcrumb'] = '<a href="#">Inicio</a> / <a href="'.site_url('programas').'">Programas</a> / '.$aData['programa']['nombrePrograma'];
		$this->_menu = 'programas';
		$this->_content = $this->load->view('programa', $aData, true);
		parent::index();
	}
}
/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */