<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @package Actuaciones
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2014
 */
class Actuaciones extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->library('hits/gridview');
        $this->load->model('sigep/actuaciones_model', 'actuaciones');
        $this->load->model('sigep/pases_model', 'pases');
        $this->load->model('sigep/instrumentos_model', 'instrumentos');
        $this->load->model('sigep/estructuras_model', 'estructura');
        $this->_aReglas = array(
            array(
                'field' => 'idActuacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'codigoActuacion',
                'label' => 'Codigo Interno de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'tipoActuacion',
                'label' => 'Tipo de Actuaciónes',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idActuacionTipo',
                'label' => 'Tipo de Actuación',
                'rules' => 'trim|xss_clean|is_natural_no_zero'
            ),
            array(
                'field' => 'periodoActuacion',
                'label' => 'Periodo de Actuación',
                'rules' => 'trim|xss_clean|numeric'
            ),
            array(
                'field' => 'fechaCreacionActuacion',
                'label' => 'Fecha de creación SICE',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idActuacionTema',
                'label' => 'Tema de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'cdsSICE',
                'label' => 'CDS',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'iudSICE',
                'label' => 'I.U.D.',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'numeroSICE',
                'label' => 'Numero',
                'rules' => 'trim|xss_clean|required|numeric'
            ),
            array(
                'field' => 'periodoSICE',
                'label' => 'Periodo SICE',
                'rules' => 'trim|xss_clean|required|numeric'
            ),
            array(
                'field' => 'correspondeSICE',
                'label' => 'Corresponde',
                'rules' => 'trim|xss_clean|required|numeric'
            ),
            array(
                'field' => 'idIniciador',
                'label' => 'Codigo Iniciador',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'iudRemitenteActuacion',
                'label' => 'I.U.D. Remitente',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idRemitenteActuacion',
                'label' => 'Remitente',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'foliosActuacion',
                'label' => 'Cantidad de Folios',
                'rules' => 'trim|xss_clean|required|numeric'
            ),
            array(
                'field' => 'caratulaActuacion',
                'label' => 'Carátula | Extracto',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'observacionesActuacion',
                'label' => 'Observaciones',
                'rules' => 'trim|xss_clean'
            ),
        );
        $this->_aReglasInterna = array(
            array(
                'field' => 'idActuacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'codigoActuacion',
                'label' => 'Codigo Interno de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'tipoActuacion',
                'label' => 'Tipo de Actuaciónes',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idActuacionTipo',
                'label' => 'Tipo de Actuación',
                'rules' => 'trim|xss_clean|required|is_natural_no_zero'
            ),
            array(
                'field' => 'periodoActuacion',
                'label' => 'Periodo de Actuación',
                'rules' => 'trim|xss_clean|numeric'
            ),
            array(
                'field' => 'idActuacionTema',
                'label' => 'Tema de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'cdsSICE',
                'label' => 'CDS',
                'rules' => 'trim|xss_clean|numeric'
            ),
            array(
                'field' => 'iudSICE',
                'label' => 'I.U.D.',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'numeroSICE',
                'label' => 'Numero',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'periodoSICE',
                'label' => 'Periodo SICE',
                'rules' => 'trim|xss_clean|numeric'
            ),
            array(
                'field' => 'correspondeSICE',
                'label' => 'Corresponde',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idIniciador',
                'label' => 'Codigo Iniciador',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'iudRemitenteActuacion',
                'label' => 'I.U.D. Remitente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idRemitenteActuacion',
                'label' => 'Remitente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'caratulaActuacion',
                'label' => 'Carátula | Extracto',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'observacionesActuacion',
                'label' => 'Observaciones',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'foliosActuacion',
                'label' => 'Cantidad de Folios',
                'rules' => 'trim|xss_clean|required|is_natural_no_zero'
            ),
        );
        $this->_aReglasRecepcion = array(
            array(
                'field' => 'idActuacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'codigoActuacion',
                'label' => 'Codigo Interno de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'referenciaActuacion',
                'label' => 'Referencia de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'foliosActuacion',
                'label' => 'Folios de Actuación',
                'rules' => 'trim|xss_clean|is_natural_no_zero|required'
            ),
            array(
                'field' => 'cdsRemitenteActuacion',
                'label' => 'C.D.S. Remitente',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'iudRemitenteActuacion',
                'label' => 'I.U.D. Remitente',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idRemitenteActuacion',
                'label' => 'Remitente de Actuacion',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'fechaRecepcionActuacion',
                'label' => 'Fecha de Recepcion',
                'rules' => 'trim|xss_clean'
            ),
        );
        $this->_aReglasBusqueda = array(
            array(
                'field' => 'cdsSICE',
                'label' => 'CDS SICE',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'iudSICE',
                'label' => 'IUD SICE',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'numeroSICE',
                'label' => 'Número SICE',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'periodoSICE',
                'label' => 'Período',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'correspondeSICE',
                'label' => 'Corresponde',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'fechaDesde',
                'label' => 'Fecha Desde',
                'rules' => 'trim|xss_clean|valid_date'
            ),
            array(
                'field' => 'fechaHasta',
                'label' => 'Fecha Hasta',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idActuacionTipo',
                'label' => 'Tipo de Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'caratulaActuacion',
                'label' => 'Criterio',
                'rules' => 'trim|xss_clean'
            ),
        );
    }

    public function index() {
        $this->_content = $this->load->view('admin/actuaciones/principal', array(), true);
        $this->_menu = menu_ul('actuaciones');
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idActuacion' => null
            , 'codigoActuacion' => null
            , 'tipoActuacion' => null
            , 'idActuacionTipo' => null
            , 'fechaCreacionActuacion' => null
            , 'periodoActuacion' => null
            , 'idActuacionTema' => null
            , 'cdsSICE' => null
            , 'iudSICE' => null
            , 'numeroSICE' => null
            , 'periodoSICE' => null
            , 'correspondeSICE' => null
            , 'idIniciador' => null
            , 'cdsRemitenteActuacion' => null
            , 'iudRemitenteActuacion' => null
            , 'idRemitenteActuacion' => null
            , 'foliosActuacion' => null
            , 'caratulaActuacion' => null
            , 'observacionesActuacion' => null
        );
        $inId = ($this->input->post('idActuacion') !== false) ? $this->input->post('idActuacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->actuaciones->obtenerUno($inId);
            $this->_reg['fechaCreacionActuacion'] = GetDateFromISO($this->_reg['fechaCreacionActuacion'], FALSE);
        } else {
            $this->_reg = array(
                'idActuacion' => $inId
                , 'codigoActuacion' => set_value('codigoActuacion')
                , 'tipoActuacion' => set_value('tipoActuacion')
                , 'idActuacionTipo' => set_value('idActuacionTipo')
                , 'fechaCreacionActuacion' => set_value('fechaCreacionActuacion')
                , 'periodoActuacion' => set_value('periodoActuacion')
                , 'idActuacionTema' => set_value('idActuacionTema')
                , 'cdsSICE' => set_value('cdsSICE')
                , 'iudSICE' => set_value('iudSICE')
                , 'numeroSICE' => set_value('numeroSICE')
                , 'periodoSICE' => set_value('periodoSICE')
                , 'correspondeSICE' => set_value('correspondeSICE')
                , 'idIniciador' => set_value('idIniciador')
                , 'cdsRemitenteActuacion' => set_value('cdsRemitenteActuacion')
                , 'iudRemitenteActuacion' => set_value('iudRemitenteActuacion')
                , 'idRemitenteActuacion' => set_value('idRemitenteActuacion')
                , 'foliosActuacion' => set_value('foliosActuacion')
                , 'caratulaActuacion' => set_value('caratulaActuacion')
                , 'observacionesActuacion' => set_value('observacionesActuacion')
            );
        }
        return $this->_reg;
    }
    protected function _inicRegRecepcion($boIsPostBack=false) {
        $this->_reg = array(
            'idActuacion' => null
            , 'codigoActuacion' => null
            , 'cdsRemitenteActuacion' => null
            , 'idRemitenteActuacion' => null
            , 'fechaRecepcionActuacion' => null
        );
        $inId = ($this->input->post('idActuacion') !== false) ? $this->input->post('idActuacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->actuaciones->obtenerUno($inId);
            $this->_reg['fechaRecepcionActuacion'] = ($this->_reg['fechaRecepcionActuacion'])? GetDateTimeFromISO($this->_reg['fechaRecepcionActuacion'], FALSE):date('d/m/Y H:i:s');
        } else {
            $this->_reg = array(
                'idActuacion' => $inId
                , 'codigoActuacion' => set_value('codigoActuacion')
                , 'referenciaActuacion' => set_value('referenciaActuacion')
                , 'cdsRemitenteActuacion' => set_value('cdsRemitenteActuacion')
                , 'idRemitenteActuacion' => set_value('idRemitenteActuacion')
                , 'fechaRecepcionActuacion' => ($this->_reg['fechaRecepcionActuacion'])? set_value('fechaRecepcionActuacion'):date('d/m/Y H:i:s')
            );
        }
        return $this->_reg;
    }
    protected function _inicRegBusqueda($boIsPostBack=false) {
        $this->_reg = array(
            'cdsSICE' => null
            , 'iudSICE' => null
            , 'numeroSICE' => null
            , 'periodoSICE' => null
            , 'correspondeSICE' => null
            , 'fechaDesde' => null
            , 'fechaHasta' => null
            , 'idActuacionTipo' => null
            , 'caratulaActuacion' => null
        );
        $inId = ($this->input->post('idActuacion') !== false) ? $this->input->post('idActuacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->actuaciones->obtenerUno($inId);
            $this->_reg['fechaRecepcionActuacion'] = ($this->_reg['fechaRecepcionActuacion'])? GetDateTimeFromISO($this->_reg['fechaRecepcionActuacion'], FALSE):date('d/m/Y H:i:s');
        } else {
            $this->_reg = array(
                'cdsSICE' => set_value('cdsSICE')
                , 'iudSICE' => set_value('iudSICE')
                , 'numeroSICE' => set_value('numeroSICE')
                , 'periodoSICE' => set_value('periodoSICE')
                , 'correspondeSICE' => set_value('correspondeSICE')
                , 'fechaDesde' => GetDateTimeFromFrenchToISO(set_value('fechaDesde'))
                , 'fechaHasta' => GetDateTimeFromFrenchToISO(set_value('fechaHasta'))
                , 'idActuacionTipo' => set_value('idActuacionTipo')
                , 'caratulaActuacion' => set_value('caratulaActuacion')
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    protected function _inicReglasInterna() {
        $val = $this->form_validation->set_rules($this->_aReglasInterna);
    }
    protected function _inicReglasRecepcion() {
        $val = $this->form_validation->set_rules($this->_aReglasRecepcion);
    }
    protected function _inicReglasBusqueda() {
        $val = $this->form_validation->set_rules($this->_aReglasBusqueda);
    }
    public function listado() {
        $estructura = ($this->autenticacion->idMesaRol() == 2)? 0:$this->autenticacion->idMesaEstructura();
        $estructura = 0;
        $vcBuscar = ($this->input->post('busqueda') === FALSE) ? '' : $this->input->post('busqueda');
        $vcOrder = ($this->input->post('order') === FALSE) ? '' : $this->input->post('order');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrador/actuaciones/listado'
                    , 'iTotalRegs' => $this->actuaciones->numRegs(0, $vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => FALSE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Actuaciones'
                    , 'buscador' => FALSE
                    , 'identificador' => 'idActuacion'
                )
        );
        $this->gridview->addColumn('codigoActuacion', 'N° de Actuación SGA (SIGEP)', 'text');
        $this->gridview->addColumn('fechaCreacionActuacion', 'Fecha de creación SGA', 'date');
        $this->gridview->addColumn('referenciaActuacion', 'N° de Actuación SICE', 'text');
        $this->gridview->addColumn('fechaCreacionSICE', 'Fecha de creación SICE', 'date');
        $this->gridview->addColumn('referenciaActuacion', 'N° de Actuación SICE', 'text');
        $this->gridview->addColumn('nombreActuacionTipo', 'Tipo', 'text');
        $this->gridview->addColumn('caratulaActuacion', 'Caratula', 'tinyText');
        if($estructura == 0) {
            $this->gridview->addColumn('nombreEstructuraActual', 'Area en la que se encuentra', 'text');
        }
        else {
            $this->gridview->addColumn('nombreActuacionTema', 'Tema', 'text');
            $this->gridview->addColumn('caratulaActuacion', 'Carátula', 'tinyText');    
        }
        $this->gridview->addColumn('nombreActuacionEstado', 'Estado', 'text');
        //$consultar = '<a ic-post-to="" href="administrator/actuaciones/panel/{idActuacion}" title="Seleccionar Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-ok"></span></a>';
        $consultar = '<a href="#" ic-post-to="actuaciones/panel/{idActuacion}" ic-target="#main_content" title="Seleccionar Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-ok"></span></a>';
        $acciones = $consultar;
        /*$opciones = array(
            array(
                'cdsSICE' => $this->input->post('cdsSICE')
                , 'fechaDesde' => GetDateTimeFromFrenchToISO($this->input->post('fechaDesde'))
                , 'fechaHasta' => GetDateTimeFromFrenchToISO($this->input->post('fechaHasta'))
            ),
        );*/
        $this->gridview->addControl('idActuacionCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:32px;'));
        //$this->_rsRegs = $this->actuaciones->obtener($estructura, $vcBuscar, $vcOrder, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->_inicRegBusqueda((bool) $this->input->post('vcForm'));
        $this->_rsRegs = $this->actuaciones->obtenerBuscador($this->_reg);
        $this->load->view('admin/actuaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'resultado' => $this->_aEstadoOper['status']
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function formulario() {
        $tipo = ($this->autenticacion->idMesaEstructura() == 30)? 2:1;
        $aData['tipo'] = $tipo;
        $aData['estructuras_cds'] = $this->actuaciones->dropdownCDSEstructuras($tipo);
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras($tipo);
        $aData['estructuras_rem'] = $this->actuaciones->dropdownEstructuras(0, 'Seleccione el organismo remitente...');
        $aData['tipos'] = $this->actuaciones->dropdownTipos();
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        $aData['vcFrmAction'] = 'actuaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $aData['content'] = ($this->input->post('tipoActuacion') == 1 || $tipo == 1)? $this->load->view('admin/actuaciones/interna', $aData, true):$this->load->view('admin/actuaciones/externa', $aData, true);
        $this->load->view('admin/actuaciones/formulario', $aData);
    }
    /*public function ppendientes() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/actuaciones/pprincipal', array(), true);
        parent::index();
    }
    public function pendientes() {
        $estructura = ($this->autenticacion->idRol() == 2)? 0:$this->autenticacion->idMesaEstructura();
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $vcOrder = ($this->input->post('order') === FALSE) ? '' : $this->input->post('order');
        $state = 2;
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/actuaciones/listado'
                    , 'iTotalRegs' => $this->actuaciones->numRegs($estructura, $vcBuscar)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de Actuaciones en Mesa'
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
        $pases = '<a href="administrator/pases/listado/{idActuacion}" title="Ver detalle de pases de Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-th-list"></span></a>';
        $recepcion = '<a href="administrator/actuaciones/recepcion/{idActuacion}" title="Recibir Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-save"></span></a>';
        $recepcion = '<a href="administrator/actuaciones/pasar/{idActuacion}" title="Recibir Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-save"></span></a>';
        $editar = '<a href="administrator/actuaciones/formulario/{idActuacion}" title="Editar Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $acciones = $recepcion.$pases;

        
        $this->gridview->addControl('idActuacionCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:86px;'));
        $this->_rsRegs = $this->actuaciones->obtener($estructura, $vcBuscar, 1, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/actuaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function pasar($idActuacion) {
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['Reg']['idActuacionPase'] = 0;
        $aData['Reg']['idOrigen'] = $this->autenticacion->idMesaEstructura();
        $aData['Reg']['idDestino'] = 0;
        $aData['Reg']['idUsuarioOrigen'] = $this->autenticacion->idUsuario();
        $aData['Reg']['fojasActuacionPase'] = 0;
        $aData['Reg']['observacionActuacionPase'] = '';
        $aData['mesas'] = $this->pases->dropdownEstructurasMesas($this->autenticacion->idMesaEstructura());
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['vcFrmAction'] = 'administrator/pases/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/pases/formulario', $aData);
    }
    public function pases() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/sigep/actuaciones/pases', array(), true);
        parent::index();
    }
    public function gpases() {
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
                    , 'buscador' => FALSE
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
        $print = '<a href="administrator/actuaciones/historial/{idActuacion}" target="_blank" title="Imprimir Actuación N° {codigoActuacion}" class="" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-print"></span></a>';
        $eliminar = '<a href="administrator/usuarios/formulario/{idActuacion}" title="Eliminar actuacion N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $recepcion = '<a href="administrator/actuaciones/pases/formulario/{idActuacion}" title="Generar Pase para la Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-share-alt"></span></a>';
        $editar = '<a href="administrator/actuaciones/formulario/{idActuacion}" title="Editar Actuación N° {codigoActuacion}" class="btn-accion" rel="{\'idActuacion\': {idActuacion}}"><span class="glyphicon glyphicon-pencil"></span></a>';
        $acciones = $editar.$recepcion.$eliminar.$print;

        
        $this->gridview->addControl('idActuacionCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:86px;'));
        $this->_rsRegs = $this->actuaciones->obtener($vcBuscar, 2, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('administrator/sigep/actuaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
            )
        );
    }
    public function recepcion() {
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras();
        $aData['Reg'] = $this->_inicRegRecepcion($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/actuaciones/recibir';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/recepcion', $aData);
    }
    public function recibir() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasRecepcion();
        if ($this->_validarReglas()) {
            $this->_inicRegRecepcion((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->actuaciones->recepcionar(
                    array(
                        $this->_reg['idActuacion']
                        , GetDateTimeFromFrenchToISO($this->_reg['fechaRecepcionActuacion'])
                        , $this->_reg['idRemitenteActuacion']
                        , $this->autenticacion->idUsuario()
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'El registro fue guardado correctamente.';
            } else {
                $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        if ($this->_aEstadoOper['status'] > 0) {
            $this->listado();
        } else {
            
            $this->recepcion();
            
        }
    }*/
    public function consulta() {
        $tipo = ($this->autenticacion->idMesaEstructura() == 30)? 2:1;
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras(0);
        $aData['tipos'] = $this->actuaciones->dropdownTipos();
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        $aData['vcFrmAction'] = 'actuaciones/buscar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/actuaciones/consulta', $aData);
    }
    public function buscar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglasBusqueda();
        if ($this->_validarReglas()) {
            $this->_inicRegBusqueda((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = count($this->actuaciones->obtenerBuscador($this->_reg));
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
    /*function ver($noticia) {
        $aData['noticia'] = $this->noticia->obtenerUno($noticia);
        if($aData['noticia']) {
            $this->_SiteInfo['title'] .= ' - '.$aData['noticia']['tituloNoticia'];
            $aData['comentarios'] = $this->noticia->obtenerComentarios($aData['noticia']['idNoticia']);
            $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/noticias/ver', $aData, true);
            parent::index();
        }
        else {

        }
    }*/
    public function buscarMesa() {
        $this->load->model('sigep/estructuras_model', 'estructura');
        $data = $this->estructura->obtenerUnoIud($this->input->post('iud'));
        echo json_encode($data);
    }
    public function buscarMesaId() {
        $this->load->model('sigep/estructuras_model', 'estructura');
        $data = $this->estructura->obtenerUno($this->input->post('id'));
        echo json_encode($data);
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        if($this->input->post('tipoActuacion') == 2) {
            $this->_inicReglas();
            $this->_inicReglasRecepcion();
        }
        else {
            $this->_inicReglasInterna();
        }
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_reg['correspondeSICE'] = ($this->_reg['correspondeSICE'])? $this->_reg['correspondeSICE']:0;
            $this->_aEstadoOper['status'] = $this->actuaciones->guardar(
                    array(
                        $this->_reg['idActuacion']
                        , ($this->_reg['tipoActuacion'] == 'on' || $this->_reg['tipoActuacion'] == 1)? 1:0
                        , $this->_reg['idActuacionTipo']
                        , $this->_reg['periodoActuacion']
                        , $this->_reg['idActuacionTema']
                        , $this->_reg['cdsSICE']
                        , $this->_reg['iudSICE']
                        , $this->_reg['numeroSICE']
                        , $this->_reg['periodoSICE']
                        , $this->_reg['correspondeSICE']
                        , $this->_reg['fechaCreacionActuacion']
                        , ($this->_reg['idIniciador'] == 0 || $this->_reg['idIniciador'] == '')? $this->autenticacion->idMesaEstructura():$this->_reg['idIniciador']
                        , $this->_reg['iudRemitenteActuacion']
                        , ($this->_reg['idRemitenteActuacion'] == 0 || $this->_reg['idRemitenteActuacion'] == '')? $this->autenticacion->idMesaEstructura():$this->_reg['idRemitenteActuacion']
                        , ($this->input->post('tipoActuacion') == 2)? $this->_reg['cdsSICE'].$this->_reg['iudSICE'].'-'.$this->_reg['numeroSICE'].'/'.$this->_reg['periodoSICE'].'-'.$this->_reg['correspondeSICE']:0
                        , $this->_reg['foliosActuacion']
                        , $this->_reg['caratulaActuacion']
                        , $this->_reg['observacionesActuacion']
                        , $this->autenticacion->idMesaEstructura()
                        , $this->autenticacion->idUsuario()
                    )
            );
            if ($this->_aEstadoOper['status'] > 0) {
                if($this->_aEstadoOper['status'] > 1) {
                    $this->pases->guardar(
                        array(
                            0
                            , $this->_aEstadoOper['status']
                            , $this->_reg['foliosActuacion']
                            , date('Y-m-d H:i:s')
                            , date('Y-m-d H:i:s')
                            , ($this->_reg['idRemitenteActuacion'] == 0 || $this->_reg['idRemitenteActuacion'] == '')? $this->autenticacion->idMesaEstructura():$this->_reg['idRemitenteActuacion']
                            , $this->autenticacion->idMesaEstructura()
                            , 1
                            , ''
                            , 2
                            , 1
                            , 1
                        )
                    );
                }
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
        //$this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->consulta();
        }
        else {
            if($this->input->post('tipoActuacion') == 2) {
                $this->externa();
            }
            else {
                $this->interna();
            }
            //$this->formulario();
        }
    }
    public function eliminar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_aEstadoOper['status'] = $this->_oModel->eliminar($this->input->post('inIdFaq'));
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con &eacute;xito.';
        } else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }

        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));

        $this->listado();
    }
    public function historial($idActuacion) {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['pases'] = $this->pases->obtener($idActuacion);
        $aData['actuacion']['foliosActuacion'] = $this->pases->obtenerFolios($aData['actuacion']['idActuacion']);
        $this->load->view('admin/actuaciones/historial', $aData);
    }
    public function nuevo() {
        $aData['ckeditor_texto'] = $this->capa;
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'administrator/actuaciones/crear';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = 'Agregar';
        $this->load->view('administrator/sigep/actuaciones/nuevo', $aData);
    }
    public function externa() {
        $tipo = ($this->autenticacion->idMesaEstructura() == 30)? 2:1;
        $aData['estructuras_cds'] = $this->actuaciones->dropdownCDSEstructuras(2);
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras(2);
        $aData['estructuras_rem'] = $this->actuaciones->dropdownEstructuras(0, 'Seleccione el organismo remitente...');
        $aData['tipos'] = $this->actuaciones->dropdownTiposDependiente(2);
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        $aData['vcFrmAction'] = 'actuaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/actuaciones/externa', $aData);
    }
    public function interna() {
        $tipo = ($this->autenticacion->idMesaEstructura() == 30)? 2:1;
        $aData['estructuras_cds'] = $this->actuaciones->dropdownCDSEstructuras(1);
        $aData['estructuras'] = $this->actuaciones->dropdownEstructuras(0);
        $aData['tipos'] = $this->actuaciones->dropdownTiposDependiente(1);
        $aData['temas'] = $this->actuaciones->dropDownTemas();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));    
        $aData['vcFrmAction'] = 'actuaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $aData['vcAccion'] = ($this->_reg['idActuacion'] > 0) ? 'Modificar' : 'Agregar';
        $this->load->view('admin/actuaciones/interna', $aData);
    }
    public function crear() {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $this->config->set_item('header_on', FALSE);
        $aData['nota'] = $_POST;
        //$aData['pase'] = $this->pases->obtenerUno($idPase);
        //$aData['actuacion'] = $this->actuaciones->obtenerUno($aData['pase']['idActuacion']);
        $this->load->view('administrator/sigep/actuaciones/notas/previa', $aData);
    }
    public function estructuras() {
        $tipo = ($this->input->post('tipo') == 'true')? 2:1;
        echo json_encode($this->actuaciones->dropdownEstructurasDependiente($tipo));
    }
    public function tipos() {
        $tipo = ($this->input->post('tipo') == 'true')? 2:1;
        echo json_encode($this->actuaciones->dropdownEstructurasDependiente($tipo));
    }

    public function panel($idActuacion) {
        $aData['actuacion'] = $this->actuaciones->obtenerUno($idActuacion);
        $aData['available'] = $this->actuaciones->available($idActuacion, $this->autenticacion->idMesaEstructura());
        $this->load->view('admin/actuaciones/panel', $aData);
    }
    
    public function dependienteCDS() {
        $this->load->model('sigep/estructuras_model', 'estructuras');
        $estructura = $this->estructuras->obtenerUno($this->input->post('cdsEstructura'));
        $estructuras = $this->actuaciones->dropdownEstructurasDependienteCDS($estructura['iudEstructura']);
        echo json_encode($estructuras);
    }

    public function detalles() {
        $this->config->set_item('page_orientation', 'L');
        $this->config->set_item('page_format', 'A4');
        $aData['pases'] = $this->pases->obtener();
        //$aData['pases'] = $this->pases->obtener($idActuacion);
        //$aData['actuacion']['foliosActuacion'] = $this->pases->obtenerFolios($aData['actuacion']['idActuacion']);
        $this->load->view('administrator/sigep/actuaciones/detalles', $aData);
    }
    public function inscripcion() {
        $this->config->set_item('page_orientation', 'P');
        $this->config->set_item('page_format', 'A4');
        $aData = array();
        //$aData['pases'] = $this->pases->obtener($idActuacion);
        //$aData['actuacion']['foliosActuacion'] = $this->pases->obtenerFolios($aData['actuacion']['idActuacion']);
        $this->load->view('admin/actuaciones/inscripcion', $aData);
    }
}
?>