<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @package base
 * @copyright 2014
 * 
 */
class Pases_model extends CI_Model {

    function __constructor() {
        
    }
    public function obtener($idActuacion=0, $idEstructura=0, $idActuacionEstado=0, $idEstado=0, $vcBuscar = '', $limit = 0, $offset = 9999999, $pendiente = 0) {
        $actuacion = ($idActuacion != 0)? ' AND idActuacion = '.$idActuacion:'';
        $aestado = ($idActuacionEstado != 0)? ' WHERE idActuacionEstado = '.$idActuacionEstado:'';
        $estado = ($idEstado != 0)? ' AND idPaseEstado = '.$idEstado:'';
        $estructura = ($idEstructura != 0)? ' AND idDestino = '.$idEstructura:'';
        $actual = ($pendiente != 0)? ' AND idEstructuraActual = '.$idEstructura:'';
        $group = ($actual != '')? ' GROUP BY idActuacion':'';
        $vcBuscar = '';
        $sql = 'SELECT * 
        FROM (SELECT * FROM sigep_view_actuaciones_pases
        WHERE nombreOrigen LIKE ? 
        '.$estructura.'
        '.$actuacion.'
        '.$estado.'
        '.$actual.'
        ORDER BY idActuacionPase DESC) AS filtro
        GROUP BY idActuacion;';
        //Esto va en cuenta del group by'.$aestado.'
        /*$sql = 'SELECT * FROM (
    SELECT * FROM sigep_view_actuaciones_pases 
    WHERE nombreOrigen LIKE '%%' AND idDestino = 5 AND idPaseEstado = 2 AND idEstructuraActual = 5
    ORDER BY idActuacionPase DESC
) AS inv
GROUP BY idActuacion
';*/
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUno($id) {
        $sql = 'SELECT * 
                FROM sigep_view_actuaciones_pases
                WHERE idActuacionPase = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function obtenerFolios($id) {
        $sql = 'SELECT SUM(foliosActuacionPase) as foliosActuacion
                FROM sigep_view_actuaciones_pases
                WHERE estadoActuacionPase = 1 AND idActuacion = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    /*public function numRegs($idActuacion=0, $idEstructura=0, $idEstado=0, $vcBuscar = '') {
        $actuacion = ($idActuacion != 0)? ' AND idActuacion = '.$idActuacion:'';
        $estado = ($idEstado != 0)? ' AND idPaseEstado = '.$idEstado:'';
        $estructura = ($idEstructura != 0)? ' AND idDestino = '.$idEstructura:'';
        $sql = 'SELECT count(idActuacionPase) AS inCant 
        FROM sigep_view_actuaciones_pases
        WHERE nombreOrigen LIKE ?
        '.$estructura.'
        '.$actuacion.'
        '.$estado.';';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }*/
    public function numRegs($idActuacion=0, $idEstructura=0, $idActuacionEstado=0, $idEstado=0, $vcBuscar = '', $pendiente = 0) {
        $actuacion = ($idActuacion != 0)? ' AND idActuacion = '.$idActuacion:'';
        $aestado = ($idActuacionEstado != 0)? ' AND idActuacionEstado = '.$idActuacionEstado:'';
        $estado = ($idEstado != 0)? ' AND idPaseEstado = '.$idEstado:'';
        $estructura = ($idEstructura != 0)? ' AND idDestino = '.$idEstructura:'';
        $actual = ($pendiente != 0)? ' AND idEstructuraActual = '.$idEstructura:'';
        $group = ($actual != '')? ' GROUP BY idActuacion':'';
        $sql = 'SELECT count(idActuacionPase) AS inCant  FROM (SELECT *
        FROM sigep_view_actuaciones_pases
        WHERE nombreOrigen LIKE ?
        '.$estructura.'
        '.$actuacion.'
        '.$estado.'
        '.$actual.'
        '.$group.') AS filtros;';
        $result = $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%'))->result_array();
        if(!$result) {
            $result = array(array('inCant'=>0));
        }
        return $result[0]['inCant'];
    }
    public function pendientes() {
        $sql = 'SELECT * 
        FROM sigep_view_actuaciones a 
        INNER JOIN sigep_actuaciones_pases p ON a.idActuacion = p.idActuacion AND a.idEstructuraActual = p.idEstructuraDestino
        WHERE a.idActuacionEstado = 4
        ORDER BY fechaEnvioActuacionPase DESC
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
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
    public function obtenerBuscador($opciones=array()) {
        $keys = array_keys($opciones);
        $busqueda = false;
        $cds = false;
        $iud = false;
        $numero = false;
        $periodo = false;
        $corresponde = false;
        $fecha = false;
        $tipo = false;
        $caratula = false;
        for($i=0;$i<count($keys);$i++) {
            if(!$opciones[$keys[$i]]) {
                $busqueda .= '';
            }
            else {
                switch ($keys[$i]) {
                    case 'cdsSICE':
                        $cds = ' AND (cdsSICE = '.$opciones[$keys[$i]].' OR codigoActuacion = '.$opciones[$keys[$i]].') ';
                        break;
                    case 'iudSICE':
                        $iud = ' AND iudSICE = '.$opciones[$keys[$i]];
                        break;    
                    case 'numeroSICE':
                        $numero = ' AND numeroSICE = '.$opciones[$keys[$i]];
                        break;
                    case 'periodoSICE':
                        $periodo = ' AND periodoSICE = '.$opciones[$keys[$i]];
                        break;
                    case 'correspondeSICE':
                        $corresponde = ' AND correspondeSICE = '.$opciones[$keys[$i]];
                        break;
                    case 'fechaDesde':
                        if($opciones['fechaHasta'] != "NULL")
                            $fecha = ' AND fechaCreacionActuacion between "'.$opciones[$keys[$i]].'" AND "'.$opciones['fechaHasta'].'" ';
                        break;
                    case 'idActuacionTipo':
                        $tipo = ' AND idActuacionTipo = '.$opciones[$keys[$i]];
                        break;
                    case 'caratulaActuacion':
                        $caratula = ' AND caratulaActuacion LIKE "%'.$opciones[$keys[$i]].'%"';
                        break;
                }
            }
        }
        $busqueda .= $cds.$iud.$numero.$periodo.$corresponde.$caratula.$fecha.$tipo;
        $sql = 'SELECT * 
        FROM sigep_view_actuaciones
        WHERE idActuacion > 0 '
        .$busqueda.
        ' ORDER BY fechaCreacionActuacion DESC;';
        return $this->db->query($sql)->result_array();
    }
    public function dropdownTipos() {
        $sql = 'SELECT * FROM sigep_tipoinstrumentos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione tipo de instrumento ...';
        foreach($query as $row) {
            $subgrupos[$row->idTipoInstrumento] = $row->textoTipoInstrumento; 
        }
        return $subgrupos;
    }
    public function obtenerTemas($vcBuscar = '', $limit = 0, $offset = 9999999) {
        $sql = 'SELECT * 
                        FROM sigep_temas
                        WHERE textoTema LIKE ? 
                        ORDER BY idTema ASC  
                        limit ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
    }
    public function obtenerUnoTemas($id) {
        $sql = 'SELECT * 
                FROM sigep_temas
                WHERE idTema = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function numRegsTemas($vcBuscar) {
        $sql = 'SELECT count(idTema) AS inCant 
                        FROM sigep_temas AS pr 
                        WHERE textoTema LIKE ? ;';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function guardarTemas($aParms) {
        $sql = 'SELECT sigep_sp_instrumentoslegales_temas_guardar(?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function dropdownTemas() {
        $sql = 'SELECT * FROM sigep_temas';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un tema ...';
        foreach($query as $row) {
            $subgrupos[$row->idTema] = $row->textoTema; 
        }
        return $subgrupos;
    }
    public function dropdownEstructurasMesas($idEstructura) {
        $sql = 'SELECT e.idEstructura, ed.idEstructura AS idEstructuraDestino, ed.nombreEstructura AS nombreEstructuraDestino, ed.iudEstructura, ed.mesaEstructura 
        FROM sigep_estructuras e
        INNER JOIN sigep_estructuras_pases ep ON e.idEstructura = ep.idEstructuraPaseOrigen
        INNER JOIN sigep_estructuras ed ON ed.idEstructura = ep.idEstructuraPaseDestino
        WHERE ep.idEstructuraPaseOrigen = ?
        ORDER BY nombreEstructuraDestino ASC';
        $query = $this->db->query($sql, array((int) $idEstructura))->result();
        $subgrupos[0] = 'Seleccione un destino ...';
        foreach($query as $row) {
            $subgrupos[$row->idEstructuraDestino] = '('.$row->iudEstructura.') - '.$row->nombreEstructuraDestino; 
        }
        return $subgrupos;
    }
    public function dropdownEstructuras() {
        $sql = 'SELECT e.idEstructura, e.nombreEstructura, e.iudEstructura, e.mesaEstructura 
        FROM sigep_estructuras e
        ORDER BY nombreEstructura ASC';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un destino ...';
        foreach($query as $row) {
            $subgrupos[$row->idEstructura] = '('.$row->iudEstructura.') - '.$row->nombreEstructura; 
        }
        return $subgrupos;    
    }
    public function dropdownTiposPases() {
        $sql = 'SELECT * FROM sigep_actuaciones_pases_tipos';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione el motivo de pase ...';
        foreach($query as $row) {
            $subgrupos[$row->idActuacionPaseTipo] = $row->nombreActuacionPaseTipo; 
        }
        return $subgrupos;
    }
    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_actuaciones_pases_guardar(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function recibir($aParms) {
        $sql = 'SELECT sigep_sp_actuaciones_pases_recibir(?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
    }
    public function obtenerSiguiente($idActuacion, $idActuacionPase) { 
        $sql = 'SELECT * 
                FROM sigep_actuaciones_pases
                WHERE idActuacion = ? AND idActuacionPase > ? LIMIT 1';
        return array_shift($this->db->query($sql, array($idActuacion, $idActuacionPase))->result_array());
    }
}

// EOF provincias_model.php