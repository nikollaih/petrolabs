<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('fpdfs');
		$this->load->model('facturas');
		$this->load->helper('funciones');
	}

/**
 * [facturas description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  boolean $asesor [description]
 * @return [type]          [description]
 */
	function facturas($asesor = false){
		isLogin();
		permisos(array(1,2));

		$datos['asesores'] = $this->usuarios->obtenerUsuariosRol(2);
		$datos['facturas'] = $this->facturas->obtenerFacturas();
		$this->load->view('lista_facturas', $datos);
	}

/**
 * [filtroFacturas description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @return [type] [description]
 */
	function filtroFacturas(){
		isLogin();
		permisos(array(1,2));

		$facturas = $this->facturas->obtenerFacturas($_REQUEST['asesor'], $_REQUEST['fecha_inicial'], $_REQUEST['fecha_final']);

		responder($facturas, true, 'Listado de facturas');
	}	

/**
 * [factura description]
 * @author Nikollai Hernandez G <nikollaihernandez@gmail.com>
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
	function factura($id){
		isLogin();
		permisos(array(1,2));

		$factura = $this->facturas->obtenerFacturaId($id);
		if ($factura == 0) {
			responder(0, false, 'No se ha encontrado la factura');
		}

		$y = 7;
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',12);


		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,utf8_decode('Documento equivalente a la factura en adquisiciones por responsables del régimen común a'));
		$y ++;
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,25,utf8_decode('personas natulares no comerciantes o inscritos en el régimen simplificado.'));
		$y += 20;

		$pdf->SetFont('Arial','B',11);
		$pdf->Rect(10, $y, 63.3, 16);
		$pdf->Rect(73.3, $y, 63.3, 16);
		$pdf->Rect(136.6, $y, 63.3, 16);

		$pdf->SetXY(20, $y - 2);
		$pdf->Cell(1,15,utf8_decode('CUENTA DE COBRO'));
		$pdf->SetXY(76, $y - 2);
		$pdf->Cell(1,15,utf8_decode('DOCUMENTO EQUIVALENTE'));
		$pdf->SetXY(143, $y - 2);
		$pdf->Cell(1,15,utf8_decode('NOTA DE CONTABILIDAD'));

		$y += 3;
		$pdf->SetXY(24, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 4 D 3050/97'));
		$pdf->SetXY(88, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 3 D 522/03'));
		$pdf->SetXY(153, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 3 D 380/93'));


		$y += 26;
		// Logo
		$pdf->Image('resources/images/logo.png',40,$y + 7,50);

		$pdf->SetFont('Arial','B',13);
		$pdf->SetXY(120, $y);
		$pdf->Cell(1,15,utf8_decode('PETROLABS DE'));
		$y += 6;
		$pdf->SetXY(113, $y);
		$pdf->Cell(1,15,utf8_decode('COLOMBIA CIA S.A.S.'));
		$y += 6;
		$pdf->SetXY(117, $y);
		$pdf->Cell(1,15,utf8_decode('NIT. 900.532.710 - 9'));
		$y += 6;
		$pdf->SetXY(129, $y);
		$pdf->Cell(1,15,utf8_decode('DEBE A:'));

		$pdf->SetFont('Arial','',11);

		$y += 35;
		$pdf->Line(10, $y, 200, $y);

		$pdf->SetXY(10, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['nombre'].' '.$factura['apellidos'])));

		$y += 10;
		$pdf->Line(25, $y, 80, $y);
		// $pdf->Line(120, $y, 180, $y);

		$pdf->SetFont('Arial','B',11);
		$pdf->SetXY(10, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('c.c.')));
		$pdf->SetFont('Arial','',11);
		// $pdf->SetXY(107, $y - 9);
		// $pdf->Cell(1,15,strtoupper(utf8_decode('de:')));

		$pdf->SetXY(25, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['cedula'])));
		// $pdf->SetXY(120, $y - 10);
		// $pdf->Cell(1,15,strtoupper(utf8_decode('La Tebaida')));

		$y +=3;
		$pdf->SetFont('Arial','B',11);
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Por concepto de:')));

		$pdf->SetFont('Arial','',11);
		$pdf->SetXY(10, $y + 6);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['concepto'])));
		$pdf->SetFont('Arial','B',11);

		$y += 16;
		$pdf->Line(10, $y, 200, $y);

		$y += 10;
		$pdf->Line(40, $y, 200, $y);
		$pdf->SetXY(10, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('VALOR: $')));

		$pdf->SetFont('Arial','',11);
		$pdf->SetXY(42, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode('$'.number_format($factura['valor'], 1, ',', '.'))));
		$pdf->SetFont('Arial','B',11);

		$y += 8;
		$pdf->Line(10, $y + 7, 200, $y + 7);
		$pdf->SetXY(10, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('VALOR EN LETRAS: ')));

		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(9, $y - 3);
		$pdf->Cell(1,15,strtoupper(utf8_decode(valorEnLetras($factura['valor']))));
		$pdf->SetFont('Arial','B',11);

		$y += 17;
		$pdf->Line(30, $y, 100, $y);
		$pdf->SetXY(10, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('fecha')));

		$pdf->SetFont('Arial','',11);
		$pdf->SetXY(30, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['fecha_visual'])));
		$pdf->SetFont('Arial','B',11);

		$pdf->SetXY(120, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Nº Consecutivo')));
		$pdf->SetXY(200, $y - 9);

		$pdf->SetFont('Arial','',16);
		$pdf->SetTextColor(244, 66, 66);
		$pdf->Cell(1,15, $factura['id_factura'], 0, 0, 'R');

		$pdf->SetTextColor(0,0,0);

		$header = ['CUENTA', 'DESCRIPCIÓN', 'DEBE', 'HABER'];
		$data[0] = array('', 'GASTO', '', '');
		$data[1] = array('', 'RETENCIÓN', '', '');
		$data[2] = array('', 'PAGO', '', '');
		$data[3] = array('', 'SUMAS IGUALES', '', '');

		$y += 17; 
		$pdf->SetXY(10, $y);
		$pdf->BasicTable($header,$data, 47.5);

		$pdf->SetFont('Arial','B',11);
		$y += 50; 
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Nombre')));
		$pdf->SetXY(140, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('c.c.')));

		$pdf->Line(10, $y + 18, 130, $y + 18);
		$pdf->Line(140, $y + 18, 200, $y + 18);

		$pdf->SetFont('Arial','',11);
		$pdf->SetXY(10, $y + 8);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['nombre'].' '.$factura['apellidos'])));
		$pdf->SetXY(140, $y + 8);
		$pdf->Cell(1,15,strtoupper(utf8_decode($factura['cedula'])));
		$pdf->SetFont('Arial','B',11);

		$y += 20; 
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Telefono')));
		$pdf->SetXY(105, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Valor $')));

		$pdf->Line(10, $y + 18, 95, $y + 18);
		$pdf->Line(105, $y + 18, 200, $y + 18);

		$pdf->SetFont('Arial','',11);
		$pdf->SetXY(10, $y + 14);
		$pdf->Cell(1,1,strtoupper(utf8_decode($factura['telefono'])));
		$pdf->SetXY(105, $y + 14);
		$pdf->Cell(1,1,strtoupper(utf8_decode('$'.number_format($factura['valor'], 1, ',', '.'))));

		$pdf->Output();
	}
}
