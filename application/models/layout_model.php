<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Layout_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function datos() {
        $sql = 'SELECT * FROM hits_clientes WHERE idCliente = 1;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function obtener($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM rosobe_view_categorias
            WHERE nombreCategoria LIKE ? 
            ORDER BY nombreCategoria ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function numRegs($vcBuscar, $area=1, $cargo=0) {
        $sql = 'SELECT count(idCategoria) AS inCant FROM rosobe_view_categorias WHERE lower(nombreCategoria) LIKE ? ';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * FROM rosobe_view_categorias WHERE idCategoria = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function guardar($aParms) {
        $sql = 'SELECT rosobe_sp_categorias_guardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }

    public function eliminar($id) {
        $sql = 'SELECT ufn30tsisprovinciasborrar(?) AS result;';
        $result = $this->db->query($sql, array($id))->result_array();
        return $result[0]['result'];
    }
    function obtenerSlider() {
        $sql = 'SELECT * FROM sabandijas_slider WHERE activoSlider = 1 AND NOW() BETWEEN vigenciaDesde AND vigenciaHasta';
        return $this->db->query($sql)->result_array();
    }
    /**
     * Eventos
     */
    public function obtenerEventos() {
        $sql = 'SELECT * FROM hits_eventos
        ORDER BY fechaDesdeEvento DESC';
        return $this->db->query($sql)->result_array();
    }
    public function obtenerEventosUno($id) {
        $sql = 'SELECT * FROM hits_eventos WHERE idEvento = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    /**
     * Programas
     */
    public function obtenerProgramas() {
        $sql = 'SELECT * FROM hits_programas 
        WHERE estadoPrograma = 1';
        return $this->db->query($sql)->result_array();
    }
    public function obtenerProgramasUno($id) {
        $sql = 'SELECT * FROM hits_programas WHERE idPrograma = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    /**
     * Productos
     */
    function obtenerProductos($categoria=0, $limit = 0, $offset=9999999) {
        ($categoria == 0)? $and='':$and='AND idCategoria = '.$categoria;
        $sql = 'SELECT * FROM sabandijas_view_productos WHERE publicadoProducto = 1 AND checkProductoImagen = 1 '.$and.' GROUP BY idProducto
            LIMIT ? offset ?';
        return $this->db->query($sql, array((int) $limit, (int) $offset))->result_array();
    }
    function numRegsProductosFind($vcBuscar = '') {
        $sql = 'SELECT count(distinct(pi.idProducto)) AS inCant FROM sabandijas_productos p 
        INNER JOIN sabandijas_productos_imagenes pi ON p.idProducto = pi.idProducto
        WHERE CONCAT_WS(" ", nombreProducto, codigoProducto, descripcionProducto) LIKE ? AND p.estadoProducto = 1 AND p.publicadoProducto = 1';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        if($result)
            return $result[0]['inCant'];
        else
            return false;
    }
    public function obtenerProductosFind($vcBuscar = '', $categoria=0, $limit = 9999999, $offset = 0) {
        $sql = 'SELECT *
            FROM sabandijas_view_productos
            WHERE CONCAT_WS(" ", nombreProducto, codigoProducto, descripcionProducto) LIKE ? AND publicadoProducto = 1 AND estadoProducto = 1 AND checkProductoImagen = 1
            GROUP BY idProducto
            ORDER BY nombreProducto ASC  
            limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (int) $limit, (int) $offset))->result_array();
    }
    function numRegsProductos($vcBuscar = '', $categoria = 0) {
        $and = ($categoria == 0)? '':' AND idCategoria = '.$categoria;
        $sql = 'SELECT count(DISTINCT(cp.idProducto)) AS inCant 
        FROM sabandijas_productos p
        INNER JOIN sabandijas_categorias_productos cp ON p.idProducto = cp.idProducto
        WHERE lower(nombreProducto) LIKE ? 
        AND publicadoProducto = 1 AND estadoProducto = 1
        '.$and.' ';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        if($result)
            return $result[0]['inCant'];
        else
            return false;
    }
    function numRegsProductosM($vcBuscar = '', $categoria = 0) {
        ($categoria == 0)? $and='':$and=' AND idCategoria = '.$categoria;
        $sql = 'SELECT count(distinct(pi.idProducto)) AS inCant FROM sabandijas_productos p 
        INNER JOIN sabandijas_productos_imagenes pi ON p.idProducto = pi.idProducto
        WHERE p.estadoProducto = 1 AND p.publicadoProducto = 1';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        if($result)
            return $result[0]['inCant'];
        else
            return false;
    }
    public function obtenerProductoId($idProducto) {
        $sql = 'SELECT * FROM sabandijas_view_productos WHERE idProducto = ?;';
        return array_shift($this->db->query($sql, array($idProducto))->result_array());
    }
    /**
     * Fin de Productos
     */
    public function obtenerCategoriaSlug($slug) {
        $sql = 'SELECT * FROM sabandijas_view_categorias WHERE uriCategoria = ?;';
        return array_shift($this->db->query($sql, array($slug))->result_array());
    }
    public function obtenerCategoriaId($slug) {
        $sql = 'SELECT * FROM sabandijas_view_categorias WHERE idCategoria = ?;';
        return array_shift($this->db->query($sql, array($slug))->result_array());
    }
    public function dropdownProductosColores($idProducto) {
        $sql = 'SELECT * FROM sabandijas_productos_colores pc INNER JOIN sabandijas_colores c ON pc.idColor = c.idColor
        WHERE idProducto = ? GROUP BY nombreColor';
        $query = $this->db->query($sql, (int) $idProducto)->result();
        $colores[0] = 'Seleccione un color ...';
        foreach($query as $row) {
            $colores[$row->idColor] = $row->nombreColor; 
        }
        return $colores;
    }
    /**
     * Categorias
     */
    public function obtenerCategorias($idCategoria=0, $limit = 0, $offset = 9999999) {
        $categorias = ($idCategoria==0)? ' WHERE c.idCategoria NOT IN (select idSubcategoria from sabandijas_categorias_relaciones)':' INNER JOIN sabandijas_categorias_relaciones cr ON c.idCategoria = cr.idSubcategoria AND cr.idCategoria = '.$idCategoria;
        $limite = ($limit==0)? '': 'limit '.$limit.' offset '.$offset.' ';
        $sql = 'SELECT c.idCategoria, c.nombreCategoria, c.pathCategoria, c.uriCategoria
                FROM sabandijas_categorias c
                '.$categorias.'
                ORDER BY nombreCategoria
                '.$limite.';';
        return $this->db->query($sql)->result_array();
    }
    public function obtenerCategoriasInicio($limit = 0, $offset = 9999999) {
        $sql = 'SELECT c.idCategoria, c.nombreCategoria, i.thumbProductoImagen, c.uriCategoria 
        FROM sabandijas_categorias c
        INNER JOIN sabandijas_categorias_productos cp ON c.idCategoria = cp.idCategoria
        INNER JOIN sabandijas_productos_imagenes i ON cp.idProducto = i.idProducto AND i.checkProductoImagen = 1 
        WHERE c.idCategoria NOT IN (SELECT idSubcategoria FROM sabandijas_categorias_relaciones cr)
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array((int) $limit, (int) $offset))->result_array();
    }
    public function numRegsCategoriasInicio() {
        $sql = 'SELECT count(c.idCategoria) as inCant
                FROM sabandijas_categorias c';
        $result = $this->db->query($sql)->result_array();
        return $result[0]['inCant'];
    }
    public function numRegsCategorias($idCategoria=0) {
        $categorias = ($idCategoria==0)? ' WHERE c.idCategoria NOT IN (select idSubcategoria from sabandijas_categorias_relaciones)':' INNER JOIN sabandijas_categorias_relaciones cr ON c.idCategoria = cr.idSubcategoria AND cr.idCategoria = '.$idCategoria;
        $sql = 'SELECT count(c.idCategoria) as inCant
                FROM sabandijas_categorias c
                '.$categorias.' ';
        $result = $this->db->query($sql)->result_array();
        return $result[0]['inCant'];
    }
    /**
     * Fin Categorias
     */
    public function obtenerImagenes($id) {
        $sql = 'SELECT * FROM sabandijas_productos_imagenes WHERE idProducto = ? ORDER BY checkProductoImagen DESC;';
        return $this->db->query($sql, (int) $id)->result_array();
    }
    public function eliminarCategoriasProducto($idProducto) {
        $sql = 'DELETE FROM rosobe_categorias_productos WHERE idProducto = ?;';
        $this->db->query($sql, (int) $idProducto);
        return $this->db->affected_rows();
    }

    public function guardarCategoriasProducto($aParms) {
        $sql = 'INSERT INTO rosobe_categorias_productos(idCategoria, idProducto) VALUES (?, ?);';
        $this->db->query($sql, $aParms);
        return $this->db->affected_rows();
    }
    public function obtenerFormasPagos() {
        $sql = 'SELECT *
                FROM sabandijas_formas_pagos;';
        return $this->db->query($sql)->result_array();
    }
    /**
     * Noticias
     */
    public function obtenerNoticias($limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_noticias
            WHERE estadoNoticia = 1
            ORDER BY fechaDesdeNoticia DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array((int) $offset, (int) $limit))->result_array();
    }
    public function numRegsNoticias() {
        $sql = 'SELECT count(idNoticia) AS inCant FROM hits_noticias WHERE estadoNoticia = 1';
        $result = $this->db->query($sql)->result_array();
        return $result[0]['inCant'];
    }
    public function obtenerNoticiaId($idNoticia) {
        $sql = 'SELECT * FROM hits_noticias WHERE idNoticia = ?;';
        return array_shift($this->db->query($sql, array($idNoticia))->result_array());
    }
    /**
     * Galerias
     */
    public function obtenerGalerias($limit = 0, $offset = 9999999) {
        $sql = 'SELECT *
            FROM hits_galerias g
            INNER JOIN hits_galerias_media m on g.idGaleria = m.idGaleria
            WHERE m.checkGaleriaMedia = 1
            ORDER BY nombreGaleria DESC  
            limit ? offset ? ;';
        return $this->db->query($sql, array((int) $offset, (int) $limit))->result_array();
    }
    public function obtenerGaleriaUno($idGaleria) {
        $sql = 'SELECT *
            FROM hits_galerias g
            WHERE idGaleria = ?;';
        return array_shift($this->db->query($sql, array($idGaleria))->result_array());
    }
    public function obtenerGaleriaMedia($idGaleria) {
        $sql = 'SELECT *
            FROM hits_galerias_media m
            WHERE idGaleria = ?;';
        return $this->db->query($sql, array($idGaleria))->result_array();
    }
    /**
     * Personas
     */
    public function obtenerPersonaMail($mail) {
        $sql = 'SELECT * FROM hits_personas WHERE emailPersona = ?;';
        return array_shift($this->db->query($sql, array($mail))->result_array());
    }
    public function guardarPersona($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_personas
                    (nombrePersona
                    , telefonoPersona
                    , celularPersona
                    , emailPersona
                    , domicilioPersona
                    , ciudadPersona) 
                    VALUES
                    ("'.$aParms[1].'"
                    , '.$aParms[2].'
                    , '.$aParms[3].'
                    , "'.$aParms[4].'"
                    , "'.$aParms[5].'"
                    , "'.$aParms[6].'");';
        }
        else {
            $sql = 'UPDATE hits_personas SET 
                    nombrePersona = "'.$aParms[1].'"
                    , telefonoPersona = '.$aParms[2].'
                    , celularPersona = '.$aParms[3].'
                    , domicilioPersona = "'.$aParms[5].'"
                    , ciudadPersona = "'.$aParms[6].'"
                    WHERE emailPersona = "'.$aParms[4].'";';
        }
        $result = $this->db->query($sql);
        return $this->db->insert_id();
    }

    public function guardarContacto($aParms) {
        if($aParms[0] == 'NULL' || $aParms[0] == 0) {
            $sql = 'INSERT INTO hits_contactos
                    (nombreContacto
                    , telefonoContacto
                    , emailContacto
                    , mensajeContacto
                    , fechaContacto
                    , estadoContacto) 
                    VALUES
                    ("'.$aParms[1].'"
                    , '.$aParms[2].'
                    , "'.$aParms[3].'"
                    , "'.$aParms[4].'"
                    , NOW()
                    , 1);';
            $type = 1;
        }
        else {
            $sql = 'UPDATE sabandijas_contactos SET 
                    nombreContacto = "'.$aParms[1].'"
                    , telefonoContacto = '.$aParms[2].'
                    , emailContacto = "'.$aParms[3].'"
                    , mensajeContacto = "'.$aParms[4].'"
                    , fechaContacto = NOW()
                    WHERE idContacto = '.$aParms[0].';';
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
}