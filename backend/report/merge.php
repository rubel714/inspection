<?php
$reportName = time()."dddd.pdf";

// require_once('PDFMerger/PDFMerger.php');

    include './PDFMerger/PDFMerger.php';
    
	
	$input = "media/1111.pdf";
	$output = "media/11111.pdf";
	exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -o $output $input");
	
	$input = "media/2222.pdf";
	$output = "media/22222.pdf";
	exec("gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -o $output $input");
	
   $pdf3 = new PDFMerger;
   $pdf3->addPDF('media/11111.pdf', 'all')
         ->addPDF('media/22222.pdf' , 'all')
         ->merge('file', 'media/' . $reportName);
   //  echo $reportName;

?>