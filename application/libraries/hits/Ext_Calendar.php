<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Pagination Class
*
* @package base
* @subpackage Libraries
* @category Pagination
* @author Marcelo G
* @link
* @copyright 2012-01-01
*/
class Ext_Calendar extends CI_Calendar {
	public function __construct() {
		parent::__construct();
		$this->_ci = & get_instance();
	}
	public function micosis($start, $end) {
        $result = array();
		$this->_ci->load->model('sigep/feriados_model', 'feriados');
        $startDate = new DateTime($start);
    	$starDate = new DateTime($start);
    	$endDate = new DateTime($end);
    	$intervalo = $starDate->diff($endDate);
    	$numberOfDays = (int) $intervalo->format('%a') + 1;
    	$j = 0;
    	$restar = 0;
        $sumar = 0;
    	$feriados = $this->_ci->feriados->obtener();
    	for($i = 1; $i <= $numberOfDays; $i++){
    		if($starDate->format('w') == 0 || $starDate->format('w') == 6){
                $restar = $restar + 1;
         	}
            else {
                foreach ($feriados as $feriado) {
                    if($feriado['fechaFeriado'] == $starDate->format('Y-m-d')) {
                        $restar = $restar + 1;
                    }
                }
                $sumar = $sumar + 1;
            }
         	$starDate->modify("+1 days");
        }
        $total = $sumar + $restar;
        $result['usufructuados'] = $numberOfDays - $restar;
        $result['retorno'] = $startDate->modify('+'.$numberOfDays.' days');
        if($result['retorno']->format('w') == 6){
            $result['retorno']->modify('+2 days');
        }
        foreach ($feriados as $feriado) {
            if($feriado['fechaFeriado'] == $result['retorno']->format('Y-m-d')) {
                $result['retorno']->modify('+1 days');
            }
        }
        $result['retorno'] = $result['retorno']->format('Y-m-d');
        return $result;
	}
}