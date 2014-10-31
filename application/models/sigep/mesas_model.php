<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
Class Mesas_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($idAgente, $limit = 0, $offset = 9999999) {
        $sql = 'SELECT idMesaUsuario, nombreEstructura, nombreMesaRol FROM sigep_mesas_usuarios m
        INNER JOIN sigep_mesas_roles r ON m.idMesaRol = r.idMesaRol
        INNER JOIN sigep_estructuras e ON m.idEstructura = e.idEstructura
        WHERE idAgente = ?
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array((int) $idAgente, (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUno($idMesaUsuario) {
        $sql = 'SELECT * 
                FROM sigep_mesas_usuarios
                WHERE idMesaUsuario = ?;';
        return array_shift($this->db->query($sql, array($idMesaUsuario))->result_array());
    }
    public function numRegs($idAgente) {
        $sql = 'SELECT count(idMesaUsuario) AS inCant FROM sigep_mesas_usuarios m
        INNER JOIN sigep_mesas_roles r ON m.idMesaRol = r.idMesaRol
        INNER JOIN sigep_estructuras e ON m.idEstructura = e.idEstructura
        WHERE idAgente = ?';
        $result = $this->db->query($sql, array((int) $idAgente))->result_array();
        return $result[0]['inCant'];
    }
    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_mesas_guardar(?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function eliminar($idMesaUsuario) {
        $sql = 'DELETE FROM sigep_mesas_usuarios WHERE idMesaUsuario = ?';
        $result = $this->db->query($sql, array($idMesaUsuario));
        return TRUE;
    }
    public function obtenerTipos($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $tipo = 1;
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        $sql = 'SELECT * 
        FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? 
        ORDER BY fechaInstrumentoLegal DESC 
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegsTipos($vcBuscar, $tipo=0) {
        ($tipo == 0)? $tipo = '':$tipo = 'AND idTipoInstrumento = '.$tipo.' ';
        $sql = 'SELECT count(idInstrumentoLegal) AS inCant FROM sigep_view_instrumentoslegales 
        WHERE busqueda LIKE ? '.$tipo.';';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function validar($idMesa) {
        $query = 'SELECT u.idMesaUsuario, a.idAgente, e.idEstructura AS idMesaEstructura,  e.cdsEstructura AS cdsMesaEstructura, e.iudEstructura AS iudMesaEstructura, e.nombreEstructura AS nombreMesaEstructura, r.idMesaRol, r.nombreMesaRol
        FROM sigep_mesas_usuarios u
        INNER JOIN sigep_mesas_roles r ON u.idMesaRol = r.idMesaRol
        INNER JOIN sigep_agentes a ON u.idAgente = a.idAgente
        INNER JOIN sigep_estructuras e ON u.idEstructura = e.idEstructura 
        WHERE idMesaUsuario = ?';
        $result = $this->db->query($query, array((int) $idMesa))->result_array();
        return (sizeof($result) > 0) ? $result[0] : false;
    }
    public function dropdownMesas($idAgente) {
        $sql = 'SELECT u.idMesaUsuario, a.idAgente, e.idEstructura, e.nombreEstructura 
        FROM sigep_mesas_usuarios u
        INNER JOIN sigep_agentes a ON u.idAgente = a.idAgente
        INNER JOIN sigep_estructuras e ON u.idEstructura = e.idEstructura
        WHERE a.idAgente = ? ';
        $query = $this->db->query($sql, array((int) $idAgente))->result();
        $mesas[0] = 'Seleccione una mesa para operar ...';
        foreach($query as $row) {
            $mesas[$row->idMesaUsuario] = $row->nombreEstructura; 
        }
        return $mesas;
    }
    public function dropdownRoles() {
        $sql = 'SELECT idMesaRol, nombreMesaRol
        FROM sigep_mesas_roles';
        $query = $this->db->query($sql)->result();
        $mesas[0] = 'Seleccione una rol para operar ...';
        foreach($query as $row) {
            $mesas[$row->idMesaRol] = $row->nombreMesaRol; 
        }
        return $mesas;
    }
}