<?php


require('./fpdf.php');
class myPDF extends FPDF {

    // Page header
    function Header() {

        // Set font family to Arial bold
        $this->SetFont('Times','B',14);

        // Move to the right
        $this->Cell(276,5, 'HOW TO GENERATE PDF USING FPDF');

        //Sets the text color
        $this->SetTextColor(0,0,255);

        //Line break
        $this->Ln(20);

        // Header
        $this->Cell(200,10,'FPDF DOCUMENTATION',0,0,'C');

        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer() {

        // Position at 1.5 cm from bottom
        $this->SetY(-25);

        // Arial italic 8
        $this->SetFont('Arial','I',8);

        // Page number
        $this->Cell(0,10,'Page ' .
            $this->PageNo() . '/{nb}',0,0,'C');
    }
    // header Attributes
    function headerAttributes() {
        $this->SetFont('Times','B', 10);
        $this->Cell(30,10,'Attributes',1,0,'C');
        $this->Cell(45,10,'Description',1,0,'C');
        $this->Cell(60,10,'How to Use',1,0,'C');
        $this->Cell(40,10,'Tutorials',1,0,'C');
        $this-the >Ln();
    }
}

// Instantiation of FPDF class
$pdf = new myPDF();

// Define an alias for number of pages
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->headerAttributes();
$pdf->SetFont('Times','',14);


$pdf->Output();

?>