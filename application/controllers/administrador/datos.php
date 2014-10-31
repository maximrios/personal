<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Datos extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
        $this->load->library('hits/gridview');
        //$this->load->library('hits/messages', '', 'messages');
		$this->load->model('admin/datos_model', 'datos');
		$this->_aReglas = array(
			array(
	            'field'   => 'idCliente',
	            'label'   => 'Codigo de Cliente',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
	        ,array(
	            'field'   => 'nombreCliente',
	            'label'   => 'Nombre',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'domicilioCliente',
	            'label'   => 'Domicilio',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'telefonoCliente',
	            'label'   => 'Telefono',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'celularCliente',
	            'label'   => 'Celular',
	            'rules'   => 'trim|xss_clean'
	        )
	        ,array(
	            'field'   => 'emailCliente',
	            'label'   => 'Email',
	            'rules'   => 'trim|xss_clean|required'
	        )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCliente' => null
            , 'nombreCliente' => null
            , 'domicilioCliente' => ''
            , 'telefonoCliente' => ''
            , 'celularCliente' => null
            , 'emailCliente' => ''
        );
        $inId = ($this->input->post('idCliente') !== false) ? $this->input->post('idCliente') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->datos->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idCliente' => $inId
                , 'nombreCliente' => set_value('nombreCliente')
                , 'domicilioCliente' => set_value('domicilioCliente')
                , 'telefonoCliente' => set_value('telefonoCliente')
                , 'celularCliente' => set_value('celularCliente')
                , 'emailCliente' => set_value('emailCliente')
            );
        }
        return $this->_reg;
    }
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$aData = array();
		$this->_content = $this->load->view('admin/contactos/datos', $aData, true);
		$this->_menu = menu_ul('datos');
		parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/eventos/listado'
                    , 'iTotalRegs' => $this->eventos->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Eventos'
                    , 'identificador' => 'idEvento'
                )
        );
        $this->gridview->addColumn('idEvento', '#', 'int');
        $this->gridview->addColumn('nombreEvento', 'Evento', 'text');
        $this->gridview->addColumn('domicilioEvento', 'Domiclio', 'text');
        $this->gridview->addColumn('telefonoEvento', 'Teléfono', 'text');
        $this->gridview->addColumn('emailEvento', 'Email', 'text');
        $this->gridview->addColumn('fechaDesdeEvento', 'Fecha', 'date');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="#" ic-post-to="eventos/formulario/{idEvento}" title="Modificar el evento {nombreEvento}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>';
        $eliminar = '<a href="#" ic-post-to="eventos/eliminar/{idEvento}" title="Eliminar evento {nombreEvento}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-trash"></span>&nbsp;</a>';
        $controles = $editar.$eliminar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $controles, 'class' => 'acciones'));
        $this->_rsRegs = $this->eventos->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/eventos/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
	function formulario() {
        $aData['Reg'] = $this->datos->obtenerUno();
        $aData['formAction'] = 'datos/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/contactos/formdatos', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
        	$this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->datos->guardar(
                array(
                    $this->_reg['idCliente']
                    , $this->_reg['nombreCliente']
                    , $this->_reg['domicilioCliente']
                    , $this->_reg['telefonoCliente']
                    , $this->_reg['celularCliente']
                    , $this->_reg['emailCliente']
                )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se modificaron los datos de contacto.';
            } 
            else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        }
        else {
        	$this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        $this->formulario();
	}
	public function eliminar($evento) {
        $evento = $this->eventos->obtenerUno($evento);
        if($evento) {
            $this->_aEstadoOper['status'] = $this->eventos->eliminar($evento['idEvento']);
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se eliminó el evento correctamente.';
            } 
            else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        }
        else {
            $this->_aEstadoOper['message'] = 'Ocurrió un error al eliminar el evento. Consulte con el administrador del sistema.';
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        $this->listado();
    }
}