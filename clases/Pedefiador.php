<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cTcpdf
 *
 * @author miguel
 */

require_once('../tcpdf/config/lang/eng.php');
require_once('../tcpdf/tcpdf.php');

class Pedefiador  extends TCPDF {

	public function Header() {
		$this->setJPEGQuality(90);
		$this->Image('../imagenes/LogoMP2.png', 10, 8, 33, 0, 'PNG');
                $this->Cell(30, 10, 'titulo', 0, false, 'C');
	}
	public function Footer() {
		$this->SetY(-15);
		$this->SetFont(PDF_FONT_NAME_MAIN, 'I', 8);
		$this->Cell(0, 10, 'Reporte de prueba, no válido', 0, false, 'C');
	}
	public function Texto($textval, $x = 0, $y = 0, $width = 0, $height = 10, $fontsize = 10, $fontstyle = '', $align = 'L') {
		$this->SetXY($x+20, $y); // 20 = margin left
		$this->SetFont(PDF_FONT_NAME_MAIN, $fontstyle, $fontsize);
		$this->Cell($width, $height, $textval, 0, false, $align);
	}
}
?>
