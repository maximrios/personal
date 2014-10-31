<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
        $this->load->library('hits/gridview');
		$this->load->model('admin/newsletter_model', 'newsletters');
		$this->_aReglas = array(
			array(
	            'field'   => 'idPersona',
	            'label'   => 'Codigo de Persona',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
            ,array(
                'field'   => 'nombrePersona',
                'label'   => 'Nombre de suscriptor',
                'rules'   => 'trim|xss_clean|required'
            )
	        ,array(
	            'field'   => 'apellidoPersona',
	            'label'   => 'Apellido de suscriptor',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'emailPersona',
	            'label'   => 'Email de suscriptor',
	            'rules'   => 'trim|xss_clean|required'
	        )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idPersona' => null
            , 'apellidoPersona' => null
            , 'nombrePersona' => ''
            , 'emailPersona' => ''
        );
        $inId = ($this->input->post('idPersona') !== false) ? $this->input->post('idPersona') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->newsletters->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idPersona' => $inId
                , 'nombrePersona' => set_value('nombrePersona')
                , 'apellidoPersona' => set_value('apellidoPersona')
                , 'emailPersona' => set_value('emailPersona')
            );
        }
        return $this->_reg;
    }
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$aData = array();
		$this->_content = $this->load->view('admin/newsletter/principal', $aData, true);
		$this->_menu = menu_ul('newsletter');
		parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/newsletter/listado'
                    , 'iTotalRegs' => $this->newsletters->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Suscriptores'
                    , 'identificador' => 'idPersona'
                )
        );
        $this->gridview->addColumn('idPersona', '#', 'int');
        $this->gridview->addColumn('completoPersona', 'Suscriptor', 'text');
        $this->gridview->addColumn('emailPersona', 'Email', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="#" ic-post-to="newsletter/formulario/{idPersona}" title="Modificar suscriptor {completoPersona}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>';
        $eliminar = '<a href="#" ic-post-to="newsletter/eliminar/{idPersona}" title="Eliminar suscriptor {completoPersona}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-trash"></span>&nbsp;</a>';
        $controles = $editar.$eliminar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $controles, 'class' => 'acciones'));
        $this->_rsRegs = $this->newsletters->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/newsletter/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
	function formulario($suscriptor=FALSE) {
        if($suscriptor) {
            $aData['Reg'] = $this->newsletters->obtenerUno($suscriptor);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        }
        $aData['formAction'] = 'newsletter/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/newsletter/formulario', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
        	$this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->newsletters->guardar(
                array(
                    $this->_reg['idPersona']
                    , $this->_reg['nombrePersona']
                    , $this->_reg['apellidoPersona']
                    , $this->_reg['emailPersona']
                    , 1
                )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
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
        if ($this->_aEstadoOper['status'] > 0) {
            $this->listado();
        }
        else {
            $this->formulario();
        }
	}
	public function eliminar($suscriptor) {
        $suscriptor = $this->newsletters->obtenerUno($suscriptor);
        if($suscriptor) {
            $this->_aEstadoOper['status'] = $this->newsletters->eliminar($suscriptor['idPersona']);
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se eliminó el suscriptor del newsletter correctamente.';
            } 
            else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        }
        else {
            $this->_aEstadoOper['message'] = 'Ocurrió un error al eliminar el suscriptor. Consulte con el administrador del sistema.';
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        $this->listado();
    }
}