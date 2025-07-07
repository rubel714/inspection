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

class MYPDF extends TCPDF
{

    //Page header

    public function Header() {}

    // Page footer
    public function Footer() {}
}







$sqlf = "SELECT a.TransactionId id,
			DATE_FORMAT(a.TransactionDate, '%d-%b-%Y') AS TransactionDate,
			DATE_FORMAT(a.TransactionDate, '%h:%i:%s %p') AS TimeIn,
			'' AS TimeOut,a.UserId,b.UserName,d.CustomerCode,d.CustomerName,d.CompanyAddress as Address,g.MachineName,h.MachineModelName
			,a.MachineSerial,a.MachineComplain
			,(SELECT GROUP_CONCAT(concat(n.MachinePartsName,' (',round(m.Qty),')')) FROM `t_transaction_machineparts` m 
				inner join t_machineparts n on m.MachinePartsId=n.MachinePartsId 
				where m.TransactionId=a.TransactionId) as MachineParts
			,a.SelfDiscussion,a.customerToSuggestion as SuggestionToCustomer,a.customerBySuggestion as SuggestionFromCustomer
            ,a.ContactPersonName,a.ContactPersonDesignation,a.ContactPersonMobileNumber,a.customerSignature

			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
			inner join t_customer d on a.CustomerId =d.CustomerId
			inner join t_machine g on a.MachineId =g.MachineId
			inner join t_machinemodel h on a.MachineModelId =h.MachineModelId
			where a.TransactionTypeId=1
			AND a.TransactionId = $TransactionId
			ORDER BY a.TransactionDate DESC;";
$sqlLoop1result = $db->query($sqlf);

$dataList = '';

$sl = 1;

$TransactionDate = "";
$TimeIn = "";
$TimeOut = "";
$UserName = "";
$CustomerName = "";
$Address = "";
$MachineName = "";
$MachineModelName = "";
$MachineSerial = "";
$MachineComplain = "";
$MachineParts = "";
$SelfDiscussion = "";
$SuggestionToCustomer = "";
$SuggestionFromCustomer = "";
$ContactPersonName = "";
$ContactPersonDesignation = "";
$ContactPersonMobileNumber = "";
$customerSignature = "";

foreach ($sqlLoop1result as $result) {
    $TransactionDate = $result['TransactionDate'];
    $TimeIn = $result['TimeIn'];
    $TimeOut = $result['TimeOut'];
    $UserName = $result['UserName'];
    $CustomerName = $result['CustomerName'];
    $Address = $result['Address'];
    $MachineName = $result['MachineName'];
    $MachineModelName = $result['MachineModelName'];
    $MachineSerial = $result['MachineSerial'];
    $MachineComplain = $result['MachineComplain'];
    $MachineParts = $result['MachineParts'];
    $SelfDiscussion = $result['SelfDiscussion'];
    $SuggestionToCustomer = $result['SuggestionToCustomer'];
    $SuggestionFromCustomer = $result['SuggestionFromCustomer'];
    $ContactPersonName = $result['ContactPersonName'];
    $ContactPersonDesignation = $result['ContactPersonDesignation'];
    $ContactPersonMobileNumber = $result['ContactPersonMobileNumber'];
    $customerSignature = $result['customerSignature'];
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
$pdf->setTitle('Machinery Service Report');

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
$pdf->Image('../../image/appmenu/reportheaderimage.png', 7, 2, 105, 22, 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

$tblHeader0 = '<br/><br/><br/><!DOCTYPE html>
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
                                    font-size: 12px;
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
                        
                    <h2 class="right-aln" style="font-size: 15px; ">Machinery Service Report</h2>

                    <table style="padding-left:0px; margin-left:0px; font-size: 11px; solid #403c3c;" class="table display" width="100%" cellspacing="0">
                    <tbody >
                    <tr>
                        <td style="width:10%;">&nbsp;</td>
                    </tr>
            
                    <tr >
                        <td style="width:20%;">
                             <b> <span>' . 'Date:' . '</span></b>&nbsp;: ' . $TransactionDate . '
                        </td>
                        <td style="width:20%;" >
                         <span><b>' . 'Time In' . '</span></b> &nbsp; &nbsp; ' . $TimeIn . ' 
                        </td>  
                         <td style="width:15%;" >
                         <span><b>' . 'Time Out' . '</span></b> &nbsp; &nbsp; ' . $TimeOut . ' 
                        </td>  
                        <td style="width:45%;" >
                         <span><b>' . 'Service Engineer' . '</span></b> &nbsp; &nbsp; ' . $UserName . ' 
                        </td>  
                    </tr>
                    <tr>
                        <td style="width:10%;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width:100%;">
                             <b> <span>' . 'Customer Name:' . '</span></b>&nbsp;: ' . $CustomerName . '
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;">&nbsp;</td>
                    </tr>
                    <tr >
                        <td style="width:100%;">
                             <b> <span>' . 'Address:' . '</span></b>&nbsp;: ' . $Address . '
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%;">&nbsp;</td>
                    </tr>

                    <tr >
                        <td style="width:40%;">
                             <b> <span>' . 'Machine Name:' . '</b></span>&nbsp;: ' . $MachineName . '
                        </td>
                        <td style="width:40%;">
                             <b> <span>' . 'Model No:' . '</b></span>&nbsp;: ' . $MachineModelName . '
                        </td>
                        <td style="width:20%;">
                             <b> <span>' . 'Serial No:' . '</b></span>&nbsp;: ' . $MachineSerial . '
                        </td>
                    </tr>
       
 
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td style="width:100%;"><b>Customer Complaint/Problem/Symptom Description</b></td>
                    </tr>
                    <tr>
                        <td style="width:100%; border:1px solid gray; height: 60px;">'.$MachineComplain.'</td>
                    </tr>

                    
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td style="width:100%;"><b>Machine Parts</b></td>
                    </tr>
                    <tr>
                        <td style="width:100%; border:1px solid gray; height: 60px;">'.$MachineParts.'</td>
                    </tr>
            
 
                    
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td style="width:100%;"><b>Service Contents</b></td>
                    </tr>
                    <tr>
                        <td style="width:100%; border:1px solid gray; height: 60px;">'.$SelfDiscussion.'</td>
                    </tr>


                                        
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td style="width:100%;"><b>Suggestion to Customer to Rectify the Problem</b></td>
                    </tr>
                    <tr>
                        <td style="width:100%; border:1px solid gray; height: 60px;">'.$SuggestionToCustomer.'</td>
                    </tr>


                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                  
                    <tr>
                        <td style="width:100%;"><b>Suggestion by Customer</b></td>
                    </tr>
                    <tr>
                        <td style="width:100%; border:1px solid gray; height: 60px;">'.$SuggestionFromCustomer.'</td>
                    </tr>



                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                    <tr >
                       <td style="width:100%;"><b>Customers Representative</b></td>
                    </tr>

                    <tr >
                       <td style="width:20%;"></td>
                       <td style="width:30%;"><b>Name</b></td>
                       <td style="width:20%;"><b>Designation</b></td>
                       <td style="width:30%;"><b>Signature</b></td>
                    </tr>
                    <tr >
                       <td style="width:20%;"></td>
                       <td style="width:30%;">'.$ContactPersonName.'</td>
                       <td style="width:20%;">'.$ContactPersonDesignation.'</td>
                       <td style="width:30%;"><img src="../../image/transaction/'.$customerSignature.'" alt="" width="100" height="40"></td>
                    </tr>

                     <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                    <tr >
                       <td style="width:50%;">1..............................................................................................................</td>
                       <td style="width:20%;">................................................</td>
                       <td style="width:30%;">................................................</td>
                    </tr>
                   
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                    <tr >
                       <td style="width:50%;">2..............................................................................................................</td>
                       <td style="width:20%;">................................................</td>
                       <td style="width:30%;">................................................</td>
                    </tr>
                    
                    <tr>
                        <td style="width:100%;">&nbsp;</td>
                    </tr>
                    <tr >
                       <td style="width:50%;">3..............................................................................................................</td>
                       <td style="width:20%;">................................................</td>
                       <td style="width:30%;">................................................</td>
                    </tr>

                    </tbody>
                </table>
        </html>';

//output the HTML content
$pdf->writeHTML($tblHeader0, true, false, true, false, '');

 

$pdf->SetY(252);

$tblp2 = '
<style>
.underlined2 { 
    border-bottom: 0.30em solid #000;
    
}
.underlined { 
    border-bottom: 0.30em solid #000;       
}
</style>
</br></br></br></br></br><div style="margin-top:30px;">


            <table style="padding-left:0px; margin-left:0px; font-size: 11px; solid #403c3c;" class="table display" width="100%" cellspacing="0">
                <tbody >
                    <tr>
                         <td style="width:5%;" > </td>

                        <td style="width:25%; font-size: 11px;" align="center">
                            <div class="underlined"></div>
                                Service Engineer
                        </td>

                        <td style="width:40%;" > </td>

                        <td style="width:25%; font-size: 11px;" align="center" >
                            <div class="underlined"></div>
                                Head Of Service
                        </td>
                        
                        <td style="width:5%;" > </td>
                      
                    </tr>


                </tbody>
            </table>
</div>';

$pdf->writeHTML($tblp2, true, false, true, false, '');


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
$file = 'MachineryServiceReport-' . $exportTime . '.pdf'; //Save file name
//$pdf->Output(dirname(__FILE__).'/media/'.$file, 'F');
$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $file, 'F');

$pdfFileNameArray = "../../media/files/" . $file;

$pdf->Output(dirname(__FILE__) . '/../../media/files/' . $pdfFileNameArray, 'I');


//============================================================+
// END OF FILE
//============================================================+
