<?php
	$ci = &get_instance();
	$config = array(
		//'header_on' => FALSE,
		//'footer_on' => FALSE,
	);
	$ci->load->library('hits/pdf', $config);
	$ci->pdf->SetSubject('TCPDF Tutorial');
	$ci->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->SetFont('helvetica', 'B', 12);
	$ci->pdf->AddPage();
	$ci->pdf->Cell(190, 10, 'Informe completo de Actuación', 0, 1, 'L', FALSE);
	$ci->pdf->Line(10, 40, 200, 40);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(190, 7, 'Detalle', 0, 1, 'L', TRUE);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Cell(30, 6, 'Tipo de Actuación : ', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(65, 6, $actuacion['nombreActuacionTipo'], 0, 0, 'L', FALSE);
	$ci->pdf->Cell(40, 6, 'Cantidad total de folios :', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(100, 6, $actuacion['foliosActuacion']['foliosActuacion'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(55, 6, 'Número de Actuación SICE : ', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(40, 6, $actuacion['referenciaActuacion'], 0, 0, 'L', FALSE);
	$ci->pdf->Cell(55, 6, 'Número de Actuación SGA (SIGEP) : ', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(40, 6, $actuacion['codigoActuacion'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(20, 6, 'Iniciador :', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(170, 6, '('.$actuacion['iudIniciador'].') - '.$actuacion['nombreIniciador'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(20, 6, 'Remitente :', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(170, 6, '('.$actuacion['iudIniciador'].') - '.$actuacion['nombreIniciador'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(45, 6, 'Area en la que se encuentra :', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(155, 6, $actuacion['nombreEstructuraActual'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(35, 6, 'Estado de Actuación :', 0, 0, 'L', FALSE);
	$ci->pdf->Cell(165, 6, $actuacion['nombreActuacionEstado'], 0, 1, 'L', FALSE);
	$ci->pdf->Cell(20, 6, 'Carátula : ', 0, 0, 'L', FALSE, FALSE, 0, FALSE, 'T', 'T');
	$ci->pdf->Multicell(180, 6, $actuacion['caratulaActuacion'], 0, 'L', false, 1, '', '', true, 0, true);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', 'B', 10);
	$ci->pdf->Cell(190, 7, 'Detalle de pases', 0, 1, 'L', TRUE);
	$ci->pdf->Ln(2);
	$ci->pdf->SetFont('helvetica', '', 9);
	$i = 1;
	$total = count($pases);
	$band = FALSE;
	foreach ($pases as $pase) {
		$ci->pdf->Cell(35, 6, 'Estado : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, $pase['nombrePaseEstado'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Area Rtte. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, '('.$pase['iudOrigen'].') - '.$pase['nombreOrigen'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Fecha de envío : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(65, 6, GetDateTimeFromISO($pase['fechaEnvioActuacionPase']), 0, 0, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Folios agregados : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(65, 6, $pase['foliosActuacionPase'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Agente Rtte. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, $pase['nombreCompletoPersonaOrigen'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Area u Org. Dest. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, '('.$pase['iudDestino'].') - '.$pase['nombreDestino'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Fecha de recepcion : ', 0, 0, 'L', FALSE);
		if($pase['fechaRecepcionActuacionPase'] != 0) {
			$ci->pdf->Cell(155, 6, GetDateTimeFromISO($pase['fechaRecepcionActuacionPase']), 0, 1, 'L', FALSE);
			if(!$fecha) {
				$fecha = date('Y-m-d H:i:s');
			}
			$band = FALSE;
			//$fecha = $pase['fechaRecepcionActuacionPase'];
			//$fecha = date('Y-m-d H:i:s');
		}
		else {
			$ci->pdf->Cell(155, 6, '', 0, 1, 'L', FALSE);
			$band = TRUE;
			$fecha = date('Y-m-d H:i:s');
		}
		$ci->pdf->Cell(35, 6, 'Agente Recep. : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, $pase['nombreCompletoPersonaDestino'], 0, 1, 'L', FALSE);
		$ci->pdf->Cell(35, 6, 'Tiempo de gestión : ', 0, 0, 'L', FALSE);
		if($fecha != 0 && $band == FALSE) {
			$ultima = new DateTime($fecha);
			$anterior = new DateTime($pase['fechaRecepcionActuacionPase']);
			$intervalo = $anterior->diff($ultima);
			$ci->pdf->Cell(155, 6, $intervalo->format('%a días, %h horas %i minutos %s segundos'), 0, 1, 'L', FALSE);	
			$fecha = $pase['fechaRecepcionActuacionPase'];
		}
		else {
			$ci->pdf->Cell(155, 6, '', 0, 1, 'L', FALSE);	
		}
		
		$ci->pdf->Cell(35, 6, 'Observaciones : ', 0, 0, 'L', FALSE);
		$ci->pdf->Cell(155, 6, $pase['observacionActuacionPase'], 0, 1, 'L', FALSE);
		$ci->pdf->SetDrawColor(210, 210, 210);
		if($i != $total)  {
			$ci->pdf->Cell(190, 1, ' ', 'B', 1, 'L', FALSE);
			$ci->pdf->Ln(3)	;
		}
		$i = $i + 1;
		//if($pase['fechaRecepcionActuacionPase'] != 0) {
			//$fecha = $pase['fechaRecepcionActuacionPase'];
		//}
	}

	$ci->pdf->Output('example_001.pdf', 'I');
?> 