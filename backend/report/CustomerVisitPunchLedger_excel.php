<?php

/* Database Connection */
include_once ('../env.php');
include_once ('../source/api/pdolibs/pdo_lib.php');
include_once ('../source/api/pdolibs/function_global.php');


/* include PhpSpreadsheet library */
require("PhpSpreadsheet/vendor/autoload.php");

$db = new Db();

$DepartmentId = $_REQUEST['DepartmentId'];
$VisitorId = $_REQUEST['VisitorId'];
$StartDate = $_REQUEST['StartDate'];
$EndDate = $_REQUEST['EndDate'] . " 23-59-59";;
// $TransactionId = $_REQUEST['TransactionId'];
 
$siteTitle = reportsitetitleeng;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

$spreadsheet = new Spreadsheet();

	//Activate work sheet
	$spreadsheet->createSheet(0);
	$spreadsheet->setActiveSheetIndex(0);
	$spreadsheet->getActiveSheet(0);
	//work sheet name
	$spreadsheet->getActiveSheet()->setTitle('Data');
	/* Default Font Set */
	$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
	/* Default Font Size Set */
	$spreadsheet->getDefaultStyle()->getFont()->setSize(11);

	/* Border color */
	$styleThinBlackBorderOutline = array('borders' => array('outline' => array('borderStyle' => Border::BORDER_THIN, 'color' => array('argb' => '5a5a5a'))));
	$rn=2;


	
	// $reporttitlelist[] =  $siteTitle;
    $reporttitlelist[] = "Visit Punch Ledger";
	$reporttitlelist[] = "Start Date: ".$StartDate.", End Date: " . $_REQUEST['EndDate'];
	for($p = 0; $p < count($reporttitlelist); $p++){
		
		$spreadsheet->getActiveSheet()->SetCellValue('A'.$rn, $reporttitlelist[$p]);
		$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getFont();
		/* Font Size for Cells */
		$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '13', 'bold' => true)), 'C'.$rn);
		/* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
		$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
		/* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
		$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
		/* merge Cell */
		$spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':X'.$rn);
		$rn++;
	 }

	//  $spreadsheet->getActiveSheet()->SetCellValue('A'.$rn, "Dispense");
	//  $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getFont();
	//  $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'C'.$rn);
	//  $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	//  $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
	//  $spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':L'.$rn);
	//  $rn++;

	// $spreadsheet->getActiveSheet()->SetCellValue('A'.$rn, $resultdata[0]['FacilityName']);
	// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getFont();
	// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'C'.$rn);
	// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
	// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
	// $spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':L'.$rn);
	// $rn++;


/* Font Size for Cells */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '13', 'bold' => false)), 'C'.$rn);
/* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);
/* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
/* merge Cell */
//$spreadsheet->getActiveSheet()->mergeCells('A3:H3');
//$spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':I'.$rn);
// $rn++;
// //$spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':I'.$rn);
// $rn = $rn+1;


/* HEADER SECTION STARTS */
/* HEADER LEFT SECTION */
// $StartDate = "2023";//isset($resultdata[0]['InvoiceNo']) ? $resultdata[0]['InvoiceNo'] : "";
// $spreadsheet->getActiveSheet()->SetCellValue('B'.$rn, "Inv Price" . " : " . $SubHeaderObj->InvPrice);
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getFont();
// /* Font Size for Cells */
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->applyFromArray(array('font' => array('size' => '10', 'bold' => true)), 'B'.$rn);
// /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// /* merge Cell */
// // $spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':B'.$rn);

// // $EndDate = $_REQUEST['EndDate'];//isset($resultdata[0]['ChallanNo']) ? $resultdata[0]['ChallanNo'] : "";
// $spreadsheet->getActiveSheet()->SetCellValue('C'.$rn, "Disc Amt (-)️" . " : " . $SubHeaderObj->DiscAmt);
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getFont();
// /* Font Size for Cells */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->applyFromArray(array('font' => array('size' => '10', 'bold' => true)), 'C'.$rn);
// /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// /* merge Cell */
// // $spreadsheet->getActiveSheet()->mergeCells('C'.$rn.':D'.$rn);


// $spreadsheet->getActiveSheet()->SetCellValue('E'.$rn, "");
// $spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getFont();
// /* Font Size for Cells */
// $spreadsheet->getActiveSheet()->getStyle('E'.$rn)->applyFromArray(array('font' => array('size' => '10', 'bold' => true)), 'A5');
// /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
// $spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// /* merge Cell */
// //$spreadsheet->getActiveSheet()->mergeCells('E'.$rn.':H'.($rn+3));
// $rn++;

// $ReceiveDate = isset($resultdata[0]['TransactionDate']) ? getDateFormat($resultdata[0]['TransactionDate']) : "";
// $spreadsheet->getActiveSheet()->SetCellValue('A'.$rn, "Dispense Date" . " : " . $ReceiveDate);
// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getFont();
// /* Font Size for Cells */
// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '10', 'bold' => true)), 'A'.$rn);
// /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// /* merge Cell */
// $spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':B'.$rn);



// $ApprovedByName = isset($resultdata[0]['ProductId']) ? $resultdata[0]['ProductId'] : "";
// $spreadsheet->getActiveSheet()->SetCellValue('C'.$rn, "Approved By" . " : " . $ApprovedByName);
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getFont();
// /* Font Size for Cells */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->applyFromArray(array('font' => array('size' => '10', 'bold' => true)), 'A'.$rn);
// /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// /* merge Cell */
// $spreadsheet->getActiveSheet()->mergeCells('C'.$rn.':D'.$rn);

// $rn++;







/* HEADER LEFT SECTION ENDS */
/* Fill Color Change function for Cells */
//cellColor('A1:G4', 'd9e1ec');
//cellColor('A4:G4', '9ab1d1');


/* Value Set for Cells */
$rn=$rn+1;
$spreadsheet->getActiveSheet()
        ->SetCellValue('A'.$rn, "Sl#")
        ->SetCellValue('B'.$rn, "Visit Date")
        ->SetCellValue('C'.$rn, "Employee ID")
        ->SetCellValue('D'.$rn, "Employee Name")
        ->SetCellValue('E'.$rn, "Punch Location")
        ->SetCellValue('F'.$rn, "Visit Purpose")
        ->SetCellValue('G'.$rn, "Customer No")
        ->SetCellValue('H'.$rn, "Customer Name")
        ->SetCellValue('I'.$rn, "Contact Per. Name")
        ->SetCellValue('J'.$rn, "Contact Per. Designation")
        ->SetCellValue('K'.$rn, "Contact Per. Mobile")
        ->SetCellValue('L'.$rn, "Transportation")
        ->SetCellValue('M'.$rn, "Conveyance")
        ->SetCellValue('N'.$rn, "Refreshment")
        ->SetCellValue('O'.$rn, "Dinner Bill")
        ->SetCellValue('P'.$rn, "LM ID")
        ->SetCellValue('Q'.$rn, "LM Name")
        ->SetCellValue('R'.$rn, "Self Discussion")
        ->SetCellValue('S'.$rn, "LM Advice")
        ->SetCellValue('T'.$rn, "Machine Name")
        ->SetCellValue('U'.$rn, "Machine Parts")
        ->SetCellValue('V'.$rn, "Serial No")
        ->SetCellValue('W'.$rn, "Model No")
        ->SetCellValue('X'.$rn, "Customer Complaint/Problem/Symptom Description")
		;

/* Font Size for Cells */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'A'.$rn);
$spreadsheet->getActiveSheet()->getStyle('B'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'B'.$rn);
$spreadsheet->getActiveSheet()->getStyle('C'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'C'.$rn);
$spreadsheet->getActiveSheet()->getStyle('D'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'D'.$rn);
$spreadsheet->getActiveSheet()->getStyle('E'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'E'.$rn);
$spreadsheet->getActiveSheet()->getStyle('F'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'F'.$rn);
$spreadsheet->getActiveSheet()->getStyle('G'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'G'.$rn);
$spreadsheet->getActiveSheet()->getStyle('H'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'H'.$rn);
$spreadsheet->getActiveSheet()->getStyle('I'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'I'.$rn);
$spreadsheet->getActiveSheet()->getStyle('J'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'J'.$rn);
$spreadsheet->getActiveSheet()->getStyle('K'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'K'.$rn);
$spreadsheet->getActiveSheet()->getStyle('L'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'L'.$rn);
$spreadsheet->getActiveSheet()->getStyle('M'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'M'.$rn);
$spreadsheet->getActiveSheet()->getStyle('N'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'N'.$rn);
$spreadsheet->getActiveSheet()->getStyle('O'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'O'.$rn);
$spreadsheet->getActiveSheet()->getStyle('P'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'P'.$rn);
$spreadsheet->getActiveSheet()->getStyle('Q'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'Q'.$rn);
$spreadsheet->getActiveSheet()->getStyle('R'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'R'.$rn);
$spreadsheet->getActiveSheet()->getStyle('S'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'S'.$rn);
$spreadsheet->getActiveSheet()->getStyle('T'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'T'.$rn);
$spreadsheet->getActiveSheet()->getStyle('U'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'U'.$rn);
$spreadsheet->getActiveSheet()->getStyle('V'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'V'.$rn);
$spreadsheet->getActiveSheet()->getStyle('W'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'W'.$rn);
$spreadsheet->getActiveSheet()->getStyle('X'.$rn)->applyFromArray(array('font' => array('size' => '12', 'bold' => true)), 'X'.$rn);
/* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('D'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('F'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('G'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('H'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('I'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('J'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('K'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('L'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('M'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('N'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('O'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('P'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('Q'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('R'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('S'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('T'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('U'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('V'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('W'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('X'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

/* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
// $spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// $spreadsheet->getActiveSheet()->getStyle('D'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('F'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('G'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('H'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
// $spreadsheet->getActiveSheet()->getStyle('I'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('J'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('K'.$rn)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
// $spreadsheet->getActiveSheet()->getStyle('L'.$rn)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);

/* Width for Cells */

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(6);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(23);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(14);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(13);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(10);
$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('V')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('X')->setWidth(18);
/* Wrap text */
// $spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setWrapText(true);
// $spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setWrapText(true);

/* border color set for cells */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn.':A'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('B'.$rn.':B'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('C'.$rn.':C'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('D'.$rn.':D'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('E'.$rn.':E'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('F'.$rn.':F'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('G'.$rn.':G'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('H'.$rn.':H'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('I'.$rn.':I'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('J'.$rn.':J'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('K'.$rn.':K'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('L'.$rn.':L'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('M'.$rn.':M'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('N'.$rn.':N'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('O'.$rn.':O'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('P'.$rn.':P'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('Q'.$rn.':Q'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('R'.$rn.':R'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('S'.$rn.':S'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('T'.$rn.':T'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('U'.$rn.':U'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('V'.$rn.':V'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('W'.$rn.':W'.$rn)->applyFromArray($styleThinBlackBorderOutline);
$spreadsheet->getActiveSheet()->getStyle('X'.$rn.':X'.$rn)->applyFromArray($styleThinBlackBorderOutline);

 
$sql = "SELECT a.TransactionId id,DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS TransactionDate,
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

$result = $db->query($sql);
$i = 1;
$j = $rn+1;
$Total = 0;
$tempDatetime = '';

foreach ($result as $row) {

    //Wrap Text
    // $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setWrapText(true);

    /* Value Set for Cells */
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $j, $i)
            ->SetCellValue('B' . $j, $row["TransactionDate"])
            ->SetCellValue('C' . $j, $row["UserId"])
            ->SetCellValue('D' . $j, $row["UserName"])
            ->SetCellValue('E' . $j, $row["PunchLocation"])
            ->SetCellValue('F' . $j, $row["Purpose"])
            ->SetCellValue('G' . $j, $row["CustomerCode"])
            ->SetCellValue('H' . $j, $row["CustomerName"])
            ->SetCellValue('I' . $j, $row["ContactPersonName"])
            ->SetCellValue('J' . $j, $row["ContactPersonDesignation"])
            ->SetCellValue('K' . $j, $row["ContactPersonMobileNumber"])
            ->SetCellValue('L' . $j, $row["Transportation"])
            ->SetCellValue('M' . $j, number_format($row["ApprovedConveyanceAmount"],2))
            ->SetCellValue('N' . $j, number_format($row["ApprovedRefreshmentAmount"],2))
            ->SetCellValue('O' . $j, number_format($row["ApprovedDinnerBillAmount"],2))            
            ->SetCellValue('P' . $j, $row["LinemanUserId"])
            ->SetCellValue('Q' . $j, $row["LinemanUserName"])
            ->SetCellValue('R' . $j, $row["SelfDiscussion"])
            ->SetCellValue('S' . $j, $row["LMAdvice"])
            ->SetCellValue('T' . $j, $row["MachineName"])
            ->SetCellValue('U' . $j, $row["MachineParts"])
            ->SetCellValue('V' . $j, $row["MachineSerial"])
            ->SetCellValue('W' . $j, $row["MachineModelName"])
            ->SetCellValue('X' . $j, $row["MachineComplain"])
			;

    /* border color set for cells */
    $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('I' . $j . ':I' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('J' . $j . ':J' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('K' . $j . ':K' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('L' . $j . ':L' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('M' . $j . ':M' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('N' . $j . ':N' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('O' . $j . ':O' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('P' . $j . ':P' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('Q' . $j . ':Q' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('R' . $j . ':R' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('S' . $j . ':S' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('T' . $j . ':T' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('U' . $j . ':U' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('V' . $j . ':V' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('W' . $j . ':W' . $j)->applyFromArray($styleThinBlackBorderOutline);
    $spreadsheet->getActiveSheet()->getStyle('X' . $j . ':X' . $j)->applyFromArray($styleThinBlackBorderOutline);

    /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
    $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('I' . $j . ':I' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('J' . $j . ':J' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('K' . $j . ':K' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('L' . $j . ':L' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('M' . $j . ':M' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('N' . $j . ':N' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('O' . $j . ':O' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('P' . $j . ':P' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('Q' . $j . ':Q' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('R' . $j . ':R' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('S' . $j . ':S' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('T' . $j . ':T' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('U' . $j . ':U' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('V' . $j . ':V' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('W' . $j . ':W' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('X' . $j . ':X' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

    /* Text Alignment Vertical(VERTICAL_TOP,VERTICAL_CENTER,VERTICAL_BOTTOM) */
    // $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setVertical(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('I' . $j . ':I' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('J' . $j . ':J' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('K' . $j . ':K' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('L' . $j . ':L' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('M' . $j . ':M' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('N' . $j . ':N' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('O' . $j . ':O' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('P' . $j . ':P' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('Q' . $j . ':Q' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('R' . $j . ':R' . $j)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


    if ($j % 2 == 0) {
        cellColor('A' . $j . ':X' . $j, 'f6f8fb');
    }

    $i++;
    $j++;
}



/* * ************************************ */


$exportTime = date("Y-m-d-His", time());
$writer = new Xlsx($spreadsheet);
$file = 'VisitPunchLedger-' . $exportTime . '.xlsx'; //Save file name
$writer->save('media/' . $file);
header('Location:media/' . $file); //File open location

function cellColor($cells, $color) {
    global $spreadsheet;

    $spreadsheet->getActiveSheet()->getStyle($cells)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
}

?>