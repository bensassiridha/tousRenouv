<?php

/*
require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');

// initiate FPDI
$pdf = new FPDI();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('facture.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, 0, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(255, 0, 0);
$pdf->SetXY(30, 30);
$pdf->Write(0, 'This is é @ just a simple text 623');

//$pdf->Output();
$pdf->Output('facture_45.pdf','f');

*/


require_once('fpdf/fpdf.php');
require_once('fpdi/fpdi.php');


$pdf = new FPDI();
$pdf->AddPage();
$pdf->setSourceFile('facture.pdf');
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 0);


$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(180, 12.5);$pdf->Write(0, '12-05-2017');//Date
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(130, 75);$pdf->Write(0, 'Mr Imed Imed');//nom et prenom client pro
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(130, 80);$pdf->Write(0, '06200 Nice');//code pastal et ville client pro
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(130, 85);$pdf->Write(0, 'France');//Pays client pro

$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(121, 109.6);$pdf->Write(0, '4526');//n° 
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(6, 141);$pdf->Write(0, 'R5803e4da45526');//Ref
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(32, 146);$pdf->Write(0, 'Mr Vantancoli Romain');//nom et prenom client part
$pdf->SetFont('Helvetica','','10');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(32, 151);$pdf->Write(0, '06200 Nice');//code pastal et ville client part
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(116, 141);$pdf->Write(0, number_format(1244.85,2,',',''));//PU HT
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(131, 141);$pdf->Write(0, number_format(1244.85,2,',',''));//PU TTC
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 141);$pdf->Write(0, number_format(1244.85,2,',',''));//Total HT (colonne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(177, 141);$pdf->Write(0, number_format(1244.85,2,',',''));//Total TTC (colonne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(191, 141);$pdf->Write(0, '20 %');//TVA (colonne)

$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 158);$pdf->Write(0, number_format(1244.85,2,',',''));//Total HT (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 165);$pdf->Write(0, '20 %');//TVA (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 173);$pdf->Write(0, number_format(1244.85,2,',',''));//Total TTC (ligne)
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 181);$pdf->Write(0, number_format(0,2,',',''));//Reglement
$pdf->SetFont('Helvetica','','8');$pdf->SetTextColor(0, 0, 255);$pdf->SetXY(161.5, 188);$pdf->Write(0, number_format(1244.85,2,',',''));//Tet à payer

$pdf->Output();
?>






