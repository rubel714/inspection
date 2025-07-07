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

$sqlf = "SELECT a.TransactionId id,DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS TransactionDate,
			b.UserCode AS UserId,b.UserName,a.PunchLocation,c.DisplayName AS Purpose,d.CustomerCode,d.CustomerName,a.ContactPersonName,a.ContactPersonDesignation,
			a.ContactPersonMobileNumber,c.DisplayName AS Transportation,a.ApprovedConveyanceAmount,a.ApprovedRefreshmentAmount,a.ApprovedDinnerBillAmount
			,f.UserCode as LinemanUserId,f.UserName as LinemanUserName, a.SelfDiscussion,a.LMAdvice,

            g.MachineName,h.MachineModelName
			,a.MachineSerial,a.MachineComplain
			,(SELECT GROUP_CONCAT(concat(n.MachinePartsName,' (',round(m.Qty),')')) 
				FROM `t_transaction_machineparts` m 
				inner join t_machineparts n on m.MachinePartsId=n.MachinePartsId 
				where m.TransactionId=a.TransactionId) as MachineParts

			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
			inner join t_dropdownlist c on a.DropDownListIDForPurpose=c.DropDownListID
			inner join t_dropdownlist e on a.DropDownListIDForTransportation=e.DropDownListID
			inner join t_customer d on a.CustomerId =d.CustomerId
			inner join t_users f on b.LinemanUserId =f.UserId
            left join t_machine g on a.MachineId =g.MachineId
			left join t_machinemodel h on a.MachineModelId =h.MachineModelId
			where a.TransactionTypeId=1
			AND (b.DepartmentId=$DepartmentId OR $DepartmentId=0)
			AND (a.UserId=$VisitorId OR $VisitorId=0)
			AND (a.TransactionDate BETWEEN '$StartDate' and '$EndDate')
			ORDER BY a.TransactionDate DESC;";

$sqlLoop1result = $db->query($sqlf);
$dataList = '';
$sl = 1;

foreach ($sqlLoop1result as $result) {

    $dataList.= '<tr style="font-size: 11px;">
    <td  style="width:5% !important;" class="center-aln border_Remove">' .$sl++.'</td>
    <td style="width:5% !important;" class="border_Remove">'.$result['TransactionDate'].'</td>
    <td style="width:5% !important;" class="center-aln border_Remove">'.$result['UserId'].'</td> 
    <td style="width:5% !important;" class="border_Remove">'. $result['UserName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'.$result['PunchLocation'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['Purpose'].'</td>
    <td style="width:5% !important;" class="center-aln border_Remove">'. $result['CustomerCode'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['CustomerName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['ContactPersonName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['ContactPersonDesignation'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['ContactPersonMobileNumber'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['Transportation'].'</td>
    <td style="width:5% !important;" class="right-aln border_Remove">'. $result['ApprovedConveyanceAmount'].'</td>
    <td style="width:5% !important;" class="right-aln border_Remove">'. $result['ApprovedRefreshmentAmount'].'</td>
    <td style="width:5% !important;" class="right-aln border_Remove">'. $result['ApprovedDinnerBillAmount'].'</td>
    <td style="width:5% !important;" class="center-aln border_Remove">'. $result['LinemanUserId'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['LinemanUserName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['SelfDiscussion'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['LMAdvice'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['MachineName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['MachineParts'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['MachineSerial'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['MachineModelName'].'</td>
    <td style="width:5% !important;" class="border_Remove">'. $result['MachineComplain'].'</td>
    </tr>';
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


//$pdf->Header();
// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('Inspection');
$pdf->setTitle('Visit Punch Ledger');

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
                        
                    <h2 class="center-aln" style="font-size: 15px; ">Visit Punch Ledger</h2>
                    <h6 class="center-aln" style="font-size: 11px; ">From: '.$StartDate.' To '.$_REQUEST['EndDate'].'</h6>
                    
                    
                    <table class="fontsizechange" cellpadding="2"  border="0.5"  cellspacing="0" width="100%" >
                    <tbody >
                        <thead>
                            <tr class="ittaliy">
                                <th rowspan="1" style="width:5% !important;" class="center-aln" >Sl#</th>
                                <th rowspan="1" style="width:5% !important;">Visit Date</th>
                                <th rowspan="1" style="width:5% !important;" class="center-aln">Employee ID</th>
                                <th rowspan="1" style="width:5% !important;">Employee Name</th>
                                <th rowspan="1" style="width:5% !important;">Punch Location</th>
                                <th rowspan="1" style="width:5% !important; ">Visit Purpose</th>
                                <th rowspan="1" style="width:5% !important;" >Customer No</th>
                                <th rowspan="1" style="width:5% !important;" >Customer Name</th>
                                <th rowspan="1" style="width:5% !important;" >Contact Per. Name</th>
                                <th rowspan="1" style="width:5% !important;" >Contact Per. Designation</th>
                                <th rowspan="1" style="width:5% !important;" >Contact Per. Mobile</th>
                                <th rowspan="1" style="width:5% !important;" >Transportation</th>
                                <th rowspan="1" style="width:5% !important;" class="right-aln">Conveyance</th>
                                <th rowspan="1" style="width:5% !important;" class="right-aln">Refreshment</th>
                                <th rowspan="1" style="width:5% !important;" class="right-aln">Dinner Bill</th>
                                <th rowspan="1" style="width:5% !important;"class="center-aln" >LM ID</th>
                                <th rowspan="1" style="width:5% !important;" >LM Name</th>
                                <th rowspan="1" style="width:5% !important;" >Self Discussion</th>
                                <th rowspan="1" style="width:5% !important;" >LM Advice</th>
                                <th rowspan="1" style="width:5% !important;" >Machine Name</th>
                                <th rowspan="1" style="width:5% !important;" >Machine Parts</th>
                                <th rowspan="1" style="width:5% !important;" >Serial No</th>
                                <th rowspan="1" style="width:5% !important;" >Model No</th>
                                <th rowspan="1" style="width:5% !important;" >Customer Complaint/Problem/Symptom Description</th>
                            </tr>
                        </thead>
                        '.$dataList.'

                </tbody>
                <tfoot>
                </tfoot>
            </table>



        </html>';

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
$file = 'VisitPunchLedger-' . $exportTime . '.pdf'; //Save file name
//$pdf->Output(dirname(__FILE__).'/media/'.$file, 'F');
$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $file, 'F');

$pdfFileNameArray = "../../media/files/" . $file;

$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $pdfFileNameArray, 'I');

//============================================================+
// END OF FILE
//============================================================+
