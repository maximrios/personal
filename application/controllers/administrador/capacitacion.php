<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Capacitacion extends Ext_crud_Controller {
	function __construct() {
		parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->library('hits/nested_set');
        $this->nested_set->setControlParams('hits_cursos_materiales');
        //$this->load->library('hits/messages', '', 'messages');
		$this->load->model('admin/capacitacion_model', 'capacitacion');
		$this->_aReglas = array(
			array(
	            'field'   => 'idEvento',
	            'label'   => 'Codigo de Evento',
	            'rules'   => 'trim|max_length[80]|xss_clean'
	        )
	        ,array(
	            'field'   => 'nombreEvento',
	            'label'   => 'Nombre de evento',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'descripcionEvento',
	            'label'   => 'Descripcion del evento',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'fechaDesdeEvento',
	            'label'   => 'Fecha de inicio',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'fechaHastaEvento',
	            'label'   => 'Fecha de fin',
	            'rules'   => 'trim|xss_clean|required'
	        )
	        ,array(
	            'field'   => 'domicilioEvento',
	            'label'   => 'Domicilio de evento',
	            'rules'   => 'trim|xss_clean'
	        )
	        ,array(
	            'field'   => 'telefonoEvento',
	            'label'   => 'Telefono de evento',
	            'rules'   => 'trim|xss_clean'
	        )
	        ,array(
	            'field'   => 'emailEvento',
	            'label'   => 'Correo electronico de evento',
	            'rules'   => 'trim|xss_clean'
	        )
		);
        $this->_aReglasModulo = array(
            array(
                'field'   => 'idCursoMaterial',
                'label'   => 'Codigo de Material',
                'rules'   => 'trim|max_length[80]|xss_clean'
            )
            ,array(
                'field'   => 'nombreCursoMaterial',
                'label'   => 'Nombre del módulo',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'padreCursoMaterial',
                'label'   => 'Codigo de Curso',
                'rules'   => 'trim|xss_clean|required'
            )
        );
	}
	protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idCursoMaterial' => null
            , 'leftCursoMaterial' => null
            , 'rightCursoMaterial' => ''
            , 'padreCursoMaterial' => ''
            , 'nombreCursoMaterial' => null
            , 'adjuntoCursoMaterial' => ''
            , 'fechaCursoMaterial' => null
        );
        $inId = ($this->input->post('idCursoMaterial') !== false) ? $this->input->post('idCursoMaterial') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->eventos->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idCursoMaterial' => $inId
                , 'leftCursoMaterial' => set_value('leftCursoMaterial')
                , 'rightCursoMaterial' => set_value('rightCursoMaterial')
                , 'padreCursoMaterial' => set_value('padreCursoMaterial')
                , 'nombreCursoMaterial' => set_value('nombreCursoMaterial')
                , 'adjuntoCursoMaterial' => set_value('adjuntoCursoMaterial')
                , 'fechaCursoMaterial' => set_value('fechaCursoMaterial')
            );
        }
        return $this->_reg;
    }
	protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    protected function _inicReglasModulo() {
        $val = $this->form_validation->set_rules($this->_aReglasModulo);
    }
	function index() {
		$aData = array();
		$this->_content = $this->load->view('admin/capacitacion/principal', $aData, true);
		$this->_menu = menu_ul('eventos');
		parent::index();
	}
	public function listado($idCursoMaterial=1) {
        $obtener = array(
            'padreCursoMaterial' => $idCursoMaterial
            , 'estadoCursoMaterial' => 1
            , 'publicadoCursoMaterial' => 1
        );
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/capacitacion/listado'
                    , 'iTotalRegs' => $this->capacitacion->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Materiales'
                    , 'identificador' => 'idCursoMaterial'
                )
        );
        $this->gridview->addColumn('idCursoMaterial', '#', 'int');
        $this->gridview->addColumn('nombreCursoMaterial', 'Evento', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="#" ic-post-to="capacitacion/carpeta/{padreCursoMaterial}/{idCursoMaterial}" title="Modificar el evento {nombreCursoMaterial}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-pencil"></span>&nbsp;</a>';
        $eliminar = '<a href="#" ic-post-to="capacitacion/listado/{idCursoMaterial}" title="Entrar al material {nombreCursoMaterial}" ic-target="#main_content">&nbsp;<span class="glyphicon glyphicon-folder-open"></span>&nbsp;</a>';

        $controles = $editar.$eliminar;
        $funciones = array(
                'functionName' => 'validar',
                'parms' => array('valor1' => '{idCursoMaterial}')
            );
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $controles, 'class' => 'acciones', 'function' => $funciones));
        $nodo = $this->nested_set->getNodeFromId($idCursoMaterial);
        $this->_rsRegs = $this->nested_set->getTreePreorder($nodo, true);
        $breadcrumb = '<a>'.$nodo['nombreCursoMaterial'].'</a>/<a></a>';
        //$this->_rsRegs = $this->capacitacion->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/capacitacion/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'breadcrumb' => $breadcrumb
                , 'nodo' => $nodo
            )
        );
    }
	function formulario($evento=FALSE) {
        if($evento) {
            $aData['Reg'] = $this->nested_set->getNodeFromId($idCursoMaterial);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        }
        $aData['formAction'] = 'capacitacion/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/capacitacion/formulario', $aData);
	}
    function carpeta($nodo, $idCursoMaterial=0) {
        if($idCursoMaterial) {
            $aData['Reg'] = $this->nested_set->getNodeFromId($idCursoMaterial);
            $aData['Reg']['padreCursoMaterial'] = $nodo;
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
            $aData['Reg']['padreCursoMaterial'] = $nodo;
        }
        $aData['parent'] = $this->nested_set->getNodeFromId($nodo);
        $aData['formAction'] = 'capacitacion/crearCarpeta';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/capacitacion/modulo', $aData);
    }
    function crearCarpeta() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasModulo();
        if ($this->_validarReglas()) {
            $this->_reg = $this->_inicReg($this->input->post('vcForm'));    
            if($this->_reg['idCursoMaterial'] > 0) {
                $node = $this->nested_set->getNodeFromId($this->_reg['idCursoMaterial']);
                $node['nombreCursoMaterial'] = $this->_reg['nombreCursoMaterial'];
                $this->_aEstadoOper['status'] = $this->nested_set->updateNameNode($node);
            }
            else {
                $parentNode = $this->nested_set->getNodeFromId($this->_reg['padreCursoMaterial']);
                $this->_aEstadoOper['status'] = $this->nested_set->appendNewChild($parentNode, array(
                'nombreCursoMaterial' => $this->_reg['nombreCursoMaterial'], 'adjuntoCursoMaterial' => $parentNode['adjuntoCursoMaterial'].url_title(strtolower($this->_reg['nombreCursoMaterial'])).'/'));
                if ($this->_aEstadoOper['status'] > 0) {
                    mkdir($parentNode['adjuntoCursoMaterial'].url_title(strtolower($this->_reg['nombreCursoMaterial'])), 0777);
                }
                else {
                    $this->_aEstadoOper['message'] = 'No se pudo guardar el registro';
                } 
            }
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
            $this->listado($this->_reg['padreCursoMaterial']);
        }
        else {
            $this->carpeta($this->_reg['padreCursoMaterial']);
        }
    }
    public function archivos($nodo, $idCursoMaterial=FALSE) {
        if($idCursoMaterial) {
            $aData['Reg'] = $this->nested_set->getNodeFromId($idCursoMaterial);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
            $aData['Reg']['padreCursoMaterial'] = $nodo;
        }
        $aData['formAction'] = 'capacitacion/uploadStatus';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/capacitacion/archivos3', $aData);
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
                    , url_title(strtolower($this->_reg['nombreEvento']))
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
    public function upload() {
        //$noticia = $this->noticias->obtenerUno($this->input->post('idCursoMaterial'));
        //if($noticia) {
        $parentNode = $this->nested_set->getNodeFromId($this->input->post('padreCursoMaterial'));
            $path = $parentNode['adjuntoCursoMaterial'];
            $config = array(
                'cantidad_imagenes' => 1
                , 'upload_path' => $path
                , 'allowed_types' => 'pdf|docx|doc|ppt|pptx|pptm|ppsx|xls|xlsx|txt'
                , 'max_size' => 10000
                , 'create_thumb' => false
            );
            $this->load->library('hits/uploads', array(), 'uploads');
            $data = $this->uploads->do_upload($config);
            //print_r($_FILES['userfile']['type']);
            if(!$data['error']) {
                $this->_aEstadoOper['status'] = 1;
                $this->_aEstadoOper['message'] = 'Se agrego el archivo correctamente.';
                $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
                print_r($data);
                $this->_aEstadoOper['status'] = $this->nested_set->appendNewChild($parentNode, array(
                'nombreCursoMaterial' => $this->input->post('nombreCursoMaterial'), 'adjuntoCursoMaterial' => $data[0]['pathCompleto']));
            }
    }
    public function uploadStatus() {
        print_r($_POST);
        die();
        $this->_aEstadoOper['status'] = $this->input->post('status');
        $this->_aEstadoOper['message'] = $this->input->post('message');
        echo $this->input->post('message');
        $this->listado($this->input->post('padreCursoMaterial'));
    }
}