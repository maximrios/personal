<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Staff extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
        $this->load->library('hits/gridview');
		$this->load->model('admin/staff_model', 'staff');
		$this->_aReglas = array(
			array(
	            'field'   => 'idPersona',
	            'label'   => 'Codigo de Persona',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
            ,array(
                'field'   => 'apellidoPersona',
                'label'   => 'Apellido',
                'rules'   => 'trim|xss_clean|required'
            )
	        ,array(
	            'field'   => 'nombrePersona',
	            'label'   => 'Nombre',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'nacimientoPersona',
	            'label'   => 'Fecha de nacimiento',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'domicilioPersona',
	            'label'   => 'Domicilio',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'telefonoPersona',
	            'label'   => 'Teléfono',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'celularPersona',
	            'label'   => 'Celular',
	            'rules'   => 'trim|xss_clean'
	        )
	        ,array(
	            'field'   => 'emailPersona',
	            'label'   => 'Email',
	            'rules'   => 'trim|xss_clean|required'
	        )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idPersona' => null
            , 'apellidoPersona' => null
            , 'nombrePersona' => null
            , 'nacimientoPersona' => null
            , 'domicilioPersona' => null
            , 'telefonoPersona' => null
            , 'celularPersona' => null
            , 'emailPersona' => null
        );
        $inId = ($this->input->post('idPersona') !== false) ? $this->input->post('idPersona') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->noticias->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idPersona' => $inId
                , 'nombrePersona' => set_value('nombrePersona')
                , 'apellidoPersona' => set_value('apellidoPersona')
                , 'nacimientoPersona' => set_value('nacimientoPersona')
                , 'domicilioPersona' => set_value('domicilioPersona')
                , 'telefonoPersona' => set_value('telefonoPersona')
                , 'celularPersona' => set_value('celularPersona')
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
		$this->_content = $this->load->view('admin/staff/principal', $aData, true);
		$this->_menu = menu_ul('staff');
		parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/staff/listado'
                    , 'iTotalRegs' => $this->staff->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Staff'
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
        $this->_rsRegs = $this->staff->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/staff/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
	function formulario() {
		$aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['formAction'] = 'staff/guardar';
        $aData['mensajeServer'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/staff/formulario', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
        	$this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->eventos->guardar(
                array(
                    $this->_reg['idEvento']
                    , $this->_reg['nombreEvento']
                    , $this->_reg['descripcionEvento']
                    , GetDateTimeFromFrenchToISO($this->_reg['fechaDesdeEvento'])
                    , GetDateTimeFromFrenchToISO($this->_reg['fechaHastaEvento'])
                    , $this->_reg['domicilioEvento']
                    , $this->_reg['telefonoEvento']
                    , $this->_reg['emailEvento']
                )
            );
        }
        else {
        	$this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        if ($this->_aEstadoOper['status'] > 0) {

        }
        else {
            $this->formulario();
        }
	}
	public function eliminar() {
		antibotCompararLlave($this->input->post('vcForm'));
    	$this->_aEstadoOper['status'] = $this->contactos->eliminar($this->input->post('idContacto'));
	   	if($this->_aEstadoOper['status'] > 0) {
			$this->_aEstadoOper['message'] = 'El registro fue eliminado con exito.';
	   	} 
	   	else {
			$this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
	   	}
		$this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'alert'));		
       	$this->listado();
	}
}