<?php

require_once('path/to/tcpdf.php');

use Outils\Utilitaires;

$pdo = PdoGsb::getPdoGsb();

$visiteurLogin = filter_input(INPUT_POST, 'visiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$visiteurId = $pdo->getVisiteurId($visiteurLogin);
$lesFraisForfait = $pdo->getLesFraisForfait($visiteurId, $mois);
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurId, $mois);

$pdf = new TCPDF();

$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Fiche de Frais - Visiteur: ' . htmlspecialchars($visiteurLogin), 0, 1, 'C');

$pdf->SetFont('helvetica', '', 12);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Eléments forfaitisés', 0, 1, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 10, 'Libellé', 1, 0, 'C');
$pdf->Cell(30, 10, 'Quantité', 1, 1, 'C');

foreach ($lesFraisForfait as $frais) {
    $pdf->Cell(50, 10, htmlspecialchars($frais['libelle']), 1, 0, 'L');
    $pdf->Cell(30, 10, $frais['quantite'], 1, 1, 'C');
}

$pdf->Ln(10);
$pdf->Cell(0, 10, 'Eléments hors forfait', 0, 1, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(50, 10, 'Libellé', 1, 0, 'C');
$pdf->Cell(30, 10, 'Montant', 1, 1, 'C');
$pdf->Cell(50, 10, 'Date', 1, 0, 'C');

foreach ($lesFraisHorsForfait as $fraisHors) {
    $pdf->Cell(50, 10, htmlspecialchars($fraisHors['libelle']), 1, 0, 'L');
    $pdf->Cell(30, 10, number_format($fraisHors['montant'], 2, ',', ' ') . ' €', 1, 0, 'C');
    $pdf->Cell(50, 10, htmlspecialchars($fraisHors['date']), 1, 1, 'C');
}

$pdf->Output('Fiche_de_frais_' . $visiteurLogin . '_' . $mois . '.pdf', 'I');

?>
