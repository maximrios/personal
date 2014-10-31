<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Feriados_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM sigep_feriados
            WHERE motivoFeriado LIKE ?
            AND fechaFeriado > NOW()
            ORDER BY fechaFeriado ASC
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idFeriado) AS inCant FROM sigep_feriados WHERE motivoFeriado LIKE ? AND fechaFeriado > NOW();';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM sigep_feriados WHERE idFeriado = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function guardar($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO sigep_feriados
                    (fechaFeriado
                    , motivoFeriado) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'");';
            $type = 1;
        }
        else {
            $sql = 'UPDATE sigep_feriados SET 
                    fechaFeriado = "'.$aParms[1].'"
                    , motivoFeriado = "'.$aParms[2].'"
                    WHERE idFeriado = '.$aParms[0].';';
            $type = 2;
        }
        $result = $this->db->query($sql);
        if($type==1){
            return $this->db->insert_id();
        }
        else {
            return true;
        }
    }
    public function eliminar($id) {
        $sql = 'DELETE FROM sigep_feriados WHERE idFeriado = ?;';
        $result = $this->db->query($sql, array($id));
        return TRUE;
    }
}