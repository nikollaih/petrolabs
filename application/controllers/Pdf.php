<?php

class Pdf extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('fpdfs');
		$this->load->model('productos');
	}

	function index(){
		$y = 10;
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',14);


		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,utf8_decode('Documento equivalente a la factura en adquisiciones por responsables del régimen '));
		$y ++;
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,25,utf8_decode('común a personas natulares no comerciantes o inscritos en el régimen simplificado.'));
		$y += 20;

		$pdf->SetFont('Arial','B',12);
		$pdf->Rect(10, $y, 63.3, 20);
		$pdf->Rect(73.3, $y, 63.3, 20);
		$pdf->Rect(136.6, $y, 63.3, 20);

		$pdf->SetXY(20, $y);
		$pdf->Cell(1,15,utf8_decode('CUENTA DE COBRO'));
		$pdf->SetXY(74.5, $y);
		$pdf->Cell(1,15,utf8_decode('DOCUMENTO EQUIVALENTE'));
		$pdf->SetXY(141, $y);
		$pdf->Cell(1,15,utf8_decode('NOTA DE CONTABILIDAD'));

		$y += 5;
		$pdf->SetXY(24, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 4 D 3050/97'));
		$pdf->SetXY(88, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 3 D 522/03'));
		$pdf->SetXY(153, $y);
		$pdf->Cell(1,15,utf8_decode('Art. 3 D 380/93'));


		$y += 25;
		// Logo
		$pdf->Image('resources/images/logo.png',40,$y + 7,50);

		$pdf->SetFont('Arial','B',15);
		$pdf->SetXY(120, $y);
		$pdf->Cell(1,15,utf8_decode('PETROLABS DE'));
		$y += 6;
		$pdf->SetXY(113, $y);
		$pdf->Cell(1,15,utf8_decode('COLOMBIA CIA S.A.S.'));
		$y += 6;
		$pdf->SetXY(117, $y);
		$pdf->Cell(1,15,utf8_decode('NIT. 900.532.710 - 9'));
		$y += 6;
		$pdf->SetXY(132, $y);
		$pdf->Cell(1,15,utf8_decode('DEBE A:'));

		$pdf->SetFont('Arial','',13);

		$y += 40;
		$pdf->Line(10, $y, 200, $y);

		$pdf->SetXY(10, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Nikollai Hernandez')));

		$y += 10;
		$pdf->Line(40, $y, 100, $y);
		$pdf->Line(120, $y, 180, $y);

		$pdf->SetXY(27, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('c.c.')));
		$pdf->SetXY(107, $y - 9);
		$pdf->Cell(1,15,strtoupper(utf8_decode('de:')));

		$pdf->SetXY(40, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode('1096039150')));
		$pdf->SetXY(120, $y - 10);
		$pdf->Cell(1,15,strtoupper(utf8_decode('La Tebaida')));

		$y +=5;
		$pdf->SetFont('Arial','B',12);
		$pdf->SetXY(10, $y);
		$pdf->Cell(1,15,strtoupper(utf8_decode('Por concepto de:')));

		$y += 20;
		$pdf->Line(10, $y, 200, $y);

		$pdf->Output();
	}
}
