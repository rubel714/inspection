<?php

include_once('../env.php');
include_once('../source/api/pdolibs/pdo_lib.php');
include_once('../source/api/pdolibs/function_global.php');

$db = new Db();

// $DepartmentId = $_REQUEST['DepartmentId'];
// $VisitorId = $_REQUEST['VisitorId'];
// $StartDate = $_REQUEST['StartDate'];
// $EndDate = $_REQUEST['EndDate'];
$TransactionId = $_REQUEST['TransactionId'];
$date = date('d/m/Y');

$siteTitle = reportsitetitleeng;

//============================================================+
// File name   : example_008.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 008 for TCPDF class
//               Include external UTF-8 text file
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Include external UTF-8 text file
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');

//include 'PDFMerger/PDFMerger.php';




require_once('TCPDF-master/examples/tcpdf_include.php');

/* $arrayPageCopy=array("1st copy: For receiving store","2nd copy: For Dhaka CWH with counter signature from receiving store",
	"3rd copy: For Government/Private carrier's copy",
	"4th copy: For Dhaka CWH own copy",
	"5th copy: For DD's copy"); */

// Extend the TCPDF class to create custom Header and Footer
/* class MYPDFWITHCUSTOMFOOTER extends TCPDF {
        // Page footer
        public function Footer() {
          
        }
    }


    class MYPDF extends MYPDFWITHCUSTOMFOOTER {
        public function Header() {
            
           
        }
    }



$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); */



$sqlf = "SELECT a.TransactionId,	DATE_FORMAT(a.TransactionDate, '%d-%m-%Y') AS TransactionDate
			,a.InvoiceNo,a.CoverFilePages,a.CoverFileUrl,a.ManyImgPrefix,a.UserId,a.StatusId,b.UserName
			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
			where a.TransactionId = $TransactionId;";
$sqlLoop1result = $db->query($sqlf);

$TransactionDate = "";
$InvoiceNo = "";
$CoverFilePages = "";
$CoverFileUrl = "";
$ManyImgPrefix = "";
$UserId = "";
$UserName = "";
foreach ($sqlLoop1result as $result) {
   $TransactionDate = $result['TransactionDate'];
   $InvoiceNo = $result['InvoiceNo'];
   $CoverFilePages = $result['CoverFilePages'];
   $CoverFileUrl = $result['CoverFileUrl'];
   $ManyImgPrefix = $result['ManyImgPrefix'];
   $UserId = $result['UserId'];
   $UserName = $result['UserName'];
}



class MYPDF extends TCPDF
{


   //Page header
   // $pdf->Image('../../image/appmenu/Intertek_Logo.png', 7, 2, 30, 10, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);

   public function Header()
   {
      global $TransactionDate, $InvoiceNo, $CoverFilePages;

      // echo "TransactionDate=".$TransactionDate;
      // exit;

      // Logo
      $image_file = '../../image/appmenu/Intertek_Logo.png';
      $this->Image($image_file, 5, 5, 30, 10, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
      // Set font
      $this->SetFont('helvetica', 'B', 10);

      // // Title
      // $this->Cell(7, 50, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
      // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'L', 0, '', 0, false, 'M', 'M');
      $this->Write(27, 'INSPECTION REPORT', '', 0, 'L', true, 0, false, false, 0);
      // $this->Write(0, 'INSPECTION REPORT ssssssss', '', 0, 'L', true, 0, false, false, 0);
      // $this->Write(0, 'REPORT NUMBER: INS-421186 REPORT DATE: 08-01-2025 PAGE: 1  of  12', '', 0, 'R', true, 0, false, false, 0);
      // $this->Cell(50,0, 'REPORT NUMBER: INS-421186 REPORT DATE: 08-01-2025 PAGE: 1  of  12', 0, false, 'L', 0, '', 0, false, 'M', 'M');
      // Move to the right side
      $this->SetFont('helvetica', '', 7);
      $this->SetXY(150, 10); // adjust X and Y as needed
      //   $ReportNo = 'REPORT NUMBER: INS-421186';
      // $this->Cell(40, 15, 'REPORT NUMBER: INS-421186\nREPORT DATE: 08-01-2025\nPAGE: 1  of  12', 0, 0, 'R', 0, '', 0, false, 'M', 'M');
      // $this->MultiCell(0, 0, 'REPORT NUMBER: INS-421186\nREPORT DATE: 08-01-20251111111111 \nPAGE: 1  of  12', 0, 'L', 0, 3, '', '', true, 0, false, true, 0, 'M', false);

      //   $zzz = $this->getPageWidth();

      $this->Cell(0, 0, 'REPORT NUMBER: ' . $InvoiceNo, 0, 'L', false, 2, '', '', true, 0, false, true, 0, 'T', true);

      $this->SetXY(150, 14); // adjust X and Y as needed
      // $ReportDate = 'REPORT DATE: 08-01-2025';
      $this->Cell(0, 0, 'REPORT DATE: ' . $TransactionDate, 0, 'L', false, 2, '', '', true, 0, false, true, 0, 'T', true);

      $this->SetXY(150, 18); // adjust X and Y as needed
      // $PageNumber = 'PAGE: 1  of  12';
      $currentPage=$this->getPage();
      // $totalPage=$this->getNumPages();
      $PageNumber = 'PAGE: ' . ($currentPage+$CoverFilePages);
      // $PageNumber = 'PAGE: ' . ($currentPage+$CoverFilePages) . '  of ' . ($totalPage);
      // $PageNumber = 'PAGE: ' . ($this->getAliasNumPage()+$CoverFilePages) . '  of ' . ($this->getAliasNbPages()+$CoverFilePages);
      $this->Cell(0, 0, $PageNumber, 0, 'L', false, 2, '', '', true, 0, false, true, 0, 'T', true);
   }

   // Page footer
   public function Footer()
   {
      // $this->SetFooterMargin(30); // or any value you need
      $this->SetY(-30);
      $Text = 'The results reflect our findings at time and place of inspection. This report does not relieve sellers/manufacturers from their contractual liabilities or prejudice buyers right for compensation for any apparent and/or hidden defects not detected during our random inspection or occurring thereafter This report does not evidence shipment.';
      $this->MultiCell(0, 0, $Text, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

      $this->SetY(-18);
      $Text = 'ITS Labtest Bangladesh Ltd., Haidar Tower, House # 668, Choydana, Ward # 34, Gazipur City Corporation, Gazipur-1704, Bangladesh';
      $this->MultiCell(0, 0, $Text, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);

      $this->SetY(-15);
      $Text = 'Tel: +88 0966 677 6669, Web: www.intertek.com';
      $this->MultiCell(0, 0, $Text, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);
   }
}







$sqlf = "SELECT a.TransactionItemId,a.TransactionId,a.CheckId,b.CheckName,a.RowNo,a.ColumnNo,a.PhotoUrl,a.SortOrder
			FROM t_transaction_items a
			inner join t_checklist b on a.CheckId=b.CheckId
			where a.TransactionId = $TransactionId
			ORDER BY a.SortOrder ASC;";
$sqlLoop1result = $db->query($sqlf);

$CheckId = "";
$CheckName = "";
$RowNo = "";
$ColumnNo = "";
$PhotoUrl = "";
$SortOrder = "";

foreach ($sqlLoop1result as $result) {
   $CheckId = $result['CheckId'];
   $CheckName = $result['CheckName'];
   $RowNo = $result['RowNo'];
   $ColumnNo = $result['ColumnNo'];
   $PhotoUrl = $result['PhotoUrl'];
   $SortOrder = $result['SortOrder'];
}


// foreach ($sqlLoop1result as $result) {

//     $dataList.= '<tr style="font-size: 12px;">
//     <td  style="width:3% !important;" class="border_Remove">' .$sl++.'</td>
//     <td style="width:8% !important;" class="border_Remove">'.$result['TransactionId'].'</td>
//     <td style="width:34% !important;"class="border_Remove">'.$result['TransactionId'].'</td> 

//     <td style="width:9% !important;" class="right-aln border_Remove">'.getNumberFormatQTY($result['TransactionId']).'</td> 
//     <td style="width:20% !important;" class="border_Remove">'.ConvertQuantityToWords($result['TransactionId']).'</td>
//     <td style="width:5% !important;" class="center-aln border_Remove">'. $result['TransactionId'].'</td>
//     <td style="width:7% !important; text-align:center;" class="border_Remove">'.$result['TransactionId'].'</td>
//     <td style="width:8% !important;" class="center-aln border_Remove">'. $result['TransactionId'].'</td>
//     <td style="width:8% !important;" class="center-aln border_Remove">'. $result['TransactionId'].'</td>
//     </tr>';

// }


$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//$pdf->Header();
// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Inspection');
$pdf->setTitle('Inspection Report');

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setMargins(5, 4, 8);
$pdf->setHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterMargin(PDF_MARGIN_FOOTER);


// $pdf->setFooterMargin(1500);
// $pdf->SetX(-100);
// $pdf->SetY(-45);
// $pdf->setCellPadding(5,5,5,200);
// set auto page breaks
// $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// $pdf->SetMargins(5, 5, 5, 200);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
   require_once(dirname(__FILE__) . '/lang/eng.php');
   $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetAutoPageBreak(true, 10);
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// set font
$pdf->setFont('times', '', 12);

// add a page
$pdf->AddPage('A4', 'Portrait');

// follwoing margin work from 2nd page
$pdf->setMargins(5, 0, 8);

//=================------Start Office Copy-----==========================


// Image example with resizing
// $pdf->Image('../../image/appmenu/reportimage.png', 0, 0, 10, 10, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
// $pdf->Image('../../image/appmenu/reportheaderimage.png', 7, 2, 105, 22, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
// $pdf->Image('../../image/appmenu/Intertek_Logo.png', 7, 2, 30, 10, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);



// $pdf->Image('../../image/transaction/Weightcheck.jpg', 5, 25, 200, 230, '', '', '', false, 150, '', false, false, 1, false, false, false);

//Width = Half, Height = 3/1
// $pdf->AddPage('A4', 'Portrait');
$x=5; $y=25; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=95;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 1';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=25; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=95;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 2';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=5; $y=105; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=175;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 3';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=105; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=175;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 4';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=5; $y=185; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=255;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 5';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=185; $w=95; $h=70;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=255;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 6';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);



//Width = Half, Height = Half
$pdf->AddPage('A4', 'Portrait');
$x=5; $y=25; $w=95; $h=100;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=125;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 1';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=25; $w=95; $h=100;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=125;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 2';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=5; $y=140; $w=95; $h=100;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=240;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 3';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=140; $w=95; $h=100;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=240;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 4';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);





//Width = Full, Height = Half
$pdf->AddPage('A4', 'Portrait');
$x=5; $y=25; $w=200; $h=100;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=125;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 31';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=5; $y=140; $w=200; $h=115;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=256;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 32';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);




//Width = Half, Height = Full
$pdf->AddPage('A4', 'Portrait');
$x=5; $y=25; $w=95; $h=230;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=256;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 1';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

$x=105; $y=25; $w=100; $h=230;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=105; $y=256;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode 2';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);




//Width = Full, Height = Full
$pdf->AddPage('A4', 'Portrait');
$x=5; $y=25; $w=200; $h=230;
$pdf->Image('../../image/transaction/Weightcheck.jpg', $x, $y, $w, $h, '', '', '', false, 150, '', false, false, 1, false, false, false);
$x=5; $y=256;
$pdf->SetXY($x, $y); // adjust X and Y as needed
$CheckName = 'Barcode';
$pdf->Cell(0, 0, $CheckName, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);



//Width = 3/1, Height = Full
// $pdf->AddPage('A4', 'Portrait');
// $pdf->Image('../../image/transaction/Weightcheck.jpg', 5, 25, 65, 230, '', '', '', false, 150, '', false, false, 1, false, false, false);
// $pdf->SetXY(5, 256); // adjust X and Y as needed
// $CheckName = 'Barcode 11';
// $pdf->Cell(0, 0, $CheckName, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);

// $pdf->Image('../../image/transaction/Weightcheck.jpg', 73, 25, 65, 230, '', '', '', false, 150, '', false, false, 1, false, false, false);
// $pdf->SetXY(73, 256); // adjust X and Y as needed
// $CheckName = 'Barcode 12';
// $pdf->Cell(0, 0, $CheckName, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);

// $pdf->Image('../../image/transaction/Weightcheck.jpg', 141, 25, 65, 230, '', '', '', false, 150, '', false, false, 1, false, false, false);
// $pdf->SetXY(141, 256); // adjust X and Y as needed
// $CheckName = 'Barcode 13';
// $pdf->Cell(0, 0, $CheckName, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);






// $html = '<!DOCTYPE html>
//             <html>
//                 <head>
//                     <meta name="viewport" content="width=device-width, initial-scale=1.0" />	
//                     <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                
//                         <style>
                               

//                         </style>  
//                 </head>

//                <body>     
                    
//                   <div>
//                      <img src="../../image/transaction/Weightcheck.jpg" alt="Photo" width="200" height="200"> <br/>
//                      <span>Check Name</span>
//                   </div>

//                   <div>
//                      <img src="../../image/transaction/Weightcheck.jpg" alt="Photo" width="200" height="200"> 
//                      <span>Check Name</span>

//                   </div>
                  
//                </body>    





               
//         </html>';

//output the HTML content
// $pdf->writeHTML($html, true, false, true, false, '');



// $pdf->SetY(252);

// $tblp2 = '
// <style>
// .underlined2 { 
//     border-bottom: 0.30em solid #000;

// }
// .underlined { 
//     border-bottom: 0.30em solid #000;       
// }
// </style>
// </br></br></br></br></br><div style="margin-top:30px;">


//             <table style="padding-left:0px; margin-left:0px; font-size: 11px; solid #403c3c;" class="table display" width="100%" cellspacing="0">
//                 <tbody >
//                     <tr>
//                          <td style="width:5%;" > </td>

//                         <td style="width:25%; font-size: 11px;" align="center">
//                             <div class="underlined"></div>
//                                 Service Engineer
//                         </td>

//                         <td style="width:40%;" > </td>

//                         <td style="width:25%; font-size: 11px;" align="center" >
//                             <div class="underlined"></div>
//                                 Head Of Service
//                         </td>

//                         <td style="width:5%;" > </td>

//                     </tr>


//                 </tbody>
//             </table>
// </div>';

// $pdf->writeHTML($tblp2, true, false, true, false, '');


// set color for text
$pdf->setTextColor(0, 63, 127);

//Write($h, $txt, $link='', $fill=0, $align='', $ln=false, $stretch=0, $firstline=false, $firstblock=false, $maxh=0)

// write the text
// $pdf->writeHTMLCell(5, $utf8text, '', 0, '', false, 0, false, false, 0);
// $pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
// $pdf->writeHTMLCell(0, 0, '', '', $utf8text, 0, 1, 0, true, '', true);


// ---------------------------------------------------------

//$pdf->lastPage();

$exportTime = date("Y-m-d-His", time());
$file = 'InspectionReport-' . $exportTime . '.pdf'; //Save file name
//$pdf->Output(dirname(__FILE__).'/media/'.$file, 'F');
$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $file, 'F');

$pdfFileNameArray = "../../media/files/" . $file;

$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $pdfFileNameArray, 'I');


//============================================================+
// END OF FILE
//============================================================+
