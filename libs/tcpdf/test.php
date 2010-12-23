<?php



//include_once("libs/CalculDate.php");


require('tcpdf.php');

function getPositions($rows, $columns){
	$positions = array();
	$printableWidth = 7.5;
	$printableHeight = 10;
	if($rows < 1){
		$rows = 1;
	}
	if($columns < 1){
		$columns = 1;
	}
	$width = $printableWidth / $columns;
	$height = $printableHeight / $rows;
	$n = 0;
	for($y = 0.5; $y < $printableHeight; $y += $height){
		for($x = 0.5; $x < $printableWidth; $x += $width){
			$n++;
			$positions['xy'][$n] = array(
				'x' => $x,
				'y' => $y
			);
		}
	}
	$positions['width'] = $width;
	$positions['height'] = $height;
	return $positions;
}


$pdf = new TCPDF('P', 'in', 'Letter', true, 'UTF-8');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(false);
$pdf->SetFont('freeserif','',8);

$positions = getPositions(2,2);
$nUp = count($positions['xy']);
$n = 0;
for($i=1; $i<=10; $i++){
	$n++;
	if($n > $nUp){
		$n = 1;
	}
	if($n == 1){
		$pdf->AddPage();
	}
	$pdf->Cell(0, 0, '', 0, 0, '', 0, '');
	$pdf->writeHTMLCell($positions['width'],$positions['height'],$positions['xy'][$n]['x'],$positions['xy'][$n]['y'],'<b>' . $i . '</b>',1,0,0);
}
$pdf->Output();
?>