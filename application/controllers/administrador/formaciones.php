<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Nombre de métodos y variables respetando la notacion camel case en minúsculas. pe acercaDe()
 * Nombre de variables publicas de la clase indique el prefijo del tipo de datos. pe $inIdNoticia
 * Nombre de variables privadas de la clase indique un _ antes del prefijo del tipo de datos. pe $_inIdNoticia
 */

/**
 * @Formaciones class
 * @package Base
 * @author  Maximiliano Ezequiel Rios
 * @copyright 2013
 */
class Formaciones extends Ext_crud_controller {
    function __construct() {
        parent::__construct();
        $this->load->model('sigep/agentes_model', 'agentes');
        $this->load->model('admin/formaciones_model', 'formaciones');
        $this->load->library('hits/gridview');
        $this->_aReglas = array(
            array(
                'field' => 'idFormacion',
                'label' => 'Actuación',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'idFormacionTitulo',
                'label' => 'Titulo',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'idPersona',
                'label' => 'Persona',
                'rules' => 'trim|xss_clean|required'
            ),
        );
    }

    public function index() {
        $this->_vcContentPlaceHolder = $this->load->view('administrator/hits/formaciones/principal', array(), true);
        parent::index();
    }

    protected function _inicReg($boIsPostBack=false) {
        $this->_reg = array(
            'idFormacion' => null
            , 'idFormacionTitulo' => null
            , 'idPersona' => null
        );
        $inId = ($this->input->post('idFormacion') !== false) ? $this->input->post('idFormacion') : 0;
        if ($inId != 0 && !$boIsPostBack) {
            $this->_reg = $this->formaciones->obtenerUno($inId);
        } else {
            $this->_reg = array(
                'idFormacion' => $inId
                , 'idFormacionTitulo' => set_value('idFormacionTitulo')
                , 'idPersona' => set_value('idPersona')
            );
        }
        return $this->_reg;
    }
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }
    public function listado($idAgente) {
        $vcBuscar = ($this->input->post('vcBuscar') === FALSE) ? '' : $this->input->post('vcBuscar');
        $this->gridview->initialize(
                array(
                    'sResponseUrl' => 'administrator/formaciones/listado'
                    , 'iTotalRegs' => $this->formaciones->numRegs($vcBuscar, $idAgente)
                    , 'iPerPage' => ($this->input->post('per_page')==FALSE)? 10: $this->input->post('per_page')
                    , 'bOrder' => TRUE
                    , 'sFootProperties' => 'class="paginador"'
                    , 'titulo' => 'Listado de formaciones académicas'
                    , 'buscador' => TRUE
                    , 'identificador' => 'idFormacion'
                )
        );
        if($this->autenticacion->idUsuario() == 1) {
            $this->gridview->addColumn('idFormacion', '#', 'int', array('order' => TRUE));    
        }
        $this->gridview->addColumn('nombreFormacionTitulo', 'Titulo', 'text');
        $this->gridview->addColumn('nombreFormacionTipo', 'Nivel', 'text');
        $this->gridview->addColumn('nombreFormacionAvance', 'Estado', 'text', array('order' => TRUE));
        $this->gridview->addParm('vcBuscar', $this->input->post('vcBuscar'));
        $editar = '<a href="#" ic-post-to="formaciones/formulario/{idFormacion}/{idAgente}" ic-target="#tabs-content" title="Editar datos de  {nombreFormacionTitulo}" class="icono-gridview" rel="{\'idFormacion\': {idFormacion}}"><span class="glyphicon glyphicon-pencil"></span></a>'; 
        $eliminar = '<a href="#" ic-post-to="formaciones/eliminar/{idFormacion}" ic-target="#tabs-content" title="Eliminar  {nombreFormacionTitulo}" class="icono-gridview" rel="{\'idFormacion\': {idFormacion}}"><span class="glyphicon glyphicon-trash"></span></a>';
        $acciones = $editar.$eliminar;
        $this->gridview->addControl('inIdFaqCtrl', array('face' => $acciones, 'class' => 'acciones', 'style' => 'width:64px;'));
        $this->_rsRegs = $this->formaciones->obtener($vcBuscar, $idAgente, $this->gridview->getLimit1(), $this->gridview->getLimit2());
        $this->load->view('admin/formaciones/listado'
            , array(
                'vcGridView' => $this->gridview->doXHtml($this->_rsRegs)
                , 'vcMsjSrv' => $this->_aEstadoOper['message']
                , 'txtvcBuscar' => $vcBuscar
                , 'idAgente' => $idAgente
            )
        );
    }
    public function formulario($idFormacion, $idAgente) {
        $aData['agente'] = $this->agentes->obtenerUno($idAgente);
        $aData['niveles'] = $this->formaciones->dropdownNiveles();
        $aData['titulos'] = $this->formaciones->dropDownTitulos();
        $aData['avances'] = $this->formaciones->dropDownAvances();
        if($idFormacion == 0) {
            $aData['Reg'] = $this->_inicReg(false);
        }
        else {
            $aData['Reg'] = $this->formaciones->obtenerUno($idFormacion);
        }
        
        $aData['vcFrmAction'] = 'formaciones/guardar';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->load->view('admin/formaciones/formulario', $aData);
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
            //$this->load->view('administrator/hits/noticias/ver', $aData);
        }
        else {

        }
    }
    public function guardar() {
        antibotCompararLlave($this->input->post('vcForm'));
        $this->_inicReglas();
        if ($this->_validarReglas()) {
            $this->_inicReg((bool) $this->input->post('vcForm'));
            $this->_aEstadoOper['status'] = $this->formaciones->guardar(
                    array(
                        $this->_reg['idFormacion']
                        , $this->_reg['idPersona']
                        , 6
                        , $this->_reg['idFormacionTitulo']
                        , 2
                        , 0
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
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'danger'));
        if($this->_aEstadoOper['status'] > 0) {
            $this->listado($this->input->post('idAgente'));
        } else {
            $this->formulario($this->_reg['idFormacion'], $this->input->post('idAgente'));
        }
    }
    public function eliminar($idFormacion) {
        $formacion = $this->formaciones->obtenerUno($idFormacion);
        $agente = $this->agentes->obtenerAgentePersona($formacion['idPersona']);
        $this->_aEstadoOper['status'] = $this->formaciones->eliminar($idFormacion);
        if ($this->_aEstadoOper['status'] > 0) {
            $this->_aEstadoOper['message'] = 'El registro fue eliminado con éxito.';
        } 
        else {
            $this->_aEstadoOper['message'] = $this->_obtenerMensajeErrorDB($this->_aEstadoOper['status']);
        }
        $this->_aEstadoOper['message'] = $this->messages->do_message(array('message' => $this->_aEstadoOper['message'], 'type' => ($this->_aEstadoOper['status'] > 0) ? 'success' : 'alert'));
        $this->listado($agente['idAgente']);
    }
}
?>