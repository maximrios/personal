<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Noticias extends Ext_Controller {
	function __construct() {
		parent::__construct();
		$this->load->model('layout_model', 'layout');
	}
	public function index() {
		$data = array();
		$this->load->helper('text_helper');
		$data['noticias'] = $this->layout->obtenerNoticias();
		$this->_menu = 'noticias';
		$this->_content = $this->load->view('noticias', $data, true);
		parent::index();
	}
	public function noticia($noticia) {
		$data = array();
		$data['relacionadas'] = $this->layout->obtenerNoticias();
		$data['noticia'] = $this->layout->obtenerNoticiaId($noticia);
		$this->_menu = 'noticias';
		if($data['noticia']) {
			$this->_content = $this->load->view('noticia', $data, true);
			parent::index();
		}
		else {
			redirect('noticias');
		}
	}
}
/* End of file noticias.php */
/* Location: ./application/controllers/noticias.php */