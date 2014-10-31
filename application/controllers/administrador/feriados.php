<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Feriados extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
        $this->load->library('hits/gridview');
		$this->load->model('sigep/feriados_model', 'feriados');
		$this->_aReglas = array(
			array(
	            'field'   => 'idFeriado',
	            'label'   => 'Codigo de feriado',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
	        ,array(
	            'field'   => 'fechaFeriado',
	            'label'   => 'Fecha',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'motivoFeriado',
	            'label'   => 'Motivo',
	            'rules'   => 'trim|xss_clean|required'
	        )
		);
	}
	protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idFeriado' => null
            , 'fechaFeriado' => null
            , 'motivoFeriado' => ''
        );
        $inId = ($this->input->post('idFeriado') !== false) ? $this->input->post('idFeriado') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->feriados->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idFeriado' => $inId
                , 'fechaFeriado' => set_value('fechaFeriado')
                , 'motivoFeriado' => set_value('motivoFeriado')
            );
        }
        return $this->_reg;
    }
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
	function index() {
		$aData = array();
		$this->_content = $this->load->view('admin/feriados/principal', $aData, true);
		$this->_menu = menu_ul('feriados');
		parent::index();
	}
	public function listado() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/feriados/listado'
                    , 'iTotalRegs' => $this->feriados->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de feriados y dias no laborales'
                    , 'identificador' => 'idFeriado'
                )
        );
        $this->gridview->addColumn('idFeriado', '#', 'int');
        $this->gridview->addColumn('fechaFeriado', 'Fecha', 'date');
        $this->gridview->addColumn('motivoFeriado', 'Motivo', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $tamano = '64';
        $editar = '<a href="#" ic-post-to="feriados/formulario/{idFeriado}" title="Modificar el feriado {motivoFeriado}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>';
        $eliminar = '<a href="#" ic-post-to="feriados/eliminar/{idFeriado}" class="eliminar" title="Eliminar el feriado {motivoFeriado}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-trash"></span>&nbsp;</a>';
        $acciones = $editar.$eliminar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        $this->_rsRegs = $this->feriados->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/feriados/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
	function formulario($feriado=FALSE) {
        if($feriado) {
            $aData['Reg'] = $this->feriados->obtenerUno($feriado);
            $aData['Reg']['fechaFeriado'] = GetDateFromISO($aData['Reg']['fechaFeriado']);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        }
        $aData['vcFrmAction'] = 'feriados/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/feriados/formulario', $aData);
	}
	function guardar() {
		antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
        	$this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->feriados->guardar(
                array(
                    $this->_reg['idFeriado']
                    , GetDateTimeFromFrenchToISO($this->_reg['fechaFeriado'])
                    , $this->_reg['motivoFeriado']
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
	public function eliminar($feriado) {
        echo "llega";
        die();
        $feriado = $this->feriados->obtenerUno($feriado);
        if($feriado) {
            $this->_aEstadoOper['status'] = $this->feriados->eliminar($feriado['idFeriado']);
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se eliminó el feriado correctamente.';
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