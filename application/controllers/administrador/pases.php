<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package Sigep
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
class Pases extends Ext_crud_controller {
    private $_aTemas = array();
    private $_rsRegs = array();
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/actuaciones_model', 'actuaciones');
        $this->load->model('sigep/pases_model', 'pases');
        $this->load->library('hits/gridview');
        //$this->load->library('Messages');
        //$this->load->helper('utils_helper');
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
    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/actuaciones/pases/principal', array(), true);
        $this->_vcMenu = menu_ul('pases');
        parent::index();
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
    protected function _inicReglasRecepcion() {
        $val = $this->form_validation->set_rules($this->_aReglasRecepcion);
    }
    public function listado($idActuacion = 0) {
        $actuacion = $this->actuaciones->obtenerUno($idActuacion);
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/pases/listado'
                    , 'iTotalRegs' => $this->pases->numRegs($actuacion['idActuacion'], 0, 0, $vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Historial de Pases'
                    , 'buscador' => FALSE
                    , 'identificador' => 'idActuacion'
                )
        );
        $this->gridview->addColumn('idActuacionPase', '#', 'int');
        $this->gridview->addColumn('nombreOrigen', 'Area Remitente', 'text');
        $this->gridview->addColumn('nombreDestino', 'Area Destino', 'text');
        $this->gridview->addColumn('fechaEnvioActuacionPase', 'Fecha de envío', 'datetime');
        $this->gridview->addColumn('fechaRecepcionActuacionPase', 'Fecha de Recepción', 'datetime');
        $this->gridview->addColumn('nombrePaseEstado', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $print = '<a href="pases/comprobante/{idActuacionPase}" target="_blank" title="Imprimir Pase" class="" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-print"></span></a>';
        $generar = '<a href="administrator/pases/formulario/{idActuacionPase}" title="Eliminar Pase" class="btn-accion" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-share-alt"></span></a>';
        $acciones = $print;

        
        $this->gridview->addControl('idActuacionPaseCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:32px;'));
        //$this->_rsRegs = $this->pases->obtener($actuacion['idActuacion'], $this->lib_autenticacion->idMesaEstructura(), 2, $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        
        $this->_rsRegs = $this->pases->obtener($actuacion['idActuacion'], 0, 0, $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/pases/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idActuacion' => $this->input->post('idActuacion')
            )
        );
    }
    public function ppendientes() {
        $this->_content = $this->load->view('admin/pases/ppendientes', array(), true);
        $this->_menu = menu_ul('pendientes');
        parent::index();
    }
    public function pendientes() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/pases/listado'
                    , 'iTotalRegs' => $this->pases->numRegs(0, $this->autenticacion->idMesaEstructura(), 4, 2, $vcBuscar, TRUE)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Actuaciones pendientes de trámite'
                    , 'buscador' => false
                    , 'identificador' => 'idActuacionPase'
                )
        );
        $this->gridview->addColumn('codigoActuacion', 'N° de Actuación SGA (SIGEP)', 'text');
        $this->gridview->addColumn('fechaCreacionActuacion', 'Fecha de creación SGA', 'date');
        $this->gridview->addColumn('referenciaActuacion', 'N° de Actuación SICE', 'text');
        $this->gridview->addColumn('fechaCreacionSICE', 'Fecha de creación SICE', 'date');
        $this->gridview->addColumn('caratulaActuacion', 'Caratula', 'tinyText');
        $this->gridview->addColumn('nombreOrigen', 'Area | Organismo de origen', 'text');
        $this->gridview->addColumn('nombreActuacionPaseTipo', 'Motivo de Pase', 'text');
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $recibir = '<a href="administrator/pases/recepcion/{idActuacionPase}" title="Recibir Pase N° {idActuacionPase}" class="btn-accion" rel="{\'idActuacionPase\': {idActuacionPase}}"><span class="glyphicon glyphicon-download-alt"></span></a>';
        $pasar = '<a href="#" ic-post-to="formulario/{idActuacion}" ic-target="#main_content" title="Generar Pase" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-share-alt"></span></a>';
        $acciones = $pasar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:40px;'));
        $this->_rsRegs = $this->pases->obtener(0, $this->autenticacion->idMesaEstructura(), 4, 2, $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2(), TRUE);
        $this->load->view('admin/pases/tramite'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idActuacion' => $this->input->post('idActuacion')
            )
        );
    }
    public function recepcion($idActuacionPase) {
        $aData['pase'] = $this->pases->obtenerUno($idActuacionPase);
        $aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        if($aData['pase']) {
            $this->load->view('admin/pases/recepcion', $aData);
        }
        else {
            $this->pendientes();
        }
    }
    public function recibir() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasRecepcion();
        if ($this->_validarReglas()) {
            $this->_aEstadoOper['status'] = $this->pases->recibir(
                    array(
                        $this->input->post('idActuacionPase')
                        , 2
                        , date('Y-m-d H:i:s')
                        , $this->autenticacion->idUsuario()
                        , $this->input->post('idActuacion')
                        , $this->autenticacion->idMesaEstructura()
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Se recibió el pase correctamente.';
            }
             else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->pbandeja();
        } 
        else {
            $this->recepcion($this->input->post('idActuacionPase'));
        }
    }
    public function bandeja() {
        $this->_content = $this->load->view('admin/pases/bandeja', array(), true);
        $this->_menu = menu_ul('bandeja');
        parent::index();
    }
    public function pbandeja() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrador/pases/listado'
                    , 'iTotalRegs' => $this->pases->numRegs(0, $this->autenticacion->idMesaEstructura(), 1, 1, $vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Pases pendientes de recepción'
                    , 'buscador' => false
                    , 'identificador' => 'idActuacionPase'
                )
        );

        $this->gridview->addColumn('codigoActuacion', 'N° de Actuación SGA (SiGeP)', 'text');
        $this->gridview->addColumn('fechaCreacionActuacion', 'Fecha de creación SGA', 'date');
        $this->gridview->addColumn('referenciaActuacion', 'N° de Actuación SICE', 'text');
        $this->gridview->addColumn('fechaCreacionSICE', 'Fecha de creación SICE', 'date');
        $this->gridview->addColumn('caratulaActuacion', 'Caratula', 'tinyText');
        $this->gridview->addColumn('nombreOrigen', 'Area | Organismo de origen', 'text');
        $this->gridview->addColumn('nombreActuacionPaseTipo', 'Motivo de Pase', 'text');

        /*$this->gridview->addColumn('nombreOrigen', 'Origen', 'text');
        $this->gridview->addColumn('apellidoPersonaOrigen', 'Usuario', 'text', array('order' => TRUE));
        $this->gridview->addColumn('fechaEnvioActuacionPase', 'Envío', 'datetime');
        $this->gridview->addColumn('nombrePaseEstado', 'Estado', 'text', array('order' => TRUE));*/
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $recibir = '<a href="#" ic-post-to="recepcion/{idActuacionPase}" title="Recibir Pase N° {idActuacionPase}" class="btn-accion" rel="{\'idActuacionPase\': {idActuacionPase}}" ic-target="#main_content"><span class="glyphicon glyphicon-download-alt"></span></a>';
        $acciones = $recibir;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:40px;'));
        $this->_rsRegs = $this->pases->obtener(0, $this->autenticacion->idMesaEstructura(), 1, 1, $vcBuscar, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/pases/pendientes'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idActuacion' => $this->input->post('idActuacion')
            )
        );
    }
    public function pasar($idActuacion) {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['mesas'] = $this->pases->dropdownEstructurasMesas($this->lib_autenticacion->idMesaEstructura());
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['vcFrmAction'] = 'administrator/pases/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/pases/formulario', $aData);
    }
    public function actuaciones() {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $vcOrder = ($this->input->post('order') === FALSE) ? '' : $this->input->post('order');
        $state = 2;
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/actuaciones/listado'
                    , 'iTotalRegs' => $this->actuaciones->numRegs($vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Actuaciones'
                    , 'buscador' => TRUE
                    , 'identificador' => 'idActuacion'
                )
        );
        $this->gridview->addColumn('idActuacion', '#', 'int', array('order' => TRUE));
        $this->gridview->addColumn('codigoActuacion', 'Codigo', 'text');
        $this->gridview->addColumn('referenciaActuacion', 'Referencia', 'text');
        $this->gridview->addColumn('nombreActuacionTipo', 'Tipo', 'text');
        $this->gridview->addColumn('nombreActuacionTema', 'Tema', 'text', array('order' => TRUE));
        $this->gridview->addColumn('caratulaActuacion', 'Carátula', 'tinyText');
        $this->gridview->addColumn('nombreActuacionEstado', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $recepcion = '<a href="administrator/pases/preformulario/{idActuacion}" title="Generar Pase para la Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-share-alt"></span></a>';
        $acciones = $recepcion;

        
        $this->gridview->addControl('idActuacionCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:42px;'));
        $this->_rsRegs = $this->actuaciones->obtener($vcBuscar, 2, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/actuaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function preformulario($idPase) {
        $aData['pase'] = $this->pases->obtenerUno($idPase);
        $aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/pases/preformulario', $aData);
    }
    public function formulario($idActuacion) {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['tipos'] = $this->pases->dropdownTiposPases();
        $aData['mesas'] = $this->pases->dropdownEstructurasMesas($this->autenticacion->idMesaEstructura());
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['actuacion']['foliosActuacion'] = $this->pases->obtenerFolios($aData['actuacion']['idActuacion']);
        $aData['vcFrmAction'] = 'guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacionPase'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/pases/formulario', $aData);
    }
    public function consulta() {
        $this->load->view('lib_autenticacion/frm-faq-borrar'
                , array(
            'Reg' => $this->_inicReg($this->input->post('vcForm'))
            , 'vcFrmAction' => 'autenticacion/faq/eliminar'
            , 'vcMsjSrv' => $this->_aEstadoOper['message']
            , 'vcAccion' => ($this->_reg['inIdFaq'] > 0) ? 'Eliminar' : ''
                )
        );
    }
    function ver($noticia) {
        $aData['noticia'] = $this->noticia->obtenerUno($noticia);
        if($aData['noticia']) {
            $this->_SiteInfo['title'] .= ' - '.$aData['noticia']['tituloNoticia'];
            $aData['comentarios'] = $this->noticia->obtenerComentarios($aData['noticia']['idNoticia']);
            $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/noticias/ver', $aData, true);
            parent::index();
        }
        else {

        }
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->pases->guardar(
                    array(
                        $this->_reg['idActuacionPase']
                        , $this->_reg['idActuacion']
                        , $this->_reg['foliosActuacionPase']
                        , $this->_reg['fechaEnvioActuacionPase']
                        , $this->_reg['fechaRecepcionActuacionPase']
                        , $this->_reg['idOrigen']
                        , $this->_reg['idDestino']
                        , $this->_reg['idTipoPase']
                        , $this->_reg['observacionActuacionPase']
                        , 1
                        , $this->_reg['idUsuarioOrigen']
                        , 0
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                if($this->_reg['idActuacionPase'] == 0) {
                    $this->_aEstadoOper['message'] = 'Se realizó el pase correctamente.';
                    $this->actuaciones->pasar($this->_reg['idActuacion']);
                }
                else {
                    $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';        
                }                
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        if ($this->_aEstadoOper['status'] > 0) {
            //$this->listado();
            $this->preformulario($this->_aEstadoOper['status']);
        } 
        else {
            $this->formulario($this->input->post('idActuacion'));
            
        }
    }
    public function eliminar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdFaq'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
        } 
        else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
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