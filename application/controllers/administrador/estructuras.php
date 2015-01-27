<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Estructuras extends Ext_crud_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->load->library('hits/Nested_set', array(), 'estructuras');
        $this->estructuras->setControlParams(
        	'sigep_estructuras'
        	, 'leftEstructura'
        	, 'rightEstructura'
        	, 'idEstructura'
        	, 'parentEstructura'
        	, 'nombreEstructura'
        );
        $this->_aReglas = array(
            array(
                'field' => 'idEstructura',
                'label' => 'Codigo',
                'rules' => 'trim|xss_clean'
            )
            ,array(
                'field' => 'nombreEstructura',
                'label' => 'Nombre',
                'rules' => 'trim|required|max_length[255]|min_length[7]|xss_clean'
            )
            ,array(
                'field' => 'parentEstructura',
                'label' => 'Estructura padre',
                'rules' => 'trim|required|xss_clean'
            )
        );
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idEstructura' => null
            , 'nombreEstructura' => null
            , 'parentEstructura' => null
        );
        $id = ($this->input->post('idEstructura')!==false)? $this->input->post('idEstructura'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->estructura->obtenerUno($id);
        } 
        else {
            $this->_reg = array(
                'idEstructura' => $id
                ,'nombreEstructura' => set_value('nombreEstructura')
                ,'parentEstructura' => set_value('parentEstructura')
            );          
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    function index() {
        $this->_content = $this->load->view('admin/estructuras/principal', array(), true);
        $this->_menu = menu_ul('estructuras');
        parent::index();
    }
    function dashboard() {
        $this->_content = $this->load->view('admin/agentes/dashboard', array(), true);
        $this->_menu = menu_ul('inicio');
        parent::index();
        ///$this->load->view('admin/agentes/dashboard');
    }
    function perfil() {
        if(!$this->input->post('idPersona')) {
            $data['persona'] = $this->persona->obtenerUnoDni($this->session->userdata('idPersona'));
            $data['main_content'] = 'administrator/personas/perfil';
            $this->load->view('administrator/template', $data);
        }
    }
    function cumpleanos($persona) {
        if(count($this->layout_model->cumpleanos($persona)) > 0) {
            $data['cumpleanero'] = $this->agente->obtenerDni($persona);
            $this->load->view('administrator/personas/cumpleano', $data);
            //$data['main_content'] = 'administrator/personas/cumpleano';
            //$this->load->view('administrator/template', $data);
        }
        else {
            echo "si no es el cumpleanos para que jodes";
        }
    }
    function calendarioCumpleanos() {
        /*if(count($this->layout_model->cumpleanos($persona)) > 0) {
            $data['cumpleanero'] = $this->agente->obtenerDni($persona);
            $this->load->view('administrator/personas/cumpleano', $data);
            //$data['main_content'] = 'administrator/personas/cumpleano';
            //$this->load->view('administrator/template', $data);
        }
        else {
            echo "si no es el cumpleanos para que jodes";
        }*/
        
    }
    public function listado($idEstructura = 1) {
        $vcBuscar = ($this->input->post('buscarGridview') === FALSE) ? '' : $this->input->post('buscarGridview');
        $filtro = ($vcBuscar)? ': "'.$vcBuscar.'" | <a href="agentes">ver todos</a>':'';
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'estructuras/listado'
                    , 'iTotalRegs' => $this->estructura->numRegs($vcBuscar, $this->input->post('idEstructura'), $this->input->post('idCargo'))
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Estructura SIGEP '.$filtro
                    , 'buscador' => TRUE
                    , 'identificador' => 'idEstructura'
                )
        );
        if($this->autenticacion->idRol() == 1) {
            $this->gridview->addColumn('idEstructura', '#', 'int');
        }
        $this->gridview->addColumn('nombreEstructura', 'Apellido Agente', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $ver = '<a href="#" ic-post-to="estructuras/formulario/{idEstructura}" ic-target="#main_content" title="Ver detalle de {nombreEstructura}" class="icono-gridview" rel="{\'idEstructura\': {idEstructura}}"><span class="glyphicon glyphicon-search"></span></a>';
        $listado = '<a href="#" ic-post-to="estructuras/listado/{idEstructura}" ic-target="#main_content" title="Ver estructuras dependientes de {nombreEstructura}" class="icono-gridview" rel="{\'idEstructura\': {idEstructura}}"><span class="glyphicon glyphicon-list-alt"></span></a>';
        $tamano = '65';
        $acciones = $ver.$listado;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        $padre = $this->estructuras->getNodeFromId($idEstructura);
        $this->_rsRegs = $this->estructuras->getTreePreorder($padre, true);
        $this->load->view('admin/estructuras/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idEstructura' => $idEstructura
                , 'cargo' => $this->input->post('idCargo')
            )
        );
    }
    function consulta() {
        echo "macondo";
    }
    function buscador() {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/agentes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idAgente'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/agentes/buscador', $aData);
    }
    function formulario($idPadre, $idEstructura = 0) {
        if($idEstructura != 0) {
            $aData['Reg'] = $this->estructuras->getNodeFromId($idEstructura);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
            $aData['Reg']['parentEstructura'] = $idPadre;
        }
        $aData['vcFrmAction'] = 'estructuras/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/estructuras/formulario', $aData);
    }
    function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->agentes->guardar(
                array( $this->_reg['idPersona']
                    , $this->_reg['idTipoDni']
                    , $this->_reg['dniPersona']
                    , $this->_reg['apellidoPersona']
                    , $this->_reg['nombrePersona']
                    , $this->_reg['cuilPersona']
                    , GetDateTimeFromFrenchToISO($this->_reg['nacimientoPersona'])
                    , $this->_reg['idSexo']
                    , $this->_reg['idEcivil']
                    , $this->_reg['domicilioPersona']
                    , $this->_reg['telefonoPersona']
                    , $this->_reg['celularPersona']
                    , $this->_reg['emailPersona']
                    , $this->_reg['laboralPersona']
                    , $this->_reg['idAgente']
                    , GetDateTimeFromFrenchToISO($this->_reg['ingresoAgenteAPP'])
                    , GetDateTimeFromFrenchToISO($this->_reg['ingresoAgenteSIGEP'])
                    , $this->_reg['internoAgente']
                    , $this->autenticacion->idUsuario()
                )
            );
            if($this->_aEstadoOper['status'] > 0) {
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
        //Lo que sigue a continuacion deberia de ir dentro de un if que controle las validaciones
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        if($this->_aEstadoOper['status'] > 0) {
            $this->listado();
        } else {
            $this->formulario();
        }
    }
    function buscar() {
        $registro = $this->_inicReg(false);
        
        if($this->input->post('buscar_persona')) {

        }
        else {
            redirect('administrator/home');
        }
    }
    function baja($agente=false) {
        if($agente) {
            $aData['Reg'] = $this->agentes->obtenerUno($agente);
            $aData['Reg']['nacimientoPersona'] = GetDateFromISO($aData['Reg']['nacimientoPersona']);
            $aData['motivos'] = $this->agentes->dropdownAgentesAntecedentes();
            $aData['sexos'] = $this->sexos;
            $aData['vcFrmAction'] = 'agentes/eliminar';
            $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
            $this->load->view('admin/agentes/baja', $aData);
        }
        else {
            $this->listado();
        }
    }
    function eliminar() {
        $noticia = $this->noticias->obtenerUno($noticia);
        if($noticia) {
            $this->_aEstadoOper['status'] = $this->noticias->eliminar($noticia['idNoticia']);
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se eliminó la noticia correctamente.';
            } 
            else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        }
        else {
            $this->_aEstadoOper['message'] = 'Ocurrió un error al eliminar la noticia. Consulte con el administrador del sistema.';
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        $this->listado();
    }
    function eliminarbash($idAgente) {
        $this->load->model('admin/personas', 'personas');
        $agente = $this->agentes->obtenerUno($idAgente);
        if($agente) {
            $this->_aEstadoOper['status'] = $this->agentes->definitivo($idAgente);
            $this->_aEstadoOper['status'] = $this->personas->definitivo($agente['idPersona']);
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se eliminó el agente correctamente.';
            } 
            else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        }
        else {
            $this->_aEstadoOper['message'] = 'Ocurrió un error al eliminar la noticia. Consulte con el administrador del sistema.';
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        $this->listado();
    }
    function exportar() {
        $this->load->library('hits/export', array(), 'export');
        $this->_rsRegs = $this->agente->obtener('', $this->input->post('idEstructura'), $this->input->post('idCargo'), 0, 999);
        print_r($this->_rsRegs);
        //$this->export->to_excel($this->_rsRegs, 'nameForFile1'); 
    }
    function planilla() {
        $this->config->set_item('page_orientation', 'L');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['agentes'] = $this->agente->obtener('');
        $this->load->view('administrator/sigep/agentes/plantilla', $aData);
    }
    function plantilla($idAgente) {
        $this->config->set_item('page_orientation', 'L');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['agentes'][] = $this->agente->obtenerUno($idAgente);
        if($aData['agentes']) {
            //$aData['cuadrocargosagentes'] = $this->cuadrocargosagentes->obtenerCuadroCargoAgente($idAgente);
        }
        $this->load->view('administrator/sigep/agentes/plantilla', $aData);
    }
    public function _dni_unico($nombre) {
        if($this->input->post('idPersona') == 0) {
            $agente = $this->agentes->obtenerDni($nombre);
            if($agente) {
                $this->form_validation->set_message('_dni_unico', 'El %s ya existe en nuestra base de datos.');
                return FALSE;
            }
            else {
                return TRUE;
            }    
        }
        else {
            return TRUE;
        }
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */