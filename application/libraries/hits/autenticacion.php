<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Autenticacion {
	protected $_mensaje;
	protected $_keys = array('idAgente', 'idUsuario','idRol','idPersona', 'dniPersona','nombreUsuario','ultimoLoginUsuario','nombrePersona','apellidoPersona');
	protected $_idKey = 'idUsuario';
	protected $_nombreKey = 'nombrePersona';
	protected $_loginKey = 'nombreUsuario';
    private $ci;
	public function __construct($parms=array()) {
		$this->ci =& get_instance();
		$this->ci->load->library('Session');
		$this->ci->load->model('admin/usuarios_model', 'usuarios');
		$this->_init();
	}
	protected function _init() {
		$this->_mensaje = '';
		$this->opciones = array();
		$keys = $this->ci->config->item('ext_autenticacion');
		foreach($keys as $key) {
			$this->opciones[$key] = $this->ci->config->item('ext_autenticacion_'.$key);
		}
	}
	protected function _setSession($data, $keys = array('idAgente','idUsuario','idRol','idPersona', 'dniPersona','nombreUsuario','ultimoLoginUsuario','nombrePersona', 'apellidoPersona')) {
		$dataUsr = array();
		foreach ($keys as $key) {
			$dataUsr[$key] = $data[$key];
		}
		$usuario = array(
			'auth' => $dataUsr
			, 'Lib_Aut_boLogueado' => TRUE
		);
		$this->ci->session->set_userdata($usuario);
	}
	/*
	 **  Agregado para Sindicatura General de la Provincia
	 */
	protected function _setSessionMesa($data, $keys = array('idMesaUsuario', 'idMesaEstructura', 'cdsMesaEstructura', 'iudMesaEstructura', 'nombreMesaEstructura', 'idMesaRol', 'nombreMesaRol')) {
		$dataUsr = array();
		foreach ($keys as $key) {
			$dataUsr[$key] = $data[$key];
		}
		$actuacion = array(
			'Actuacion' => $dataUsr
		);
		$this->ci->session->set_userdata($actuacion);
	}
	/*
	 ** Fin de lo agregado
	 */
	public function unsetSession() {
		$usuario = array(
			'auth' => null
			, 'Lib_Aut_boLogueado' => null
		);
		$this->ci->session->unset_userdata($usuario);
	}
	function _serialize($data) {
		if (is_array($data)) {
			foreach ($data as $key => $val) {
				if (is_string($val)) {
					$data[$key] = str_replace('\\', '{{slash}}', $val);
				}
			}
		}
		else {
			if (is_string($data)) {
				$data = str_replace('\\', '{{slash}}', $data);
			}
		}
		return serialize($data);
	}	
	public function _crypt($vcCad) {
		$vcCad = trim($vcCad);
		if($vcCad!='')
			$vcCad = md5($vcCad);
		return $vcCad;
	}
	protected function _agregarItemMenu(&$i, $aRegs) {
		$aRegs[$i]['vcModUrl'] = str_replace('(.*)', '', trim($aRegs[$i]['vcModUrl']));
		$aRegs[$i]['vcModNombre'] = trim($aRegs[$i]['vcModNombre']);
		$href = (!empty($aRegs[$i]['vcModUrl']))?'href="'.$aRegs[$i]['vcModUrl'].'"': '';
		$n = sizeof($aRegs);
		if($i > $n) {
			return '';
		}
		$sItem = '';
		switch($aRegs[$i]['inProf']) {
			case 1:
				
				$sItem = '<li class="itemSup"><a '.$href.' class="nav-button" style="text-transform: uppercase;" >'.$aRegs[$i]['vcModNombre'].'</a>';
				if(@$aRegs[$i + 1]['inProf'] > 1) {
					$i++;
					$sItem .= '<div class="sub"><ul>'.$this->_agregarItemMenu($i, $aRegs).'</ul></div></li>'; 
				} else {
					$sItem .= '</li>';
					$i++;
				}
				break;
			case 2:
			case 3:
				if($href=='') {
					$sItem .= '<li><h3>'.$aRegs[$i]['vcModNombre'].'</h3></li>';
				} else {
					$sItem .= '<li><a '.$href.'>'.$aRegs[$i]['vcModNombre'].'</a></li>';
				}
				if($i+1 > $n) {
					$i++;
				} else {
					if(@$aRegs[$i + 1]['inProf'] >= 2) {
						$i++;
						$sItem .= $this->_agregarItemMenu($i, $aRegs); 
					} else {
						$i++;
					}
				}
				break;
			default:
				$sItem .= '<li><a '.$href.'>'.$aRegs[$i]['vcModNombre'].'</a></li>';
				if(@$aRegs[$i + 1]['inProf'] >= 3) {
					$i++;
					$sItem .= $this->_agregarItemMenu($i, $aRegs); 
				} else {
					$i++;
				}
				break;
		}
		return $sItem;
	}
	
	protected function _getSessData($vcKey) {
		$rg = $this->ci->session->userdata('auth');
		if(!$rg)
			return false;
		return $rg[$vcKey];
	}
	/*
	 ** Agregado para la Sindicatura General de la Provincia
	 */
	protected function _getSessDataMesa($vcKey) {
		$rg = $this->ci->session->userdata('Actuacion');
		if(!$rg)
			return false;
		return $rg[$vcKey];
	}
	/*
	 ** Fin de lo agregado
	 */
	public function doRedirect($location, $sessionData = '', $keyName='message') {
		if(!empty($sessionData)){
			$this->ci->session->set_userdata(array($keyName => $sessionData));
		} else {
			$this->ci->session->set_userdata(NULL);
		}
    	$baseurl = base_url();
		return <<<EOT
<script language="javascript" type="text/javascript">
<!--
top.location = '{$baseurl}{$location}';
// -->
</script>
EOT;
	}

	public function mensajeError()
	{
		return $this->_vcMensajeError;
	}	
	public function idAgente()
	{
		return $this->_getSessData('idAgente');
	}
	public function idUsuario()
	{
		return $this->_getSessData($this->_idKey);
	}
	
	public function nombreUsuario()
	{
		return $this->_getSessData($this->_nombreKey);
	}
	public function nombrePersona()
	{
		return $this->_getSessData('nombrePersona');
	}
	public function apellidoPersona()
	{
		return $this->_getSessData('apellidoPersona');
	}
	public function loginUsuario()
	{
		return $this->_getSessData($this->_loginKey);
	}
	
	public function idRol()
	{
		return $this->_getSessData('idRol');
	}
	public function idPersona()
	{
		return $this->_getSessData('idPersona');
	}
	public function dniPersona()
	{
		return $this->_getSessData('dniPersona');
	}

	public function usuario()
	{
		return $this->ci->session->userdata('Lib_Aut_Usuario');
	}
	/*
	 ** Agregado para la Sindicatura General de la Provincia
	 */
	public function idMesaEstructura() {
		return $this->_getSessDataMesa('idMesaEstructura');
	}
	public function iudMesaEstructura() {
		return $this->_getSessDataMesa('iudMesaEstructura');
	}
	public function cdsMesaEstructura() {
		return $this->_getSessDataMesa('cdsMesaEstructura');
	}
	public function nombreMesaEstructura() {
		return $this->_getSessDataMesa('nombreMesaEstructura');
	}
	public function idMesaRol() {
		return $this->_getSessDataMesa('idMesaRol');
	}
	/*
	 ** Fin de lo agregado
	 */

	public function logged($boRedirect=true) {
		$logged = $this->ci->session->userdata('auth');
		if(!$logged) {
			if($boRedirect && base_url().$this->opciones['login_uri'] != base_url(). $this->ci->uri->uri_string()){
                $baseurl = base_url();
                $autlogin = $this->opciones['login_uri'];
                echo <<<EOT
<script language="javascript" type="text/javascript">
<!--
top.location = '{$baseurl}{$autlogin}';
// -->
</script>
EOT;
                die();
			}
		}
		return $logged;
	}
	
	public function login($login, $password) {
		$Result = FALSE;
		if($this->opciones['pass_is_md5']===FALSE){
			$password = $this->_crypt($password);
		}
		$rsResult = $this->ci->usuarios->autenticar($login, $password, $this->ci->input->ip_address());
		echo $this->ci->db->last_query();
		try {
			if(!$rsResult) {
				$this->_vcMensajeError = $this->opciones['error_def_msg'];
			}
			else {
				$rsResult = $rsResult;
				if(!empty($rsResult['idUsuario'])) {
					$this->unsetSession();			    
					$this->_setSession($rsResult, $this->_keys);
					$Result = true;
				}
				else {
					switch(strtoupper(($rsResult['idEstado']))) {
						case 3:
							$this->_vcMensajeError = $this->opciones['error_blk_msg'];
							break;
						case 2:
							$this->_vcMensajeError = $this->opciones['error_err_msg'];
							break;
						default:
							if(!empty($rsResult['nombreUsuario'])){
								$inIntentos = 4 - ((int)$rsResult['intentosUsuario']);
								if( $inIntentos > 0){
									$this->_vcMensajeError = sprintf($this->opciones['error_pas_msg'], $inIntentos);
								} else {
									$this->_vcMensajeError = $this->opciones['error_err_msg'];
								}								
							} else {
								$this->_vcMensajeError = $this->opciones['error_def_msg'];
							}
						break;
					}
                    $this->unsetSession();	
				}
			}
		}
		catch(exception $exc) {
			// do nothing form now but kill the session
			$this->logout();
		}
		return $Result;
	}
	
	public function obtenerDatos() {
		return $this->ci->usuarios_model->obtenerDatos($this->idUsuario());
	}
	
	public function logout()
	{
		$this->ci->session->sess_destroy();
	}
	
	public function recuperarPassword($vcUsuLogin, $vcUsuEmail, $vcUsuPass) {
		
		$aParms = array(
			$vcUsuLogin
			, $vcUsuEmail
			, $this->_crypt($vcUsuPass)
			, $this->opciones['chequear_ubicacion']
		);
		
		return $this->ci->usuarios_model->recuperarPassword($aParms);
	}
	
	public function puedeRecuperarPassword($vcUsuLogin, $vcUsuEmail) {
		
		$aParms = array(
			$vcUsuLogin
			, $vcUsuEmail
			, $this->opciones['chequear_ubicacion']
		);
		
		return $this->ci->usuarios_model->puedeRecuperarPassword($aParms);
	}
	
	public function actualizarTokenDeUsuario($inIdUsuario, $vcUsuCodActivacionCta1=null, $vcUsuCodActivacionCta2=null) {
        $FechaUltimaModificacion = substr(base64_decode($vcUsuCodActivacionCta2),-8,8);
        if (trim($FechaUltimaModificacion) != trim(@date("Ymd"))){
            return $this->ci->usuarios_model->modificarTokenUsuario($inIdUsuario, $vcUsuCodActivacionCta1);
        }
        return $vcUsuCodActivacionCta2;
	}
	
	public function crearMenues() {
			
		$this->ci->load->model($this->ci->db->dbdriver.'/lib_autenticacion/roles_model');
		$rs = $this->ci->roles_model->obtener(NULL);
		$boResult = true;
		
		if(sizeof($rs) > 0) {
			foreach($rs as $r) {
				$boResult &= $this->crearMenu($r['idRol']);
			}
		}
		
		return $boResult;
	}
	
	public function crearMenu($inIdRol, $boGetOutPut = false) {
	/**
  	* Crea el menu (mega menu) del segun el array de modulos $rsItemsMenu
  	*/		
  		$this->ci->load->helper('file');
		$this->ci->load->model($this->ci->db->dbdriver.'/lib_autenticacion/rolesmodulos_model');
		$rsItemsMenu = $this->ci->rolesmodulos_model->obtenerPermisosMenu($inIdRol);
		$aRegs = (!empty($rsItemsMenu))? $rsItemsMenu: array();
		$i = 0;
		$n = sizeof($aRegs);
		$sXhtml = '';
		while($i<$n) {
			$sXhtml .= $this->_agregarItemMenu($i, $aRegs);
		}
		
		if($sXhtml!='') {
			$sXhtml = '<?php
$vcBaseUrlAssets = (!empty($vcBaseUrlAssets))?$vcBaseUrlAssets: config_item(\'ext_base_url_assets\');
?><nav><ul id="topnav">'.$sXhtml.'</ul></nav><div class="clearfloat">&nbsp;</div>';
		} else {
			$sXhtml = $this->doRedirect($this->opciones['logout_uri']);
		}
		
		$sFileName = './application/views/'. sprintf($this->opciones['menu_dir_uri'], $inIdRol).'.php';
		
		$boOk = write_file($sFileName, $sXhtml, "w+");
		
		if($boGetOutPut == TRUE) {
			if(!$boOk) {
				return FALSE;
			}
			return str_replace("'", "", $sXhtml);
		} else {
			return $boOk;
		}
	}
	
	public function verificarPermisoUri($vcUri='')
	{
		if($this->opciones['chequear_ubicacion'] == FALSE) {
			return TRUE;
		}
		
		if($vcUri == '') {
			$aSegments = array();
			$aSegments = $this->ci->uri->segment_array();
			
			$realSegments = array();
			 
			if(sizeof($aSegments) == 0) {
				$aSegments[] = strtolower(get_class($this->ci));
			}
			
			$vcUri = implode('/', $aSegments);
		}
		
		return $this->ci->usuarios_model->permisoUri($this->idRol(), $vcUri);
	}
	
	public function verificarPermisosUri($aUri = array())
	{
		$uriValids = array();
		
		$s = new SimpleXMLElement("<?xml version='1.0'?><uris><uri>".base_url()."inicio</uri></uris>");
		
		for($i=0; $i<sizeof($aUri);$i++) {
			$vcUri = $aUri[$i];
			if($this->ci->usuarios_model->permisoUri($this->idRol(), $vcUri)>0) {
				$s->addChild('uri', base_url(). urlencode($aUri[$i]));
			}
		}
		
		return $s->asXML();
	}
	
	public function obtenerPermisosUris(Array $aUri) {
		$idRol = $this->idRol();
		$baseUrl = base_url();
		
		$inUris = sizeof($var);
		
		for($i=0; $i < $inUris; $i++) {
			$aUri[$i] = preg_replace($baseUrl, '', $aUri[$i]);
		}
	}
	
	public function obtenerMenu($aOpciones=array()) {
		$ret = '';
		//echo "aca andamio";
		//echo $this->idRol();
		$viewname = sprintf($this->opciones['menu_dir_uri'],$this->idRol());
		if(file_exists('./application/views/'.$viewname.'.php')) {
			$ret = $this->ci->load->view($viewname, $aOpciones,true);
		} else {
			$this->logout();
			$ret = $this->doRedirect($this->opciones['login_uri']);
		}
		return $ret;
	}
	
	public function barraAcciones($aOpciones=array()) {
		return $this->ci->load->view('menu/barra-acciones-actuacion', $aOpciones, true);
	}

    public function clearSessIdenticas() {
		
    	$config1 = strip_tags($this->opciones['alert_usuario_login_1']);
		$config2 = strip_tags($this->opciones['alert_usuario_login_2']);
    	
		$userId = $this->_serialize(array('inIdUsuario'=>$this->idUsuario()));
		$userId = substr($userId, 5, strlen($userId) - 6);
		
		$iRet = $this->ci->db->like('user_data', $userId, 'both')
							 ->from($this->ci->session->sess_table_name)
							 ->count_all_results();
		if($iRet > 1) {
			$this->ci->db->query(
				$this->ci->db->update_string(
							$this->ci->session->sess_table_name
							, array('user_data'=>$this->_serialize(array('message'=>$config1)))
							, "user_data like '%". $this->ci->db->escape_like_str($userId)."%'"
						)
				);
			echo $this->doRedirect($this->opciones['login_uri'], $config2);
			die();
		}
    }
	
	public function filtrarXHtml($vcXHtml) {
		
		$inIdRol = $this->idRol();
		$this->ci->load->library('lib_permisos');
		return $this->ci->lib_permisos->filtrarPermisosPorRol($vcXHtml, $inIdRol);
	}	
	
	public function escribirPermisosPorRol($inIdRol = 0)
	{
		$inIdRol = ($inIdRol>0)?$inIdRol:0;
		$this->ci->load->model($this->ci->db->dbdriver.'/lib_autenticacion/rolesmodulos_model','rolesmodulos_model');
		$rsItemsMenu = $this->ci->rolesmodulos_model->obtenerPermisosMenu($inIdRol);
		$aRegs = (!empty($rsItemsMenu))? $rsItemsMenu: array();
		$vcNombreArchivo = 'config-permisos/permisosxrol_'.$inIdRol.'.php';
		$iRet = $this->construirArrayPermisos($aRegs,$vcNombreArchivo);
		if($iRet>0)
			return 'La operacion se ejecuto correctamente.';
		elseif ($iRet==(-1)) {
			return 'No se encontraron permisos para el rol seleccionado.';
		} else {
			return 'Ha ocurrido un error durante el proceso.';
		}
						
	}
	public function construirArrayPermisos($aPermisos,$vcNombreArchivo)
	{
		$iRet = 0;
		if (sizeof($aPermisos)>0){
			$fp = fopen($vcNombreArchivo, 'w+');
			fwrite($fp, serialize($aPermisos)); 
			fclose($fp);
			$iRet = 1;		
		} else {
			$iRet = -1;
		}
		return $iRet;
	}
	public function leerArrayPermisosPorRol($inIdRol = 0)
	{
		$vcNombreArchivo = 'config-permisos/permisosxrol_'.$inIdRol.'.php';
		if (file_exists($vcNombreArchivo)) {
			$inIdRol = ($inIdRol>0)?$inIdRol:0;
			$array = unserialize(file_get_contents($vcNombreArchivo)); 
		    $mensaje = $array;
		} else {
		    $mensaje = "El archivo asociado al rol seleccionado no existe";
		}		
		return $mensaje;
	}
	/**
	 * Agregado para la Sindicatura General de la Provincia
	 */
	public function validar($idMesa) {
		$Result = FALSE;
		$this->ci->load->model('sigep/mesas_model', 'mesas');
		$rsResult = $this->ci->mesas->validar($idMesa);
		try {
			if(!$rsResult) {
				$this->_vcMensajeError = $this->opciones['error_def_msg'];
			}
			else {
				$rsResult = $rsResult;
				$this->_setSessionMesa($rsResult);
				$Result = true;
			}
		}
		catch(exception $exc) {
			$this->logout();
		}
		return $Result;
	}
	/**
	 * Fin de agregado
	 */
}