<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Agentes extends Ext_crud_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->model('admin/personas_model', 'personas');
        $this->load->model('sigep/agentes_model', 'agentes');
        $this->load->model('sigep/cuadrocargosagentes_model', 'cuadrocargosagentes');
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->model('sigep/layout_model', 'layout');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->estados = $this->personas->dropdownEstadoCivil();
        $this->sexos = $this->personas->dropdownSexo();
        $this->_aReglas = array(
            array(
                'field' => 'idPersona',
                'label' => 'Codigo',
                'rules' => 'trim|xss_clean'
            )
            ,array(
                'field' => 'dniPersona',
                'label' => 'Numero de documento',
                'rules' => 'trim|required|max_length[8]|min_length[7]|xss_clean|callback__dni_unico'
            )
            ,array(
                'field' => 'idTipoDni',
                'label' => 'Tipo de documento',
                'rules' => 'trim|required|xss_clean'
            )
            ,array(
                'field' => 'apellidoPersona',
                'label' => 'Apellido',
                'rules' => 'trim|required|xss_clean|min_length[3]'
            )   
            ,array(
                'field' => 'nombrePersona',
                'label' => 'Nombre',
                'rules' => 'trim|required|xss_clean|min_length[3]'
            )  
            ,array(
                'field' => 'cuilPersona',
                'label' => 'Numero de Cuil',
                'rules' => 'trim|required|xss_clean|max_length[11]|min_length[11]'
            ) 
            ,array(
                'field' => 'nacimientoPersona',
                'label' => 'Fecha de nacimiento',
                'rules' => 'trim|required|xss_clean'
            )
            ,array(
                'field' => 'idEcivil',
                'label' => 'Estado civil',
                'rules' => 'trim|xss_clean|required'
            ) 
            ,array(
                'field' => 'idSexo',
                'label' => 'Sexo',
                'rules' => 'trim|xss_clean|required'
            ) 
            ,array(
                'field' => 'nacionalidadPersona',
                'label' => 'Nacionalidad de la Persona',
                'rules' => 'trim|xss_clean'
            )
            ,array(
                'field' => 'domicilioPersona',
                'label' => 'Domicilio de la Persona',
                'rules' => 'trim|xss_clean|max_length[80]|required'
            ) 
            ,array(
                'field' => 'telefonoPersona',
                'label' => 'Numero de telefono de la Persona',
                'rules' => 'trim|xss_clean|is_numeric'
            )
            ,array(
                'field' => 'celularPersona',
                'label' => 'Numero de celular de la Persona',
                'rules' => 'trim|xss_clean|is_numeric'
            )
            ,array(
                'field' => 'laboralPersona',
                'label' => 'Numero de Telefono Laboral',
                'rules' => 'trim|max_length[80]|xss_clean|is_numeric'
            )
            ,array(
                'field' => 'emailPersona',
                'label' => 'Correo electronico de la Persona',
                'rules' => 'trim|xss_clean|valid_email'
            )
            /*,array(
                'field'   => 'ingresoAgenteAPP',
                'label'   => 'Fecha de ingreso a la APP',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'ingresoAgenteSIGEP',
                'label'   => 'Fecha de ingreso a la SIGEP',
                'rules'   => 'trim|xss_clean|required'
            )*/
            ,array(
                'field'   => 'internoAgente',
                'label'   => 'Numero de interno',
                'rules'   => 'trim|xss_clean'
            )
        );
        $this->_aReglasBaja = array(
            array(
                'field'   => 'idMotivoAntecedente',
                'label'   => 'Motivo de antecedente',
                'rules'   => 'trim|xss_clean'
            )
            ,array(
                'field'   => 'idAgente',
                'label'   => 'Agente',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'desdeMotivoAntecedente',
                'label'   => 'Fecha desde antecedente',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'hastaMotivoAntecedente',
                'label'   => 'Fecha hasta antecedente',
                'rules'   => 'trim|xss_clean|required'
            )
            ,array(
                'field'   => 'observacionesMotivoAntecedente',
                'label'   => 'Fecha hasta antecedente',
                'rules'   => 'trim|xss_clean|required'
            )
        );
        /*$this->_aBuscar = array(
            array(
                'field'   => 'vcBuscar',
                'label'   => 'Buscar por texto',
                'rules'   => 'trim|required|xss_clean|min_length[3]|max_length[50]|callback_onlySearch'
            )
        );*/
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idPersona' => null
            , 'idTipoDni' => null
            , 'dniPersona' => null
            , 'apellidoPersona' => null
            , 'nombrePersona' => null
            , 'cuilPersona' => null
            , 'nacimientoPersona' => null
            , 'idSexo' => null
            , 'idEcivil' => null
            , 'nacionalidadPersona' => null
            , 'domicilioPersona' => null
            , 'telefonoPersona' => null
            , 'celularPersona' => null
            , 'emailPersona' => null
            , 'laboralPersona' => null
            , 'pathPersona' => null
            , 'idAgente' => null
            , 'ingresoAgenteAPP' => null
            , 'ingresoAgenteSIGEP' => null
            , 'internoAgente' => null
        );
        $id = ($this->input->post('idAgente')!==false)? $this->input->post('idAgente'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->agentes->obtenerUno($id);
            $this->_reg['nacimientoPersona'] = GetDateFromISO($this->_reg['nacimientoPersona'], FALSE);
            $this->_reg['ingresoAgenteAPP'] = GetDateFromISO($this->_reg['ingresoAgenteAPP'], FALSE);
            $this->_reg['ingresoAgenteSIGEP'] = GetDateFromISO($this->_reg['ingresoAgenteSIGEP'], FALSE);
        } 
        else {
            $this->_reg = array(
                'idPersona' => set_value('idPersona')
                ,'idTipoDni' => set_value('idTipoDni')
                , 'dniPersona' => set_value('dniPersona')
                , 'apellidoPersona' => set_value('apellidoPersona')
                , 'nombrePersona' => set_value('nombrePersona')
                , 'cuilPersona' => set_value('cuilPersona')
                , 'nacimientoPersona' => set_value('nacimientoPersona')
                , 'idSexo' => set_value('idSexo')
                , 'idEcivil' => set_value('idEcivil')
                , 'nacionalidadPersona' => set_value('nacionalidadPersona')
                , 'domicilioPersona' => set_value('domicilioPersona')
                , 'telefonoPersona' => set_value('telefonoPersona')
                , 'celularPersona' => set_value('celularPersona')
                , 'emailPersona' => set_value('emailPersona')
                , 'laboralPersona' => set_value('laboralPersona')
                , 'pathPersona' => set_value('pathPersona')
                , 'idAgente' => $id
                , 'ingresoAgenteAPP' => set_value('ingresoAgenteAPP')
                , 'ingresoAgenteSIGEP' => set_value('ingresoAgenteSIGEP')
                , 'internoAgente' => set_value('internoAgente')
            );          
        }
        return $this->_reg;
    }
    protected function _inicRegBaja($boIsPostBack=false) {
        $this->_reg = array(
            'idMotivoAntecedente' => null
            , 'desdeMotivoAntecedente' => null
            , 'hastaMotivoAntecedente' => null
            , 'observacionesMotivoAntecedente' => null
            , 'dniPersona' => null
            , 'nombrePersona' => null
            , 'apellidoPersona' => null
            , 'idAgente' => null
        );
        $id = ($this->input->post('idAgente')!==false)? $this->input->post('idAgente'):0;
        if($id!=0 && !$boIsPostBack) {
            $this->_reg = $this->agentes->obtenerUno($id);
            $this->_reg['nacimientoPersona'] = GetDateFromISO($this->_reg['nacimientoPersona'], FALSE);
            $this->_reg['ingresoAgenteAPP'] = GetDateFromISO($this->_reg['ingresoAgenteAPP'], FALSE);
            $this->_reg['ingresoAgenteSIGEP'] = GetDateFromISO($this->_reg['ingresoAgenteSIGEP'], FALSE);
        } 
        else {
            $this->_reg = array(
                'idPersona' => set_value('idPersona')
                ,'idTipoDni' => set_value('idTipoDni')
                , 'dniPersona' => set_value('dniPersona')
                , 'apellidoPersona' => set_value('apellidoPersona')
                , 'nombrePersona' => set_value('nombrePersona')
                , 'cuilPersona' => set_value('cuilPersona')
                , 'nacimientoPersona' => set_value('nacimientoPersona')
                , 'idSexo' => set_value('idSexo')
                , 'idEcivil' => set_value('idEcivil')
                , 'nacionalidadPersona' => set_value('nacionalidadPersona')
                , 'domicilioPersona' => set_value('domicilioPersona')
                , 'telefonoPersona' => set_value('telefonoPersona')
                , 'celularPersona' => set_value('celularPersona')
                , 'emailPersona' => set_value('emailPersona')
                , 'laboralPersona' => set_value('laboralPersona')
                , 'pathPersona' => set_value('pathPersona')
                , 'idAgente' => $id
                , 'ingresoAgenteAPP' => set_value('ingresoAgenteAPP')
                , 'ingresoAgenteSIGEP' => set_value('ingresoAgenteSIGEP')
                , 'internoAgente' => set_value('internoAgente')
            );          
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    protected function _inicReglasBaja() {
        $val = $this->form_validation->set_rules($this->_aReglasBaja);
    }
    function index() {
        $this->_content = $this->load->view('admin/agentes/principal', array(), true);
        $this->_menu = menu_ul('agentes');
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
    public function listado($idAgente = 0) {
        //$estructuras = $this->estructura->dropdownEstructuras();
        //$cargos = $this->cargo->dropdownCargosFiltro();
        $vcBuscar = ($this->input->post('buscarGridview') === FALSE) ? '' : $this->input->post('buscarGridview');
        $filtro = ($vcBuscar)? ': "'.$vcBuscar.'" | <a href="agentes">ver todos</a>':'';
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'agentes/listado'
                    , 'iTotalRegs' => $this->agentes->numRegs($vcBuscar, $this->input->post('idEstructura'), $this->input->post('idCargo'))
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'border' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Agentes '.$filtro
                    , 'buscador' => TRUE
                    , 'identificador' => 'idAgente'
                )
        );
        if($this->autenticacion->idRol() == 1) {
            $this->gridview->addColumn('idAgente', '#', 'int');
        }
        //$this->gridview->addControl('inputGrid', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        $this->gridview->addColumn('apellidoPersona', 'Apellido Agente', 'text');
        $this->gridview->addColumn('nombrePersona', 'Nombre Agente', 'text');
        //$this->gridview->addColumn('nombreCompletoPersona', 'Nombre Agente', 'text');
        //$this->gridview->addColumn('denominacionCargo', 'Cargo', 'text');
        //$this->gridview->addColumn('nombreArea', 'Area', 'text');
        $this->gridview->addColumn('emailPersona', 'Email', 'text');
        $this->gridview->addColumn('internoAgente', 'Interno', 'int');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $ver = '<a href="administrator/reportes/especial/{idAgente}" target="_blank" title="Imprimir reporte de licencia especial {nombrePersona}" class="icono-usuario" rel="{\'idAgente\': {idAgente}}">&nbsp;</a>'; 
        $editar = '<a href="#" ic-post-to="agentes/formulario/{idAgente}" ic-target="#main_content" title="Editar {apellidoPersona}" class="icono-gridview" rel="{\'idAgente\': {idAgente}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $baja = '<a href="#" ic-post-to="agentes/eliminarbash/{idAgente}" ic-target="#main_content" title="Dar de baja a {apellidoPersona}" class="icono-gridview" rel="{\'idAgente\': {idAgente}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $planilla = '<a href="administrator/agentes/plantilla/{idAgente}" title="Imprimir planilla de {apellidoPersona}" target="_blank" class="icono-gridview" rel="{\'idAgente\': {idAgente}}"><span class="glyphicon glyphicon-print"></span></a>';
        $tamano = '65';
        $acciones = $editar.$baja;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:'.$tamano.'px;'));
        //$this->_rsRegs = $this->agentes->obtener($vcBuscar, $this->input->post('idEstructura'), $this->input->post('idCargo'), $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->_rsRegs = $this->agentes->obtener($vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/agentes/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'estructura' => $this->input->post('idEstructura')
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
    function formulario($agente=null) {
        if($agente) {
            $aData['Reg'] = $this->agentes->obtenerUno($agente);
            $aData['Reg']['nacimientoPersona'] = GetDateFromISO($aData['Reg']['nacimientoPersona']);
            //$aData['Reg']['fechaHastaEvento'] = GetDateFromISO($aData['Reg']['fechaHastaEvento']);
        }
        else {
            $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        }

        $aData['estados'] = $this->estados;
        $aData['sexos'] = $this->sexos;
        /*$aData['paises'] = $this->_paises;
        $aData['provincias'] = $this->_provincias;
        $aData['departamentos'] = $this->_departamentos;
        $aData['localidades'] = $this->_localidades;*/
        
        $aData['vcFrmAction'] = 'agentes/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        //$aData['vcAccion'] = ($this->_reg['idAgente'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/agentes/formulario', $aData);
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