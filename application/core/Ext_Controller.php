<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Ext_Controller extends CI_Controller {
	protected $_SiteInfo = array(
		'title' => ''
		,'descriptions' => ''
		, 'author' => ''
	);
	protected $_aJsIncludes = array();
	protected $_aCssIncludes = array();
	protected $_content = '';
	protected $_menu = '';
	function __construct() {
		parent::__construct();
		$this->_init();
	}
	function index() {
		$data = array('site_info'=> $this->_siteInfo()
			, 'includes' => $this->_getCssIncs(). $this->_getJsIncs()
			, 'main_menu' => menu_template($this->_menu)
			, 'main_content' => $this->_content
		);
		$this->load->view('template', $data);
	}
	protected function _init() {
		$this->load->library('Form_validation');
		$this->_SiteInfo = array_merge($this->_SiteInfo, $this->config->item('ext_site_info'));
	}
	protected function _getJsIncs() {
		$vcXHtml = '';
		for($i=0;$i<sizeof($this->_aJsIncludes);$i++) {
			$vcXHtml .= '<script src="'.$this->_aJsIncludes[$i].'"></script>';
		}
		return $vcXHtml;
	}
	protected function _getCssIncs() {
		$vcXHtml = '';
		for($i=0;$i<sizeof($this->_aCssIncludes);$i++) {
			$vcXHtml .= '<link href="'.$this->_aCssIncludes[$i].'" rel="stylesheet" type="text/css" />';
		}
		return $vcXHtml;
	}
	protected function _inicReg() {
		show_error(get_class($this).'::_initReg(). Metodo de clase abstracta no implementado!');
	}
	public function _Menu($opciones=array()) {
		return $this->_menu;
	}
	protected function _inicReglas() {
		show_error(get_class($this).'::_initReglas(). Metodo de clase abstracta no implementado!');
	}
	protected function _validarReglas() {
		return $this->form_validation->run();
	}
	public function _getReglas() {
		return $this->_aReglas;
	}
	public function _siteInfo($opciones=array()) {
		return $this->_SiteInfo;
	}
	public function error($inHttpStatus=404) {
		$inHttpStatus = (int)$inHttpStatus;
		if($inHttpStatus==0)
			return false;
		$this->load->view('../../'.$inHttpStatus.'.html');
	}
}
Class Ext_AutController extends Ext_Controller {
	protected $_content = '';
	protected $_menu = '';
	protected $_PanelInfo = array(
		'titulo' => ''
		, 'cliente' => ''
	);
	function __construct($opciones=array()) {
		parent::__construct();
	}
	function index() {
		$data = array('PanelInfo'=> $this->_panelInfo()
			, 'vcIncludesGlobales' => $this->_getCssIncs(). $this->_getJsIncs()
			, 'menu' => $this->_menu
			, 'main_content' => $this->_content
		);
		$this->load->view('admin/template',$data);
	}
	
	protected function _init() {
		parent::_init($opciones=array());
		$this->load->library('Form_validation');
		$this->load->library('hits/autenticacion', null, 'autenticacion');
		$this->load->library('Ext_ubicacion', null, 'ubicacion');
		//$this->load->library('Ext_permisos', null, 'permisos');
		$this->_PanelInfo = array_merge($this->_PanelInfo, $this->config->item('ext_base_panel'));
		$this->autenticacion->logged();
		//$this->load->model($this->db->dbdriver.'/configuracion/excepciones_model');
		//$this->load->model('hits/excepciones_model');
		/*if($this->lib_autenticacion->verificarPermisoUri()==FALSE) {
			echo $this->lib_autenticacion->doRedirect($this->lib_autenticacion->opciones['login_uri'],'No posee autorización para realizar esta acción: '. uri_string()); 
			die();
		}*/
		
	}
	public function _panelInfo($opciones=array()) {
		return $this->_PanelInfo;
	}
	protected function _obtenerMenu($aOpciones=array()) {
		return $this->lib_autenticacion->obtenerMenu($aOpciones);
	}
	
	protected function _obtenerMensajeErrorDB($inErrCod) {
		$rsReg = $this->excepciones_model->obtenerUnoPorCodigo($inErrCod);
		return $rsReg['vcExpMensaje'];
	}
	/*protected function _obtenerCumpleanos() {
		$this->load->model('sigep/layout_model', 'layout');
		$rsReg = $this->layout->cumpleanos();
		return $rsReg;
	}
	protected function _obtenerMensajesNuevos() {
		$this->load->model('sigep/layout_model', 'layout');
		$rsReg = $this->layout->mensajesNuevos($this->lib_autenticacion->idAgente());
		return $rsReg;
	}
	*/
	public function verificarPermisos() {
		$post = $this->input->post('uris');
		$post = explode(',', $post);
		$post = $this->lib_autenticacion->verificarPermisosUri($post);
		$this->output->set_content_type('application/xml');
		$this->output->set_output($post);
	}
}

abstract class Ext_crud_controller extends Ext_AutController
{
	protected $_aReglas = array();
	public $_oModel = null;
	protected $_aEstadoOper = array('status' => null, 'message' => '');
	protected $_reg = array();
	
	function __construct() {
		parent::__construct();
		/*
		 * to do: El controlador debera:
		 * 	- Cargar el modelo principal dentro de $this->_oModel.
		 * 	- cargar los modelos, librerias y helpers que necesite.
		 * 	- Inicializar la referencia al registro actual.
		 */
	}
	
	protected function _inicReg() {
		/**
		 * La implementación del método queda sujeta al controlador específico.
		 * Inicialmente solo debe verificar si debe cargar el registro seleccionado para ejecutar alguna accion con él. Luego verificar si ya paso la validacion para poder discriminar los datos a cargar en el registro actual.
		 */
		show_error(get_class($this).'::_initReg(). Metodo de clase abstracta no implementado!');
	}
	
	protected function _inicReglas() {
		/*
		 * La inicializacion de las reglas debe hacerse segun el controlador a especificar.
		 * cada regla se inicializa como un valor en el array $this->_aReglas
		 * p.e.:
		 * $this->_aReglas['vcPerNombre'] = array('label'=>'Nombre','rule'=>'xss|trim|required');
		 */
		
		show_error(get_class($this).'::_initReglas(). Metodo de clase abstracta no implementado!');
	}
	
	protected function _validarReglas() {
		return $this->form_validation->run();
	}
	
	public function _getReglas() {
		return $this->_aReglas;
	}
	
	public function formulario(){
	   show_error(get_class($this).'::formulario(). Metodo de clase abstracta no implementado!');   
	}
    
	public function guardar() {
		show_error(get_class($this).'::guardar(). Metodo de clase abstracta no implementado!');
	}
	
	public function listado() {
		show_error(get_class($this).'::listado(). Metodo de clase abstracta no implementado!');
	}
	
	public function ver() {
		show_error(get_class($this).'::ver(). Metodo de clase abstracta no implementado!');
	}
	
	public function eliminar() {
		show_error(get_class($this).'::eliminar(). Metodo de clase abstracta no implementado!');
	}
}
?>