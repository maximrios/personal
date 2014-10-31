<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Datos_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_clientes
            WHERE nombreContacto LIKE ? 
            ORDER BY fechaContacto DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idContacto) AS inCant FROM hits_clientes WHERE lower(CONCAT_WS(" ", nombreContacto)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno() {
        $sql = 'SELECT * FROM hits_clientes WHERE idCliente = 1;';
        return array_shift($this->db->query($sql)->result_array());
    }
    public function guardar($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_clientes
                    (nombreCliente
                    , domicilioCliente
                    , telefonoCliente
                    , celularCliente
                    , emailCliente) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'"
                    , "'.$aParms[4].'"
                    , "'.$aParms[5].'");';
            $type = 1;
        }
        else {
            $sql = 'UPDATE hits_clientes SET 
                    nombreCliente = "'.$aParms[1].'"
                    , domicilioCliente = "'.$aParms[2].'"
                    , telefonoCliente = "'.$aParms[3].'"
                    , celularCliente = "'.$aParms[4].'"
                    , emailCliente = "'.$aParms[5].'"
                    WHERE idCliente = '.$aParms[0].';';
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
        $sql = 'DELETE FROM hits_contactos WHERE idContacto = ?;';
        $result = $this->db->query($sql, array($id));
        return TRUE;
    }
}

// EOF noticias_model.php