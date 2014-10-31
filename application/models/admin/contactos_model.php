<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contactos_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_contactos
            WHERE nombreContacto LIKE ? 
            ORDER BY fechaContacto DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idContacto) AS inCant FROM hits_contactos WHERE lower(CONCAT_WS(" ", nombreContacto)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_contactos WHERE idContacto = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function guardar($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_eventos
                    (nombreEvento
                    , descripcionEvento
                    , fechaDesdeEvento
                    , fechaHastaEvento
                    , domicilioEvento
                    , telefonoEvento
                    , emailEvento
                    , uriEvento) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'"
                    , "'.$aParms[4].'"
                    , "'.$aParms[5].'"
                    , "'.$aParms[6].'"
                    , "'.$aParms[7].'"
                    , "'.$aParms[8].'");';
            $type = 1;
        }
        else {
            $sql = 'UPDATE hits_eventos SET 
                    nombreEvento = "'.$aParms[1].'"
                    , descripcionEvento = "'.$aParms[2].'"
                    , fechaDesdeEvento = "'.$aParms[3].'"
                    , fechaHastaEvento = "'.$aParms[4].'"
                    , domicilioEvento = "'.$aParms[5].'"
                    , telefonoEvento = "'.$aParms[6].'"
                    , emailEvento = "'.$aParms[7].'"
                    , uriEvento = "'.$aParms[8].'"
                    WHERE idEvento = '.$aParms[0].';';
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