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
			        'size'  => 11,
		    ));

		    $tituloArray = array(
		    	'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 15,
		    ));

		    $letrasArray = array(
		    	0 => 'A', 
		    	1 => 'B', 
		    	2 => 'C', 
		    	3 => 'D', 
		    	4 => 'E',
		    );
		// ========================== FIN ESTILOS ========================== //



		// ====================== CABECERA DEL ARCHIVO ===================== //
   		$this->excel->getActiveSheet()->mergeCells('A1:E2');
		$this->excel->getActiveSheet()->setCellValue('A1', 'LISTA DE PRODUCTOS');

		$this->excel->getActiveSheet()->mergeCells('A3:C4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'PETROLABS');

		$this->excel->getActiveSheet()->mergeCells('D3:E4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'FECHA: '.date('d-M-Y'));

		for ($i=0; $i < count($letrasArray) ; $i++) { 
			for ($j=0; $j < 5; $j++) { 
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($borderArray);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($tituloArray);
			}
		}
		
		$estilo = array( 
			'borders' => array(
		    	'outline' => array(
		      		'style' => PHPExcel_Style_Border::BORDER_THIN
		    	)
		  	),
		  	'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        	)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('A5', 'CÓDIGO');
		$this->excel->getActiveSheet()->getStyle('A5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35.8);
		$this->excel->getActiveSheet()->setCellValue('B5', 'NOMBRE');
		$this->excel->getActiveSheet()->getStyle('B5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('C5', 'PRECIO');
		$this->excel->getActiveSheet()->getStyle('C5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('D5', 'COMISIÓN');
		$this->excel->getActiveSheet()->getStyle('D5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('E5', 'ESTADO');
		$this->excel->getActiveSheet()->getStyle('E5')->applyFromArray($estilo);
		// ========================= FIN CABECERA ========================== //
		$productos = $this->productos->obtenerProductos();

		// ========================= INICIO PRODUCTOS ========================== //
		$fila= 6;
		foreach ($productos as $producto) {
			$this->excel->getActiveSheet()->setCellValue('A'.$fila, $producto['id_producto']);	
			$this->excel->getActiveSheet()->setCellValue('B'.$fila, $producto['nombre_producto']);
			$this->excel->getActiveSheet()->setCellValue('C'.$fila, $producto['precio']);
			$this->excel->getActiveSheet()->setCellValue('D'.$fila, $producto['comision']);

			$estado = 'Eliminado';
			if ($producto['estado'] == 1) {
				$estado = 'Activo';
			}else if ($producto['estado'] == 2) {
				$estado = 'Inactivo';
			}

			$this->excel->getActiveSheet()->setCellValue('E'.$fila, $estado);

			$fila++;
		}
		// ========================= FIN PRODUCTOS ========================== //
		
		// ========================= INICIO ESTILO LISTA ========================== //
		$fila--;
		$this->excel->getActiveSheet()->getStyle('A5:E'.$fila)->applyFromArray($estilo);
		$this->excel->getActiveSheet()->getStyle('B5:E'.$fila)->applyFromArray($estilo);
		$this->excel->getActiveSheet()->getStyle('C5:E'.$fila)->applyFromArray($estilo);
		$this->excel->getActiveSheet()->getStyle('D5:E'.$fila)->applyFromArray($estilo);
		$this->excel->getActiveSheet()->getStyle('E5:E'.$fila)->applyFromArray($estilo);
		// ========================= FIN ESTILO LISTA ========================== //

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


	function exportarProductosVendidos(){
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
			        'size'  => 11,
		    ));

		    $tituloArray = array(
		    	'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 15,
		    ));

		    $letrasArray = array(
		    	0 => 'A', 
		    	1 => 'B', 
		    	2 => 'C', 
		    	3 => 'D', 
		    	4 => 'E',
		    );
		// ========================== FIN ESTILOS ========================== //



		// ====================== CABECERA DEL ARCHIVO ===================== //
   		$this->excel->getActiveSheet()->mergeCells('A1:E2');
		$this->excel->getActiveSheet()->setCellValue('A1', 'LISTA DE PRODUCTOS VENDIDOS');

		$this->excel->getActiveSheet()->mergeCells('A3:C4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'PETROLABS');

		$this->excel->getActiveSheet()->mergeCells('D3:E4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'FECHA: '.date('d-M-Y'));

		for ($i=0; $i < count($letrasArray) ; $i++) { 
			for ($j=0; $j < 5; $j++) { 
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($borderArray);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($tituloArray);
			}
		}
		
		$estilo = array( 
			'borders' => array(
		    	'outline' => array(
		      		'style' => PHPExcel_Style_Border::BORDER_THIN
		    	)
		  	),
		  	'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        	)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('A5', 'CÓDIGO');
		$this->excel->getActiveSheet()->getStyle('A5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35.8);
		$this->excel->getActiveSheet()->setCellValue('B5', 'NOMBRE');
		$this->excel->getActiveSheet()->getStyle('B5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('C5', 'CANTIDAD');
		$this->excel->getActiveSheet()->getStyle('C5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->setCellValue('D5', 'COMISIÓN GENERADA');
		$this->excel->getActiveSheet()->getStyle('D5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('E5', 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('E5')->applyFromArray($estilo);
		// ========================= FIN CABECERA ========================== //
		$productos = (array) json_decode($this->input->post('productosArray'));

		// ========================= INICIO PRODUCTOS ========================== //
		$fila= 6;
		if ($productos != 0) {
			foreach ($productos as $producto) {
				$this->excel->getActiveSheet()->setCellValue('A'.$fila, $producto->id_producto);	
				$this->excel->getActiveSheet()->setCellValue('B'.$fila, $producto->nombre_producto);
				$this->excel->getActiveSheet()->setCellValue('C'.$fila, $producto->cantidad);
				$this->excel->getActiveSheet()->setCellValue('D'.$fila, $producto->comision_total);
				$this->excel->getActiveSheet()->setCellValue('E'.$fila, $producto->total);

				$fila++;
			}
			// ========================= FIN PRODUCTOS ========================== //
			
			// ========================= INICIO ESTILO LISTA ========================== //
			$fila--;
			$this->excel->getActiveSheet()->getStyle('A5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('B5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('C5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('D5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('E5:E'.$fila)->applyFromArray($estilo);
			// ========================= FIN ESTILO LISTA ========================== //
		}

		$filename='lista_productos_vendidos.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		            
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}

	function exportarComisionesLiquidadas(){
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
			        'size'  => 11,
		    ));

		    $tituloArray = array(
		    	'font'  => array(
			        'bold'  => true,
			        'color' => array('rgb' => '000000'),
			        'size'  => 15,
		    ));

		    $letrasArray = array(
		    	0 => 'A', 
		    	1 => 'B', 
		    	2 => 'C', 
		    	3 => 'D', 
		    	4 => 'E',
		    );
		// ========================== FIN ESTILOS ========================== //



		// ====================== CABECERA DEL ARCHIVO ===================== //
   		$this->excel->getActiveSheet()->mergeCells('A1:E2');
		$this->excel->getActiveSheet()->setCellValue('A1', 'LISTA DE PRODUCTOS VENDIDOS');

		$this->excel->getActiveSheet()->mergeCells('A3:C4');
		$this->excel->getActiveSheet()->setCellValue('A3', 'PETROLABS');

		$this->excel->getActiveSheet()->mergeCells('D3:E4');
		$this->excel->getActiveSheet()->setCellValue('D3', 'FECHA: '.date('d-M-Y'));

		for ($i=0; $i < count($letrasArray) ; $i++) { 
			for ($j=0; $j < 5; $j++) { 
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($borderArray);
				$this->excel->getActiveSheet()->getStyle($letrasArray[$i].$j)->applyFromArray($tituloArray);
			}
		}
		
		$estilo = array( 
			'borders' => array(
		    	'outline' => array(
		      		'style' => PHPExcel_Style_Border::BORDER_THIN
		    	)
		  	),
		  	'alignment' => array(
            	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        	)
		);

		$this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('A5', 'CÓDIGO');
		$this->excel->getActiveSheet()->getStyle('A5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(35.8);
		$this->excel->getActiveSheet()->setCellValue('B5', 'NOMBRE');
		$this->excel->getActiveSheet()->getStyle('B5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('C5', 'CANTIDAD');
		$this->excel->getActiveSheet()->getStyle('C5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$this->excel->getActiveSheet()->setCellValue('D5', 'COMISIÓN GENERADA');
		$this->excel->getActiveSheet()->getStyle('D5')->applyFromArray($estilo);

		$this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(18.5);
		$this->excel->getActiveSheet()->setCellValue('E5', 'TOTAL');
		$this->excel->getActiveSheet()->getStyle('E5')->applyFromArray($estilo);
		// ========================= FIN CABECERA ========================== //
		
		//$comisiones = (array) json_decode($this->input->post('comisionesArray'));
		$comisiones = 0;
		// ========================= INICIO PRODUCTOS ========================== //
		$fila= 6;
		if ($comisiones != 0) {
			foreach ($productos as $producto) {
				$this->excel->getActiveSheet()->setCellValue('A'.$fila, $producto->id_producto);	
				$this->excel->getActiveSheet()->setCellValue('B'.$fila, $producto->nombre_producto);
				$this->excel->getActiveSheet()->setCellValue('C'.$fila, $producto->cantidad);
				$this->excel->getActiveSheet()->setCellValue('D'.$fila, $producto->comision_total);
				$this->excel->getActiveSheet()->setCellValue('E'.$fila, $producto->total);

				$fila++;
			}
			// ========================= FIN PRODUCTOS ========================== //
			
			// ========================= INICIO ESTILO LISTA ========================== //
			$fila--;
			$this->excel->getActiveSheet()->getStyle('A5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('B5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('C5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('D5:E'.$fila)->applyFromArray($estilo);
			$this->excel->getActiveSheet()->getStyle('E5:E'.$fila)->applyFromArray($estilo);
			// ========================= FIN ESTILO LISTA ========================== //
		}

		$filename='lista_comisiones_liquidadas_filtro.xls'; //save our workbook as this file name
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