<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Licencias Model
 * 
 * @package HITS
 * @copyright 2013
 * @version MySql 1.0.0
 * 
 */
class Licencias_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * 
                FROM sigep_view_agentes a
                INNER JOIN sigep_agentes_licencias al ON a.idAgente = al.idAgente
                INNER JOIN sigep_licencias l ON al.idLicencia = l.idLicencia
                WHERE nombreCompletoPersona LIKE ?
                AND NOW() BETWEEN desdeAgenteLicencia AND hastaAgenteLicencia
                limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idAgenteLicencia) AS inCant
                FROM sigep_view_agentes a
                INNER JOIN sigep_agentes_licencias al ON a.idAgente = al.idAgente
                INNER JOIN sigep_licencias l ON al.idLicencia = l.idLicencia
                WHERE nombreCompletoPersona LIKE ?
                AND NOW() BETWEEN desdeAgenteLicencia AND hastaAgenteLicencia;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }

    public function obtenerUno($id) {
        $sql = 'SELECT * 
                FROM sigep_view_agentes a
                INNER JOIN sigep_agentes_licencias al ON a.idAgente = al.idAgente
                INNER JOIN sigep_licencias l ON al.idLicencia = l.idLicencia
                WHERE idAgenteLicencia = ?';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }

    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_agentes_licencias_guardar(?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'UPDATE sigep_cargos SET estadoCargo = 0  WHERE idCargo = '.$id.';';
        $result = $this->db->query($sql, array($id));
        return 1;
    }

    public function usufructuados($idAgente, $idLicencia, $idAgenteLicencia=0) {
        $agenteLicencia = ($idAgenteLicencia==0)? '':' AND idAgenteLicencia <> '.$idAgenteLicencia;
        $sql = 'SELECT SUM(cantidadAgenteLicencia) AS usufructuados
                FROM sigep_agentes_licencias
                WHERE idAgente = ? AND idLicencia = ? '.$agenteLicencia.';';
        $result = $this->db->query($sql, array((int) $idAgente, (int) $idLicencia))->result_array();
        return $result[0]['usufructuados'];
    }

    public function dropdownLicencias() {
        $sql = 'SELECT * FROM sigep_licencias WHERE estadoLicencia = 1;';
        $query = $this->db->query($sql)->result();
        foreach($query as $row) {
            $funciones[$row->idLicencia] = $row->nombreLicencia; 
        }
        return $funciones;
    }

    public function obtenerAutocompleteCargos($vcBuscar) {
        $sql = 'SELECT *
            FROM sigep_view_cargos
            WHERE denominacionCargo LIKE ?';
        $query = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%'));
        if($query->num_rows > 0){
            foreach ($query->result_array() as $row){
                $new_row['label']=htmlentities(stripslashes($row['denominacionCargo']));
                $new_row['value']=htmlentities(stripslashes($row['denominacionCargo']));
                $new_row['id']=htmlentities(stripslashes($row['idCargo']));
                $row_set[] = $new_row; //build an array
            }
            echo json_encode($row_set);
        }
    }
    /**
    ***
    **/
    public function obtenerLicencias($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM sigep_licencias
            WHERE nombreLicencia LIKE ? 
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegsLicencias($vcBuscar) {
        $sql = 'SELECT count(idLicencia) AS inCant FROM sigep_view_licencias WHERE lower(nombreLicencia) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUnoLicencia($id) {
        $sql = 'SELECT * 
                FROM sigep_licencias
                WHERE idLicencia = ?';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }


    public function novedadesLicencias() {
        $nuevo = array();
        $cantidades = array();
        $legend = array();
        $completo['cantidad'] = array();
        $completo['licencia'] = array();
        $sql = 'SELECT * FROM sigep_licencias WHERE estadoLicencia = 1;';
        $query = $this->db->query($sql)->result();
        foreach($query as $row) {
            $sql2 = 'SELECT COUNT(*) as cantidad
            FROM sigep_agentes_licencias 
            WHERE idLicencia = ? AND NOW() BETWEEN desdeAgenteLicencia AND hastaAgenteLicencia;';
            $nuevo = $this->db->query($sql2, $row->idLicencia)->result_array();
            array_push($completo['cantidad'], (int) $nuevo[0]['cantidad']);
            $completo['licencia'][] = $row->nombreLicencia;
        }
        //$completo['cantidad'] = array_shift($completo['cantidad']);
        return $completo;
    }
}

// EOF cargos_model.php