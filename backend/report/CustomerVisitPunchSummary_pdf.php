<?php

include_once('../env.php');
include_once('../source/api/pdolibs/pdo_lib.php');
include_once('../source/api/pdolibs/function_global.php');

$db = new Db();

$DepartmentId = $_REQUEST['DepartmentId'];
$VisitorId = $_REQUEST['VisitorId'];
$StartDate = $_REQUEST['StartDate'];
$EndDate = $_REQUEST['EndDate'] . " 23-59-59";;
// $TransactionId = $_REQUEST['TransactionId'];
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

class MYPDF extends TCPDF
{

    //Page header

    public function Header() {}

    // Page footer
    public function Footer() {}
}


$sqlf = "SELECT a.UserId id, b.UserCode AS UserId,b.UserName,
            ifnull(sum(a.ApprovedConveyanceAmount),0) ApprovedConveyanceAmount,
			ifnull(sum(a.ApprovedRefreshmentAmount),0) ApprovedRefreshmentAmount,
			ifnull(sum(a.ApprovedDinnerBillAmount),0) ApprovedDinnerBillAmount,
            (ifnull(sum(a.ApprovedConveyanceAmount),0) +
			ifnull(sum(a.ApprovedRefreshmentAmount),0)+
            ifnull(sum(a.ApprovedDinnerBillAmount),0)) RowTotal
			,b.LinemanUserId,c.UserName as LinemanUserName, bb.DepartmentName,
		e.BusinessLineName AS CustomerName
			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
			inner join t_department bb on b.DepartmentId=bb.DepartmentId
			inner join t_users c on b.LinemanUserId =c.UserId
			inner join t_customer d on a.CustomerId =d.CustomerId
			inner join t_businessline e on b.BusinessLineId =e.BusinessLineId

			where a.TransactionTypeId=1
			AND (b.DepartmentId=$DepartmentId OR $DepartmentId=0)
			AND (a.UserId=$VisitorId OR $VisitorId=0)
			AND (a.TransactionDate BETWEEN '$StartDate' and '$EndDate')
			group by bb.DepartmentName,a.UserId, b.UserCode,b.UserName,b.LinemanUserId,c.UserName
			ORDER BY bb.DepartmentName,b.UserCode,b.UserName ASC;";

$sqlLoop1result = $db->query($sqlf);
$dataList = '';
$sl = 1;

$SubTotalApprovedConveyanceAmount = 0;
$SubTotalApprovedRefreshmentAmount = 0;
$SubTotalApprovedDinnerBillAmount = 0;
$SubTotal = 0;

$GrandTotalApprovedConveyanceAmount = 0;
$GrandTotalApprovedRefreshmentAmount = 0;
$GrandTotalApprovedDinnerBillAmount = 0;
$GrandTotal = 0;

$tempDepartmentName= '';


foreach ($sqlLoop1result as $result) {

    

 /**Group name start */
 if($tempDepartmentName != $result["DepartmentName"]){


    /**Sub Total */
    if($tempDepartmentName != ""){
            /**sub Name */ 
        $dataList.= '<tr style="font-size: 11px;">
            <td  style="width:5% !important;" class="center-aln border_Remove"></td>
            <td style="width:10% !important;" class="center-aln border_Remove"></td>
            <td style="width:23% !important;font-weight: bold;" class="border_Remove">Sub Total</td> 
            <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedConveyanceAmount).'</td>
            <td style="width:9% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedRefreshmentAmount).'</td>
            <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedDinnerBillAmount).'</td>
            <td style="width:7% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotal).'</td>
            <td style="width:15% !important;" class="border_Remove"></td>
            <td style="width:17% !important;" class="border_Remove"></td>
            </tr>';
            // <td style="width:12% !important;" class="center-aln border_Remove"></td>
   
        $SubTotalApprovedConveyanceAmount = 0;
        $SubTotalApprovedRefreshmentAmount = 0;
        $SubTotalApprovedDinnerBillAmount = 0;
        $SubTotal = 0;
    }


    /**Group Name */
    $dataList.= '<tr style="font-size: 11px;">
        <td  style="width:5% !important;" class="center-aln border_Remove"></td>
        <td style="width:10% !important;font-weight: bold;" class="center-aln border_Remove">'.$result["DepartmentName"].'</td>
        <td style="width:23% !important;" class="border_Remove"></td> 
        <td style="width:8% !important;" class="right-aln border_Remove"></td>
        <td style="width:9% !important;" class="right-aln border_Remove"></td>
        <td style="width:8% !important;" class="right-aln border_Remove"></td>
        <td style="width:7% !important;" class="right-aln border_Remove"></td>
        <td style="width:15% !important;" class="border_Remove"></td>
        <td style="width:17% !important;" class="border_Remove"></td>
        </tr>';
        // <td style="width:12% !important;" class="center-aln border_Remove"></td>

    $tempDepartmentName = $result["DepartmentName"];
}




    $dataList.= '<tr style="font-size: 11px;">
    <td  style="width:5% !important;" class="center-aln border_Remove">' .$sl++.'</td>
    <td style="width:10% !important;" class="center-aln border_Remove">'.$result['UserId'].'</td>
    <td style="width:23% !important;" class="border_Remove">'.$result['UserName'].'</td> 
    <td style="width:8% !important;" class="right-aln border_Remove">'. $result['ApprovedConveyanceAmount'].'</td>
    <td style="width:9% !important;" class="right-aln border_Remove">'.$result['ApprovedRefreshmentAmount'].'</td>
    <td style="width:8% !important;" class="right-aln border_Remove">'.$result['ApprovedDinnerBillAmount'].'</td>
    <td style="width:7% !important;" class="right-aln border_Remove">'.$result['RowTotal'].'</td>
    <td style="width:15% !important;" class="border_Remove">'. $result['LinemanUserName'].'</td>
    <td style="width:17% !important;" class="border_Remove">'. $result['CustomerName'].'</td>
    </tr>';

    // <td style="width:12% !important;" class="center-aln border_Remove">'. $result['LinemanUserId'].'</td>

/**For sub total */
$SubTotalApprovedConveyanceAmount += $result["ApprovedConveyanceAmount"];
$SubTotalApprovedRefreshmentAmount += $result["ApprovedRefreshmentAmount"];
$SubTotalApprovedDinnerBillAmount += $result["ApprovedDinnerBillAmount"];
$SubTotal += $result["RowTotal"];

/**For Grand total */
$GrandTotalApprovedConveyanceAmount += $result["ApprovedConveyanceAmount"];
$GrandTotalApprovedRefreshmentAmount += $result["ApprovedRefreshmentAmount"];
$GrandTotalApprovedDinnerBillAmount += $result["ApprovedDinnerBillAmount"];
$GrandTotal += $result["RowTotal"];




}




 /**Grand Total */
 if($sl > 1){
    /**For sub total */
         $dataList.= '<tr style="font-size: 11px;">
         <td  style="width:5% !important;" class="center-aln border_Remove"></td>
         <td style="width:10% !important;" class="center-aln border_Remove"></td>
         <td style="width:23% !important;font-weight: bold;" class="border_Remove">Sub Total</td> 
         <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedConveyanceAmount).'</td>
         <td style="width:9% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedRefreshmentAmount).'</td>
         <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotalApprovedDinnerBillAmount).'</td>
         <td style="width:7% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($SubTotal).'</td>
         <td style="width:15% !important;" class="border_Remove"></td>
         <td style="width:17% !important;" class="border_Remove"></td>
         </tr>';
        //  <td style="width:12% !important;" class="center-aln border_Remove"></td>
    
    /**For grand total */
        $dataList.= '<tr style="font-size: 11px;">
        <td  style="width:5% !important;" class="center-aln border_Remove"></td>
        <td style="width:10% !important;" class="center-aln border_Remove"></td>
        <td style="width:23% !important;font-weight: bold;" class="border_Remove">Grand Total</td> 
        <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($GrandTotalApprovedConveyanceAmount).'</td>
        <td style="width:9% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($GrandTotalApprovedRefreshmentAmount).'</td>
        <td style="width:8% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($GrandTotalApprovedDinnerBillAmount).'</td>
        <td style="width:7% !important;font-weight: bold;" class="right-aln border_Remove">'.number_format($GrandTotal).'</td>
        <td style="width:15% !important;" class="border_Remove"></td>
        <td style="width:17% !important;" class="border_Remove"></td>
        </tr>';
        // <td style="width:12% !important;" class="center-aln border_Remove"></td>

    }




$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//$pdf->Header();
// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Inspection');
$pdf->setTitle('Visit Punch Summary');

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


$tblHeader0 = '<!DOCTYPE html>
            <html>
                <head>
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />	
                    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
                
                        <style>
                                .center-aln {
                                    text-align: center !important;
                                    margin-top:0px!important;
                                    
                                    margin-bottom:1px!important;
                                }
                                h2,h3{
                                    margin:0px !important;
                                    padding:0px !important;
                                    line-height: 8px !important;
                                }

                                .underlined { 
                                    border-bottom: 0.30em solid #000;
                                }
                            
                                .fontsizechange tr th{
                                    font-size: 10px;
                                    //font-style: italic;
                                    font-weight: bold;
                                    vertical-align: middle !important;
                                    
                                }
                                .fontsizechange tr td
                                {
                                    font-size: 10px;
                                    vertical-align: middle !important;
                                    
                                }

                            
                                body {
                                    color:black;
                                    font-size: 10px;
                                }
                                table.display tr.even.row_selected td {
                                    background-color: #4DD4FD;
                                }    
                                table.display tr.odd.row_selected td {
                                    background-color: #4DD4FD;
                                }
                                .SL{
                                    text-align: center !important;
                                }
                                .right-aln{
                                    text-align: right !important;
                                }
                                .left-aln{
                                    text-align: left !important;
                                }
                                .center-aln {
                                    text-align: center !important;
                                    margin-top:0px!important;
                                    
                                    margin-bottom:1px!important;
                                }

                        </style>  
                </head>
                        
                    <h2 class="center-aln" style="font-size: 15px; ">Visit Punch Summary</h2>
                    <h6 class="center-aln" style="font-size: 11px; ">From: '.$StartDate.' To '.$_REQUEST['EndDate'].'</h6>
                    
                    
                    <table class="fontsizechange" cellpadding="2"  border="0.5"  cellspacing="0" width="100%" >
                    <tbody >
                        <thead>
                            <tr class="ittaliy">
                                <th rowspan="1" style="width:5% !important;" class="center-aln" >Sl#</th>
                                <th rowspan="1" style="width:10% !important;" class="center-aln ">Employee ID</th>
                                <th rowspan="1" style="width:23% !important;" >Employee Name</th>
                                <th rowspan="1" style="width:8% !important;" class="right-aln ">Conveyance</th>
                                <th rowspan="1" style="width:9% !important;" class="right-aln ">Refreshment</th>
                                <th rowspan="1" style="width:8% !important;" class="right-aln ">Dinner Bill</th>
                                <th rowspan="1" style="width:7% !important;" class="right-aln ">Total</th>
                                <th rowspan="1" style="width:15% !important;" >HOT Name</th>
                                <th rowspan="1" style="width:17% !important;" >Company Name</th>
                            </tr>
                        </thead>
                        '.$dataList.'

                </tbody>
                <tfoot>
                </tfoot>
            </table>



        </html>';
        // <th rowspan="1" style="width:12% !important;  class="center-aln"">Line Manager ID</th>

//output the HTML content
$pdf->writeHTML($tblHeader0, true, false, true, false, '');


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
$file = 'VisitPunchSummary-' . $exportTime . '.pdf'; //Save file name
//$pdf->Output(dirname(__FILE__).'/media/'.$file, 'F');
$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $file, 'F');

$pdfFileNameArray = "../../media/files/" . $file;
// $m++;
//$pdf->pdfFileNameArray[] = $file;
//$stringFilse .= "'../../media/files/".$pdfFileNameArray[$ij]."',";
//$stringFilse .= '"../../media/files/'.$pdfFileNameArray[$ij].'",';




// require_once("merge-pdf-files-master/MergePdf.class.php");


// if ($m > 1){

//     MergePdf::merge(
//         $pdfFileNameArray,
//         MergePdf::DESTINATION__DISK_INLINE
//     );


//     /*  MergePdf::merge(
//         Array(
//             '../../media/files/'.$pdfFileNameArray[0],
//             '../../media/files/'.$pdfFileNameArray[1],
//             '../../media/files/'.$pdfFileNameArray[2],
//             '../../media/files/'.$pdfFileNameArray[3],
//             '../../media/files/'.$pdfFileNameArray[4],
//         ),
//         MergePdf::DESTINATION__DISK_INLINE

//     ); */
//     echo 1111;
//     echo $pdfFileNameArray[0];
//     exit;
// }else{

/* MergePdf::merge(
        Array(
            'media/'.$pdfFileNameArray[0],
        ),
        MergePdf::DESTINATION__DISK_INLINE,
    ); */
// echo 2222;
// echo $pdfFileNameArray[0];
// exit;
//$pdf->Output('media/'.$pdfFileNameArray[0], 'I');
$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $pdfFileNameArray, 'I');

// }


//============================================================+
// END OF FILE
//============================================================+
