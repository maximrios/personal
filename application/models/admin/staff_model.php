<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Staff_model extends CI_Model {
    function __construct() {
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *, CONCAT_WS(", ", apellidoPersona, nombrePersona) AS completoPersona
            FROM hits_personas
            WHERE nombrePersona LIKE ? 
            ORDER BY apellidoPersona DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerNoticias($limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_noticias
            WHERE publicadoNoticia = 1
            ORDER BY inicioNoticia DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array((double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar) {
        $sql = 'SELECT count(idPersona) AS inCant FROM hits_personas WHERE lower(CONCAT_WS(" ", apellidoPersona, nombrePersona)) LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM hits_noticias WHERE idNoticia = ?;';
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
                    , emailEvento) 
                    VALUES
                    ("'.$aParms[1].'"
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'"
                    , "'.$aParms[4].'"
                    , "'.$aParms[5].'"
                    , "'.$aParms[6].'"
                    , "'.$aParms[7].'");';
            $type = 1;
        }
        else {
            $sql = 'UPDATE hits_noticias SET 
                    tituloNoticia = "'.$aParms[1].'"
                    , epigrafeNoticia = "'.$aParms[2].'"
                    , descripcionNoticia = "'.$aParms[3].'"
                    , inicioNoticia = "'.$aParms[4].'"
                    , vencimientoNoticia = "'.$aParms[5].'"
                    , uriNoticia = "'.$aParms[6].'"
                    , publicadoNoticia = '.$aParms[7].'
                    WHERE idNoticia = '.$aParms[0].';';
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
    public function guardarImagen($aParms) {
        /*if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO sabandijas_productos_imagenes
                    (idProducto
                    , pathProductoImagen
                    , detailProductoImagen
                    , thumbProductoImagen
                    , thumbdetailProductoImagen) 
                    VALUES
                    ('.$aParms[1].'
                    , "'.$aParms[2].'"
                    , "'.$aParms[3].'"
                    , "'.$aParms[4].'"
                    , "'.$aParms[5].'");';
        }
        else {
            $sql = 'UPDATE sabandijas_productos_imagenes SET 
                    checkProductoImagen = '.$aParms[6].'
                    WHERE idProductoImagen = pidProductoImagen;';
        }
        $result = $this->db->query($sql, $aParms);
        return $this->db->insert_id();*/
        $sql = 'UPDATE hits_noticias SET 
            thumbImagenNoticia = "'.$aParms[1].'"
            , detailImagenNoticia = "'.$aParms[2].'"
            WHERE idNoticia = '.$aParms[0].';';
        $result = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function cambiarEstado($aParms) {
        $sql = 'UPDATE hits_noticias SET publicadoNoticia = ? WHERE idNoticia = ?;';
        $result = $this->db->query($sql, $aParms);
        return TRUE;   
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }

    public function dropdownNoticiasTipos() {
        $sql = 'SELECT * FROM hits_tipo_noticias';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un item ...';
        foreach($query as $row) {
            $subgrupos[$row->idTipoNoticia] = $row->nombreTipoNoticia; 
        }
        return $subgrupos;
    }

    /*
     * Comentarios
     */
    public function obtenerComentario($comentario) {
        $sql = "SELECT * FROM hits_view_noticias_comentarios 
        WHERE idNoticiaComentario = ?";
        return array_shift($this->db->query($sql, array($comentario))->result_array());
    }
    public function obtenerComentarios($noticia) {
        $sql = "SELECT * FROM hits_view_noticias_comentarios 
        WHERE idNoticia = ?
        ORDER BY fechaNoticiaComentario DESC
        LIMIT 0, 5";
        return $this->db->query($sql, $noticia)->result_array();
    }
    public function guardarComentario($aParams) {
        $sql = 'SELECT hits_sp_noticia_comentario_guardar(?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParams)->result_array();
        return $result[0]['result'];
    }
}

// EOF noticias_model.php