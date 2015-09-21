<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Usuarios extends Ext_crud_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->model('admin/personas_model', 'personas');
        $this->load->model('sigep/agentes_model', 'agentes');
        $this->load->model('sigep/cuadrocargosagentes_model', 'cuadrocargosagentes');
        $this->load->model('sigep/cargos_model', 'cargo');
        $this->load->model('sigep/layout_model', 'layout');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->_aReglas = array(
            array(
                'field' => 'idUsuario',
                'label' => 'Codigo',
                'rules' => 'trim|xss_clean|required'
            )
            ,array(
                'field' => 'passwordUsuario',
                'label' => 'Contraseña',
                'rules' => 'trim|required|max_length[15]|min_length[6]|xss_clean'
            )
            ,array(
                'field' => 'npasswordUsuario',
                'label' => 'Nueva contraseña',
                'rules' => 'trim|required|xss_clean|max_length[15]|min_length[6]|matches[rnpasswordUsuario]'
            )

            ,array(
                'field' => 'rnpasswordUsuario',
                'label' => 'Repetir nueva contraseña',
                'rules' => 'trim|required|xss_clean|max_length[15]|min_length[6]'
            )   
        );
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
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
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
    }
    public function listado($idAgente = 0) {
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
    function resetpassword() {
        $aData['vcFrmName'] = 'formChangePassword';
        $aData['vcFrmAction'] = 'setpassword';
        $this->_content = $this->load->view('admin/usuarios/formulario', $aData, true);
        $this->_menu = menu_ul('inicio');
        parent::index();
    }
    function setpassword() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $usuario = $this->usuarios->getUserByIdPassword($this->input->post('idUsuario'), $this->input->post('passwordUsuario'));
            if($usuario) {
                $this->_aEstadoOper['status'] = $this->usuarios->setPassword(
                    array( $this->input->post('passwordUsuario')
                        , $this->input->post('idUsuario')
                    )
                );    
            }
            else {
                $this->_aEstadoOper['status'] = 0;
            }
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