<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Licencias extends Ext_crud_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->model('admin/personas_model', 'personas');
        $this->load->model('sigep/agentes_model', 'agentes');
        $this->load->model('sigep/licencias_model', 'licencias');
        $this->load->model('sigep/cuadrocargosagentes_model', 'cuadrocargosagentes');
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->model('sigep/layout_model', 'layout');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->estados = $this->personas->dropdownEstadoCivil();
        $this->sexos = $this->personas->dropdownSexo();
        $this->_aReglas = array(
            array(
                'field' => 'idAgenteLicencia',
                'label' => 'Codigo',
                'rules' => 'trim|xss_clean'
            )
            ,array(
                'field' => 'idAgente',
                'label' => 'Agente',
                'rules' => 'trim|required|xss_clean'
            )
            ,array(
                'field' => 'idLicencia',
                'label' => 'Licencia',
                'rules' => 'trim|required|xss_clean'
            )
            ,array(
                'field' => 'desdeAgenteLicencia',
                'label' => 'Desde',
                'rules' => 'trim|required|xss_clean'
            )   
            ,array(
                'field' => 'hastaAgenteLicencia',
                'label' => 'Hasta',
                'rules' => 'trim|required|xss_clean|callback__comprobar'
            )  
        );
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idAgenteLicencia' => null
            , 'idAgente' => null
            , 'idLicencia' => null
            , 'desdeAgenteLicencia' => null
            , 'hastaAgenteLicencia' => null
        );
        $id = ($this->input->post('idAgente')!==false)? $this->input->post('idAgente'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->agentes->obtenerUno($id);
            $this->_reg['desdeAgenteLicencia'] = GetDateFromISO($this->_reg['desdeAgenteLicencia'], FALSE);
            $this->_reg['hastaAgenteLicencia'] = GetDateFromISO($this->_reg['hastaAgenteLicencia'], FALSE);
        } 
        else {
            $this->_reg = array(
                'idAgenteLicencia' => set_value('idAgenteLicencia')
                ,'idAgente' => set_value('idAgente')
                ,'idLicencia' => set_value('idLicencia')
                , 'desdeAgenteLicencia' => set_value('desdeAgenteLicencia')
                , 'hastaAgenteLicencia' => set_value('hastaAgenteLicencia')
            );          
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    function index() {
        $this->_content = $this->load->view('admin/licencias/principal', array(), true);
        $this->_menu = menu_ul('licencias');
        parent::index();
    }
    public function listado($idAgente = 0) {
        $vcBuscar = ($this->input->post('buscarGridview') === FALSE) ? '' : $this->input->post('buscarGridview');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'licencias/listado'
                    , 'iTotalRegs' => $this->licencias->numRegs($vcBuscar, $this->input->post('idEstructura'), $this->input->post('idCargo'))
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de licencias vigentes '.$vcBuscar
                    , 'buscador' => TRUE
                    , 'identificador' => 'idAgente'
                )
        );
        if($this->autenticacion->idRol() == 1) {
            $this->gridview->addColumn('idAgente', '#', 'int');
        }
        //$this->gridview->addControl('inputGrid', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        $this->gridview->addColumn('nombreCompletoPersona', 'Nombre Agente', 'text');
        $this->gridview->addColumn('nombreLicencia', 'Licencia', 'text');
        $this->gridview->addColumn('desdeAgenteLicencia', 'F. Desde', 'date');
        $this->gridview->addColumn('hastaAgenteLicencia', 'F. Hasta', 'date');
        $this->gridview->addColumn('retornoAgenteLicencia', 'F. Retorno', 'date');
        $this->gridview->addColumn('cantidadAgenteLicencia', 'Usuf.', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="#" ic-post-to="licencias/formulario/{idAgenteLicencia}" ic-target="#main_content" title="Editar licencia de {nombreCompletoPersona}" class="icono-gridview" rel="{\'idAgenteLicencia\': {idAgenteLicencia}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $baja = '<a href="#" ic-post-to="agentes/eliminarbash/{idAgente}" ic-target="#main_content" title="Dar de baja a {apellidoPersona}" class="icono-gridview" rel="{\'idAgente\': {idAgente}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $tamano = '32';
        $acciones = $editar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        //$this->_rsRegs = $this->agentes->obtener($vcBuscar, $this->input->post('idEstructura'), $this->input->post('idCargo'), $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->_rsRegs = $this->licencias->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/licencias/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'estructura' => $this->input->post('idEstructura')
                , 'cargo' => $this->input->post('idCargo')
                , 'licencias' => $this->licencias->obtenerLicencias()
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
    function agente($idAgente) {
        $this->load->view('admin/licencias/agente', array());
    }
    function formulario($agente=null) {
        if($agente) {
            $aData['Reg'] = $this->licencias->obtenerUno($agente);
            $aData['Reg']['desdeAgenteLicencia'] = GetDateFromISO($aData['Reg']['desdeAgenteLicencia']);
            $aData['Reg']['hastaAgenteLicencia'] = GetDateFromISO($aData['Reg']['hastaAgenteLicencia']);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        }
        $aData['agentes'] = $this->agentes->dropdownAgentes();
        $aData['licencias'] = $this->licencias->dropdownLicencias();
        $aData['vcFrmAction'] = 'licencias/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/licencias/formulario', $aData);
    }
    function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $calculo = $this->calendar->micosis(GetDateTimeFromFrenchToISO($this->_reg['desdeAgenteLicencia']), GetDateTimeFromFrenchToISO($this->_reg['hastaAgenteLicencia']));
            $this->_aEstadoOper['status'] = $this->licencias->guardar(
                array( $this->_reg['idAgenteLicencia']
                    , $this->_reg['idAgente']
                    , $this->_reg['idLicencia']
                    , $calculo['usufructuados']
                    , GetDateTimeFromFrenchToISO($this->_reg['desdeAgenteLicencia'])
                    , GetDateTimeFromFrenchToISO($this->_reg['hastaAgenteLicencia'])
                    , $calculo['retorno']
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
    public function _comprobar($hasta) {
        $this->load->library('hits/Calendar', array(), 'calendar');
        $miedo = $this->calendar->micosis(GetDateTimeFromFrenchToISO($this->input->post('desdeAgenteLicencia')), GetDateTimeFromFrenchToISO($hasta));
        $totalsc = 0;
        $licencia = $this->licencias->obtenerUnoLicencia($this->input->post('idLicencia'));
        $usufructuados = $this->licencias->usufructuados($this->input->post('idAgente'), $licencia['idLicencia'], $this->input->post('idAgenteLicencia'));
        $total = $usufructuados + $miedo['usufructuados'];
        $totalsc = $licencia['diasLicencia'] - $total;
        if($totalsc < 0) {
            $this->form_validation->set_message('_comprobar', 'La cantidad de días solicitados sumado a los días usufructuados para el agente y el tipo de licencia, exceden el maximo permitido por el Decreto 4118/97.');
                return FALSE;
        }
        else {
            return TRUE;
        }
    }
}

/* End of file personas.php */
/* Location: ./application/controllers/administrator/personas.php */