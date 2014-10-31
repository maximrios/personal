<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Galerias_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_galerias
            WHERE nombreGaleria LIKE ? 
            ORDER BY nombreGaleria DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idGaleria) AS inCant FROM hits_galerias WHERE lower(CONCAT_WS(" ", nombreGaleria)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_galerias WHERE idGaleria = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function obtenerUnoNombre($nombre) {
        $sql = 'SELECT * FROM hits_galerias WHERE nombreGaleria = ?;';
        return array_shift($this->db->query($sql, array($nombre))->result_array());
    }
    public function guardar($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_galerias
                    (nombreGaleria
                    , uriGaleria
                    , pathGaleria) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'");';
            $type = 1;
        }
        else {
            $sql = 'UPDATE hits_galerias SET 
                    nombreGaleria = "'.$aParms[1].'"
                    WHERE idGaleria = '.$aParms[0].';';
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
        $sql = 'DELETE FROM hits_eventos WHERE idEvento = ?;';
        $result = $this->db->query($sql, array($id));
        return TRUE;
    }

    public function obtenerImagenes($idGaleria) {
        $sql = 'SELECT *
            FROM hits_galerias_media
            WHERE idGaleria = ?;';
        return $this->db->query($sql, $idGaleria)->result_array();
    }
    public function obtenerUnoImagen($id) {
        $sql = 'SELECT * FROM hits_galerias_media WHERE idGaleriaMedia = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function guardarImagen($aParms) {
        $sql = 'INSERT INTO hits_galerias_media
                (nombreGaleriaMedia
                , pathGaleriaMedia
                , thumbGaleriaMedia
                , tipoGaleriaMedia
                , idGaleria)
                VALUES 
                ("'.$aParms[0].'"
                , "'.$aParms[1].'"
                , "'.$aParms[2].'"
                , "'.$aParms[3].'"
                , "'.$aParms[4].'");';
        $result = $this->db->query($sql);
        return $this->db->insert_id();
    }
    public function eliminarImagen($id) {
        $sql = 'DELETE FROM hits_galerias_media WHERE idGaleriaMedia = ?;';
        $result = $this->db->query($sql, array($id));
        return TRUE;
    }
    public function truncateImagen($aParms) {
        $sql = 'UPDATE hits_galerias_media SET checkGaleriaMedia = 0 WHERE idGaleria = ?;';
    }
    /*public function predeterminarImagen($aParms) {
        $sql = 'SELECT * FROM hits_galerias_media WHERE idGaleria = ? AND checkGaleriaMedia = 1;';
        $result = $this->db->query($sql, $aParms);
        if(!$result) {
            $sql2 = 'UPDATE hits_galerias_media SET checkGaleriaMedia = 1 WHERE idGaleria = ? AND idGaleriaMedia = ?;'
        }
    }*/

    

}

// EOF noticias_model.php