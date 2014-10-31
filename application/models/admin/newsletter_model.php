<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *, CONCAT_WS(", ", apellidoPersona, nombrePersona) AS completoPersona
            FROM hits_personas
            WHERE nombrePersona LIKE ?
            AND newsletterPersona = 1 
            ORDER BY apellidoPersona DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idPersona) AS inCant FROM hits_personas WHERE lower(CONCAT_WS(" ", apellidoPersona, nombrePersona)) LIKE ? AND newsletterPersona = 1;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_personas WHERE idPersona = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function guardar($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_personas
                    (nombrePersona
                    , apellidoPersona
                    , emailPersona
                    , newsletterPersona) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'"
                    , '.$aParms[4].');';
            $type = 1;
        }
        else {
            $sql = 'UPDATE hits_personas SET 
                    nombrePersona = "'.$aParms[1].'"
                    , apellidoPersona = "'.$aParms[2].'"
                    , emailPersona = "'.$aParms[3].'"
                    WHERE idPersona = '.$aParms[0].';';
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
        $sql = 'UPDATE hits_personas SET newsletterPersona = 0 WHERE idPersona = ?';
        $result = $this->db->query($sql, array($id));
        return TRUE;
    }
}