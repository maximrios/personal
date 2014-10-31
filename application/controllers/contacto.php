<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Contacto extends Ext_controller {
	function __construct() {
		parent::__construct();		
        $this->load->model('layout_model', 'layout');
		$this->load->library('hits/messages');
        //$this->load->helper('utils_helper');*/
        $this->_aReglas = array(
            array(
                'field'   => 'nombresContacto',
                'label'   => 'Nombre',
                'rules'   => 'trim|max_length[80]|xss_clean|required'
            )
            , array(
                'field'   => 'telefonoContacto',
                'label'   => 'Teléfono',
                'rules'   => 'trim|max_length[15]|xss_clean|numeric|required'
            )
            , array(
                'field'   => 'emailContacto',
                'label'   => 'Email',
                'rules'   => 'trim|max_length[40]|xss_clean|valid_email|required'
            )
            , array(
                'field'   => 'mensajeContacto',
                'label'   => 'Mensaje',
                'rules'   => 'trim|max_length[1000]|xss_clean|required'
            )
        );         
	}
    protected function _inicReglas() {
        $val = $this->form_validation->set_rules($this->_aReglas);
    }  
    protected function _inicReg() {
        $this->_reg = array(            
            'nombresContacto' => $this->input->post('nombresContacto')
            , 'telefonoContacto' => $this->input->post('telefonoContacto')
            , 'emailContacto' => $this->input->post('emailContacto')
            , 'mensajeContacto' => $this->input->post('mensajeContacto')
        );
        return $this->_reg;
    }
    public function index() {	
        $this->_inicReglas();
        if($this->_validarReglas()) {
            $this->_inicReg((bool)$this->input->post('vcForm'));
            $this->load->library('hits/mailer', array(), 'mailer');
            $aData['consulta'] = $this->_reg;
            if($this->mailer->enviarMail('Fundacion para la Integracion y el Desarrollo de Comunidades - Consulta web', 'consulta', $aData, array(array('email' => $this->config->config['ext_base_smtp_config_editable']['mail'], 'nombre' => $this->config->config['ext_base_smtp_config_editable']['asunto_mail'])))) {
                $this->layout->guardarContacto(array(
                    0
                    , $this->input->post('nombresContacto')
                    , $this->input->post('telefonoContacto')
                    , $this->input->post('emailContacto')
                    , $this->input->post('mensajeContacto')
                ));
                $this->_aEstadoOper['status'] = 1;
            }
            else {
                $this->_aEstadoOper['status'] = 0;   
            }
            if($this->_aEstadoOper['status'] > 0) {
                $this->_aEstadoOper['message'] = 'Hemos recibido su consulta. Nos comunicaremos con Ud. a la brevedad.';
            } else {
                $this->_aEstadoOper['message'] = 'Lamentablemente no hemos podido recibir su consulta. Por favor comuniquese por otro medio de comunicación.';
            }
        } 
        else {
            $this->_aEstadoOper['status'] = 0;
            $this->_aEstadoOper['message'] = validation_errors();
            
        }
        if($this->_aEstadoOper['message'] != '') {
            $this->_aEstadoOper['message'] = $this->messages->do_message(array('message'=>$this->_aEstadoOper['message'],'type'=> ($this->_aEstadoOper['status'] > 0)?'success':'danger'));    
        }
        $this->formulario();
	}
    function formulario() {
        $this->load->library('hits/googlemaps');
        $config = array();
        $config['center'] = '-24.8049673, -65.4138704';
        $config['zoom'] = 14;
        $config['directions'] = TRUE;
        $config['map_height'] = 330;
        
        //$config['directionsStart'] = '-24.782889,-65.41174';
        //$config['directionsStart'] = '-24.847344,-65.46155';
        //$config['directionsEnd'] = '-24.859007,-65.452682';
        //$config['directionsDivID'] = 'prueba';
        
        $this->googlemaps->initialize($config);
        $marker = array();
        $marker['position'] = '-24.8049673, -65.4138704';
        $marker['title'] = 'Fundacion FID';
        $marker['infowindow_content'] = 'Fundacion para la Integración y el Desarrollo de Comunidades FID | TE: 03543 43-5608';
        $this->googlemaps->add_marker($marker);
        $aData['map'] = $this->googlemaps->create_map();
        $aData['Reg'] = $this->_inicReg($this->input->post('vcForm'));
        $aData['vcFrmAction'] = 'contacto';
        $aData['vcMsjSrv'] = $this->_aEstadoOper['message'];
        $this->_SiteInfo['title'] .= ' - Contacto';
        $this->_menu = 'contacto';
        $aData['breadcrumb'] = '<a href="#">Home</a> / Contacto';
        $this->_menu('contacto');
        $this->_content = $this->load->view('contacto', $aData, true);
        parent::index();
    }
}
?>