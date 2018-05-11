<?php

class Excels extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('excel');
		$this->load->model('productos');
	}

	function exportarProductos(){
			
		// ====================== ESTILOS ====================== //
			$borderArray = array(
			  'borders' => array(
			    'allborders' => array(
			      'style' => PHPExcel_Style_Border::BORDER_THIN
			    )
			  )
			);

			$subtituloArray = array(
		    	'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 12,
		    ));

		    $tituloArray = array(
		    	'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 16,
		    ));

		    $letrasArray = array(
		    	0 => 'A', 
		    	1 => 'B', 
		    	2 => 'C', 
		    	3 => 'D', 
		    	4 => 'E', 
		    	5 => 'F', 
		    	6 => 'G', 
		    	7 => 'H', 
		    	8 => 'I', 
		    	9 => 'J', 
		    	10 => 'K', 
		    	11 => 'L',
		    	12 => 'M', 
		    	13 => 'N',
		    	14 => 'O',
		    	15 => 'P',
		    );
		// ========================== FIN ESTILOS ========================== //



		// ====================== CABECERA DEL ARCHIVO ===================== //
	   		$this->excel->getActiveSheet()->mergeCells('A1:H2');
			$this->excel->getActiveSheet()->setCellValue('A1', 'PETROLABS');

			$this->excel->getActiveSheet()->mergeCells('I1:P2');
			$this->excel->getActiveSheet()->setCellValue('I1', 'LISTA DE PRODUCTOS');

			for ($i=0; $i < count($letrasArray) ; $i++) { 
				for ($j=0; $j < 3; $j++) { 
					$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($borderArray);
					$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($tituloArray);
				}
			}

		// ========================= FIN CABECERA ========================== //

		$filename='lista_productos.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
}
?>