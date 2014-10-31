<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Fid extends Ext_Controller {
	function __construct() {
		parent::__construct();
	}
	public function index() {
		$data = array();
		$this->_content = $this->load->view($this->config->item('ext_theme_folder').'inicio', $data, true);
		parent::index();
	}
	public function fundacion() {
		$data = array();
		$this->_content = $this->load->view($this->config->item('ext_theme_folder').'fundacion', $data, true);
		parent::index();	
	}
}
/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */