<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Actuaciones_model extends CI_Model {
    function __constructor() {
    }
    public function obtener($idEstructura=0, $vcBuscar = '', $state = '', $limit = 0, $offset = 9999999) {
        $estructura = ($idEstructura == 0)? '':' AND idEstructuraActual = '.$idEstructura;
        $state = ($state == '')? $state:' AND idActuacionEstado = '.$state;
        $sql = 'SELECT * 
        FROM sigep_view_actuaciones
        WHERE caratulaActuacion LIKE ? '
        .$estructura.' '
        .$state.
        ' ORDER BY fechaCreacionActuacion DESC
        LIMIT ? offset ? ;';
        return $this->db->query($sql, array('%' . strtolower((string) $vcBuscar) . '%', (double) $offset, (double) $limit))->result_array();
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
    public function obtenerUno($id) {
        $sql = 'SELECT * 
                FROM sigep_view_actuaciones
                WHERE idActuacion = ?;';
        return array_shift($this->db->query($sql, array($id))->result_array());
    }
    public function numRegs($idEstructura=0, $vcBuscar) {
        $estructura = ($idEstructura == 0)? '':' AND idEstructuraActual = '.$idEstructura;
        $sql = 'SELECT count(idActuacion) AS inCant 
        FROM sigep_view_actuaciones
        WHERE caratulaActuacion LIKE ? '
        .$estructura.
        ';';
        $result = $this->db->query($sql, array(strtolower('%' . strtolower($vcBuscar) . '%')))->result_array();
        return $result[0]['inCant'];
    }
    public function guardar($aParms) {
        $sql = 'SELECT sigep_sp_actuaciones_guardar(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
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
    public function dropdownTipos() {
        $sql = 'SELECT * FROM sigep_tipoinstrumentos WHERE idTipoInstrumento BETWEEN 3 AND 5';
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
        $result = $this->db->query($sql, $aParms);
        return $result[0]['result'];
    }

    public function pasar($id) {
        $sql = 'UPDATE sigep_actuaciones SET idActuacionEstado = 1 WHERE idActuacion = ?';
        $result = $this->db->query($sql, $id);
        return TRUE;
        
    }

    public function recepcionar($aParms) {
        $sql = 'SELECT sigep_sp_actuaciones_recibir(?, ?, ?, ?) AS result;';
        $result = $this->db->query($sql, $aParms)->result_array();
        return $result[0]['result'];
        
    }

    public function available($id, $ide) {
        //$sql = 'SELECT * from sigep_actuaciones_pases where idActuacion = ? AND idActuacionPaseTipo <> 0 AND idEstructuraOrigen = ? AND idEstructuraDestino = ? ORDER BY idActuacionPase DESC LIMIT 1';
        $sql = 'SELECT * FROM (SELECT * FROM sigep_actuaciones_pases ORDER BY idActuacionPase DESC LIMIT 1) AS ultima WHERE idActuacion = ? AND idActuacionPaseTipo <> 0 AND idEstructuraOrigen = ? AND idEstructuraDestino = ?';
        $pase = array_shift($this->db->query($sql, array($id, $ide, $ide))->result_array());
        if($pase) {
            return true;
        }
        else {
            return FALSE;
            /*$sql2 = 'SELECT * FROM sigep_actuaciones WHERE idActuacion = ? AND idEstructuraActual = ?';
            $actual = array_shift($this->db->query($sql2, array($id, $ide))->result_array());
            if($actual){
                return TRUE;    
            }
            else {
                return FALSE;
            }*/
        }
    }

    public function dropdownTemas() {
        $sql = 'SELECT * FROM sigep_actuaciones_temas';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un tema ...';
        foreach($query as $row) {
            $subgrupos[$row->idActuacionTema] = $row->nombreActuacionTema; 
        }
        return $subgrupos;
    }
    public function dropdownAnios() {
        $sql = 'SELECT DISTINCT(YEAR(fechaInstrumentoLegal)) as anio FROM sigep_instrumentoslegales ORDER BY fechaInstrumentoLegal DESC';
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione un año ...';
        foreach($query as $row) {
            $subgrupos[$row->anio] = $row->anio; 
        }
        return $subgrupos;
    }
    public function dropdownEstructuras($tipo=0, $title='') {
        $tipo = ($tipo==0)? '':'WHERE tipoEstructura = '.$tipo.' ';
        $sql = 'SELECT * 
        FROM sigep_estructuras 
        '.$tipo.'
        ORDER BY leftEstructura';
        $query = $this->db->query($sql)->result();
        $estados[0] = ($title=='')? 'Seleccione el organismo iniciador...':$title;
        foreach($query as $row) {
            $estados[$row->idEstructura] = $row->nombreEstructura; 
        }
        return $estados;
    }
    public function dropdownCDSEstructuras($tipo=1) {
        $tipo = ($tipo==1)? ' AND idEstructura = 1':' AND idEstructura <> 1';
        $sql = 'SELECT * 
        FROM sigep_estructuras 
        WHERE cdsEstructura = 0
        '.$tipo.'
        ORDER BY leftEstructura';
        $query = $this->db->query($sql)->result();
        $estados[0] = ($tipo == 2)? 'Seleccione el organismo iniciador...': 'Seleccione la gerencia inciadora';
        foreach($query as $row) {
            $estados[$row->idEstructura] = $row->nombreEstructura; 
        }
        return $estados;
    }
    public function dropdownCDSEstructurasReporte() {
        $sql = 'SELECT * 
        FROM sigep_estructuras 
        WHERE nombreEstructura LIKE "%Gerencia%" OR parentEstructura = 2 AND idEstructura <> 8
        ORDER BY leftEstructura';
        $query = $this->db->query($sql)->result();
        $estados[0] = 'Seleccione la gerencia inciadora';
        foreach($query as $row) {
            $estados[$row->idEstructura] = $row->nombreEstructura; 
        }
        return $estados;
    }
    public function dropdownEstructurasDependiente($tipo=0) {
        $tipo = ($tipo==0)? '':'WHERE parentEstructura = '.$tipo.' ';
        $sql = 'SELECT * 
        FROM sigep_estructuras 
        '.$tipo.'
        ORDER BY nombreEstructura';
        $query = $this->db->query($sql)->result();
        $option = '<option value="0">Seleccione el organismo iniciador...</option>';
        foreach($query as $row) {
            $option .= '<option value="'.$row->idEstructura.'">'.$row->nombreEstructura.'</option>'; 
        }
        return $option;
    }
    public function dropdownTiposDependiente($tipo=0) {
        if($tipo == 1) {
            $where = 'WHERE idTipoInstrumento = 4';
        }
        elseif($tipo == 2) {
            $where = 'WHERE idTipoInstrumento = 3 OR idTipoInstrumento = 5';
        }
        else {
            $where = '';
        }
        $sql = 'SELECT * FROM sigep_tipoinstrumentos '.$where;
        $query = $this->db->query($sql)->result();
        $subgrupos[0] = 'Seleccione tipo de instrumento ...';
        foreach($query as $row) {
            $subgrupos[$row->idTipoInstrumento] = $row->textoTipoInstrumento; 
        }
        return $subgrupos;
    }
    public function dropdownEstructurasDependienteCDS($cds=0) {
        $sql = 'SELECT * 
        FROM sigep_estructuras 
        WHERE cdsEstructura = ?
        ORDER BY nombreEstructura';
        $query = $this->db->query($sql, array($cds))->result();
        $option = '<option value="0">Seleccione el organismo iniciador...</option>';
        foreach($query as $row) {
            $option .= '<option value="'.$row->idEstructura.'">'.$row->nombreEstructura.'</option>'; 
        }
        return $option;
    }
}