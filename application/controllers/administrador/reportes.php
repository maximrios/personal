
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package Sigep
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
class Reportes extends Ext_crud_controller {
    private $_aTemas = array();
    private $_rsRegs = array();
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/actuaciones_model', 'actuaciones');
        $this->load->model('sigep/pases_model', 'pases');
        $this->load->library('hits/gridview');
        $this->_aReglas = array(
            array(
                'field' => 'idActuacionPase',
                'label' => 'Pase',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idActuacion',
                'label' => 'Actuacion',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'foliosActuacionPase',
                'label' => 'Folios',
                'rules' => 'trim|xss_clean|integer|required'
            ),
            array(
                'field' => 'fechaEnvioActuacionPase',
                'label' => 'Fecha de envío',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'fechaRecepcionActuacionPase',
                'label' => 'Fecha de Recepción',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idOrigen',
                'label' => 'Origen',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idDestino',
                'label' => 'Destino',
                'rules' => 'trim|xss_clean|required|is_natural_no_zero'
            ),
            array(
                'field' => 'observacionActuacionPase',
                'label' => 'Observaciones',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idPaseEstado',
                'label' => 'Estado de Pase',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idTipoPase',
                'label' => 'Motivo de pase',
                'rules' => 'trim|xss_clean|required|is_natural_no_zero'
            ),
            array(
                'field' => 'idUsuarioRemitente',
                'label' => 'Usuario Remitente',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idUsuarioRecepcion',
                'label' => 'Usuario Destinatario',
                'rules' => 'trim|xss_clean'
            ),
        );
        $this->_aReglasRecepcion = array(
            array(
                'field' => 'idActuacionPase',
                'label' => 'Pase',
                'rules' => 'trim|xss_clean|required'
            ),
        );
    }
    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idActuacionPase' => null
            , 'idActuacion' => null
            , 'numeroActuacionPase' => null
            , 'foliosActuacionPase' => null
            , 'idTipoPase' => null
            , 'fechaEnvioActuacionPase' => date('Y-m-d H:i:s')
            , 'fechaRecepcionActuacionPase' => null
            , 'idEstructuraOrigen' => null
            , 'nombreOrigen' => null
            , 'idDestino' => null
            , 'nombreDestino' => null
            , 'observacionActuacionPase' => null
            , 'idPaseEstado' => null
            , 'idUsuarioEnvio' => null
            , 'idUsuarioRecepcion' => null
        );
        $inId = ($this->input->post('idActuacionPase') !== false) ? $this->input->post('idActuacionPase') : 0;
        $idActuacion = ($this->input->post('idActuacion') !== false) ? $this->input->post('idActuacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->pases->obtenerUno($inId);
        } 
        else {
            $this->_reg = array(
                'idActuacionPase' => $inId
                , 'idActuacion' => $this->input->post('idActuacion')
                , 'numeroActuacionPase' => $this->input->post('numeroActuacionPase')
                , 'foliosActuacionPase' => $this->input->post('foliosActuacionPase')
                , 'idTipoPase' => set_value('idTipoPase')
                , 'fechaEnvioActuacionPase' => ($this->input->post('fechaEnvioActuacionPase'))? set_value('fechaEnvioActuacionPase'):date('Y-m-d H:i:s')
                , 'fechaRecepcionActuacionPase' => ($this->input->post('fechaRecepcionActuacionPase') === FALSE) ? GetToday('d/m/Y') : set_value('fechaRecepcionActuacionPase')
                , 'idOrigen' => set_value('idOrigen')
                , 'nombreOrigen' => $this->ubicacion->nombreEstructura()
                , 'idDestino' => set_value('idDestino')
                , 'nombreDestino' => $this->input->post('nombreDestino')
                , 'observacionActuacionPase' => $this->input->post('observacionActuacionPase')
                , 'idPaseEstado' => ($this->input->post('idPaseEstado'))? set_value('idPaseEstado'):1
                , 'idUsuarioOrigen' => $this->autenticacion->idUsuario()
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function index() {
        $this->_content = $this->load->view('admin/reportes/principal', array(), true);
        $this->_menu = menu_ul('reportes');
        parent::index();
    }
    public function consulta() {
        $tipo = ($this->autenticacion->idMesaEstructura() == 30)? 2:1;
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras(1);
        $aData['tipos'] = $this->actuaciones->dropdownTipos();
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        $aData['vcFrmAction'] = 'reportes/buscar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/reportes/consulta', $aData);
    }
    public function buscar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasBusqueda();
        if ($this->_validarReglas()) {
            $this->_inicRegBusqueda((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = count($this->pases->obtenerBuscador($this->_reg));
            if($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'La búsqueda se realizó con éxito. En total se econtraron '.$this->_aEstadoOper['status'].' resultados';    
                $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }
        $this->listado();
    }
    public function comprobante($idPase) {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['pase'] = $this->pases->obtenerUno($idPase);
        $aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        $aData['actuacion']['foliosActuacion'] = $this->pases->obtenerFolios($aData['actuacion']['idActuacion']);
        $this->load->view('admin/pases/comprobante', $aData);
    }
}
?>