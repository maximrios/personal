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
	$ci->pdf->Cell(190, 10, 'Listado de agentes cargados en Sistema de RRHH al '.date('d-m-Y'), 0, 1, 'L', FALSE);
	$ci->pdf->Line(10, 40, 200, 40);
	$ci->pdf->SetFont('helvetica', '', 9);
	$ci->pdf->Ln(6);
	$ci->pdf->Cell(10, 6, 'N°', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(40, 6, 'Apellido', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(45, 6, 'Nombre', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(22, 6, 'Cuil', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(55, 6, 'Email', 1, 0, 'C', TRUE);
	$ci->pdf->Cell(9, 6, 'Int', 1, 1, 'C', TRUE);
	$i = 1;
	foreach ($agentes as $agente) {
		$ci->pdf->Cell(10, 6, $i, 1, 0, 'C', FALSE);
		$ci->pdf->Cell(40, 6, $agente['apellidoPersona'], 1, 0, 'L', FALSE);
		$ci->pdf->Cell(45, 6, $agente['nombrePersona'], 1, 0, 'L', FALSE);
		$ci->pdf->Cell(22, 6, $agente['cuilPersona'], 1, 0, 'L', FALSE);
		$ci->pdf->Cell(55, 6, $agente['emailPersona'], 1, 0, 'L', FALSE);
		$ci->pdf->Cell(9, 6, $agente['internoAgente'], 1, 1, 'L', FALSE);
		$i++;
	}
	$i = $i - 1;
	$ci->pdf->Ln(12);
	$ci->pdf->Cell(100, 6, 'Cantidad total de agentes cargados : '.$i , 0, 0, 'L', FALSE);
	$ci->pdf->Output('example_001.pdf', 'I');
?> 