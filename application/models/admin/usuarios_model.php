<?php
Class Usuarios_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function autenticar($vcLogin, $vcPass, $vcIp) {
        $aParms = array(
            $vcLogin
            , $vcPass
            , $vcIp
        );
        $query = 'SELECT u.idUsuario, u.idPersona, r.idRol, u.idEstado, u.nombreUsuario, u.passwordUsuario, u.intentosUsuario, u.ultimoLoginUsuario, r.nombreRol, ue.nombreEstado, p.dniPersona, p.apellidoPersona, p.nombrePersona, a.idAgente
            FROM hits_usuarios u
            INNER JOIN hits_usuarios_roles ur ON ur.idUsuario = u.idUsuario
            INNER JOIN hits_roles r ON r.idRol = ur.idRol
            INNER JOIN hits_usuarios_estados ue ON ue.idEstado = u.idEstado
            INNER JOIN hits_personas p ON p.idPersona = u.idPersona
            INNER JOIN sigep_agentes a ON a.idPersona = p.idPersona
            WHERE nombreUsuario = ? AND passwordUsuario = ?;';
        $result = $this->db->query($query, $aParms)->result_array();
        return (sizeof($result) > 0) ? $result[0] : false;
    }
    public function permisosUriPorRol($inIdUsuario) {
        $aParms = array(
            $inIdUsuario
        );
        $query = 'CALL ufn30tsegusuariosobtpermisosuri(? );';
        return $this->db->query($query, $aParms)->result_array();
    }
    public function permisoUri($inIdRol, $vcModUri) {
        $vcModUri = trim($vcModUri);
        if ($vcModUri == '')
            return FALSE;
        $aParms = array(
            $inIdRol
            , $vcModUri
        );
        $query = 'select ufn30tsegusuariosobtpermisouri(?, ?) as iRet ;';
        $result = $this->db->query($query, $aParms)->result_array();
        return (bool) ($result[0]['iRet'] > 0);
    }
    public function obtenerDatos($id) {
        $query = 'CALL hits_sp_usuarios_obtener(? );';
        $aRegs = $this->db->query($query, array($id))->result_array();
        if (sizeof($aRegs) == 0) {
            return FALSE;
        }
        return $aRegs[0];
    }

    public function obtenerDatosPorCodActivacionCta($vcUsuLogin) {

        $query = 'SELECT inIdUsuario, vcUsuCodActivacionCta 
                            FROM tsegusuarios 
                            WHERE vcUsuLogin = ? 
                                AND vcUsuEmail = ? 
                            LIMIT 1 ;';
        $aRegs = $this->db->query($query, array($vcUsuLogin, $vcUsuEmail))->result_array();

        if (sizeof($aRegs) == 0) {
            return FALSE;
        }
        return $aRegs[0];
    }

    public function obtenerDatosPorUsuarioAndEmail($vcUsuLogin, $vcUsuEmail) {

        $query = 'SELECT inIdUsuario, vcUsuCodActivacionCta
                            FROM tsegusuarios
                            WHERE vcUsuLogin = ? 
                                AND vcUsuEmail = ? 
                            LIMIT 1 ';
        $aRegs = $this->db->query($query, array($vcUsuLogin, $vcUsuEmail))->result_array();

        if (sizeof($aRegs) == 0) {
            return FALSE;
        }
        return $aRegs[0];
    }

    public function modificarTokenUsuario($inIdUsuario, $vcUsuCodActivacionCta) {
        $query = 'UPDATE tsegusuarios
                            SET vcUsuCodActivacionCta = ? 
                            WHERE inIdUsuario = ? ;';
        $aRegs = $this->db->query($query, array($vcUsuCodActivacionCta, $inIdUsuario));
        return $vcUsuCodActivacionCta;
    }

    public function guardarPerfil($aParms) {
        $sql = 'SELECT ufn30tsegusuariosguardarperfil(? ,? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function getUserByIdPassword($idUsuario, $passwordUsuario) {
        $sql = 'SELECT * FROM hits_usuarios WHERE idUsuario = ? AND passwordUsuario = ? ';
        $result = $this->db->query($sql, array((int) $idUsuario, (string) $passwordUsuario))->result_array();
        return array_shift($result);
    }
    public function setPassword($aParms) {
        $sql = 'UPDATE hits_usuarios SET passwordUsuario = ? WHERE idUsuario = ?';
        $result = $this->db->query($sql, $aParms)->result_array();
        echo $this->db->last_query();
        return $result[0]['result'];
    }

    public function cambiarPin($aParms) {
        $sql = 'SELECT ufn30tsegusuarioscambiarpin(? ,? ,?, ? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function guardarPass($parametros) {
        $sql = 'SELECT ufn30tsegusuariosmodificarpass(? ,? ) as result;';
        $result = $this->db->query($sql, $parametros)->result_array();
        return $result[0]['result'];
    }

    public function recuperarPassword($aParms) {
        $query = 'SELECT ufn30tsegusuariosrecuperarpassword(? ,? ,? ,? ) as result;';
        $result = $this->db->query($query, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function puedeRecuperarPassword($aParms) {
        $query = 'SELECT ufn30tsegusuariospuederecuperarpassword(? ,? ,? ) as result;';
        $result = $this->db->query($query, $aParms)->result_array();

        return $result[0]['result'];
    }

    public function desbloquearPin($aParms) {
        $sql = 'SELECT ufn30tsegusuariosdesbloquearpin(? ,? ,? ) as result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function numSessIdenticas($vcNombre, $tablename) {
        $sql = "SELECT count(*) as inCant 
                        FROM " . lower($tablename) . " 
                        WHERE lower(user_data) LIKE lower('%s:11:\"inIdUsuario\";s:" . strlen($vcNombre) . ":\"" . $vcNombre . "\";%');";

        $result = $this->db->query($sql)->result_array();

        if ($result[0]['incant'] > 1) {
            $config1 = strip_tags(config_item('lib_autenticacion_alert_usuario_login_1'));

            $config2 = strip_tags(config_item('lib_autenticacion_alert_usuario_login_2'));
            $sql = "UPDATE " . lower($tablename) . "
                    SET user_data = 'a:1:{s:7:\"message\";s:" . strlen($config1) . ":\"" . $config1 . "\";}'
                    WHERE lower(user_data) LIKE lower('%s:11:\"inIdUsuario\";s:" . strlen($vcNombre) . ":\"" . $vcNombre . "\";%')";
            $this->db->query($sql);
            $CI = & get_instance();
            $CI->session->set_userdata(array('message' => $config2));
        }

        return $result[0]['incant'];
    }

}