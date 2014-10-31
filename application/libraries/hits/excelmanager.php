<?php
require_once('PHPExcel.php');
require_once('PHPExcel/IOFactory.php');
Class excelmanager {
	/**
	 * Pasar como variable titulo de hoja
	 */
	function export($config, $view) {
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator('HITS Soluciones Informáticas');
		$objPHPExcel->getActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->setTitle($config['title']);//Titulo como variable
		$column = 0;
		$row = 1;
		if($config['header']) {
			foreach ($config['header'] as $header) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $header);
				$column++;
			}
			$column = 0;
			$row++;
		}
		foreach ($view as $record) {
			foreach ($record as $value) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($column, $row, $value);
				$column++;
			}
			$column = 0;
			$row++;
		}
		for ($i = 'A'; $i <= 'Z'; $i++){
			$objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true); 
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$config['title'].'.xlsx');
		header('Cache-Control: max-age=0');
		$objWriter->save('php://output');
	}
	function import() {

	}
}
?>