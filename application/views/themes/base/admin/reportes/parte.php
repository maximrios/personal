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
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->AddPage();
	$ci->pdf->SetFillColor(200, 200, 200);
	$ci->pdf->SetFont('helvetica', 'B', 8);
	$ci->pdf->Cell(190, 6, 'PARTE DE NOVEDADES DEL PERSONAL AL DIA '.date('d/m/Y'), 1, 1, 'C', TRUE);
	$ci->pdf->SetFont('helvetica', 'B', 7);
	$ci->pdf->SetFillColor(230, 230, 230);
	$ci->pdf->Cell(10, 5, 'N°', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(45, 5, 'APELLIDO Y NOMBRE', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(40, 5, 'PARTE DIARIO', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(10, 5, 'N°', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(45, 5, 'APELLIDO Y NOMBRE', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(40, 5, 'PARTE DIARIO', 1, 1, 'C', TRUE);
	$i = 1;
	$j = 0;
	$salto = 0;
	$band = FALSE;
	$ci->pdf->SetFont('helvetica', '', 7);
	foreach ($agentes as $agente) {
		$ci->pdf->Cell(10, 5, $i, 1, 0, 'C', $band);
		$ci->pdf->Cell(45, 5, $agente['apellidoPersona'].', '.$agente['nombrePersona'], 1, 0, 'L', $band);
		$salto = ($i % 2)? 0:1;
		$ci->pdf->Cell(40, 5, '', 1, $salto, 'L', $band);
		if($i % 2 == 0) {
			$band = ($band)? FALSE:TRUE;
		}
		$i++;
	}
	$ci->pdf->Output('example_001.pdf', 'I');
?> 