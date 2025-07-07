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
    $reporttitlelist[] = "Conveyance Report";
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
		$spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':J'.$rn);
		$rn++;
	 }



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
        ->SetCellValue('B'.$rn, "Date")
        ->SetCellValue('C'.$rn, "Sales Force")
        ->SetCellValue('D'.$rn, "Person Name")
        ->SetCellValue('E'.$rn, "Designation")
        ->SetCellValue('F'.$rn, "Mobile No")
        ->SetCellValue('G'.$rn, "Transportation Amt")
        ->SetCellValue('H'.$rn, "Refreshment Amt")
        ->SetCellValue('I'.$rn, "Dinner Bill Amt")
        ->SetCellValue('J'.$rn, "Authorised By")
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

/* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
$spreadsheet->getActiveSheet()->getStyle('A'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
$spreadsheet->getActiveSheet()->getStyle('B'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('C'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('D'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('E'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('F'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$spreadsheet->getActiveSheet()->getStyle('G'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('H'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('I'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
$spreadsheet->getActiveSheet()->getStyle('J'.$rn)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

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
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(25);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15);

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


$sql = "SELECT a.TransactionId id,DATE_FORMAT(a.TransactionDate, '%d-%b-%Y') AS TransactionDate,
			 a.UserId,b.UserName,a.ContactPersonName,a.ContactPersonDesignation,
			 a.ContactPersonMobileNumber,a.ApprovedConveyanceAmount,a.ApprovedRefreshmentAmount,a.ApprovedDinnerBillAmount,'' AuthorisedBy
			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
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
$TotalApprovedConveyanceAmount = 0;
$TotalApprovedRefreshmentAmount = 0;
foreach ($result as $row) {

    //Wrap Text
    // $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setWrapText(true);

    /* Value Set for Cells */
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $j, $i)
            ->SetCellValue('B' . $j, $row["TransactionDate"])
            ->SetCellValue('C' . $j, $row["UserName"])
            ->SetCellValue('D' . $j, $row["ContactPersonName"])
            ->SetCellValue('E' . $j, $row["ContactPersonDesignation"])
            ->SetCellValue('F' . $j, $row["ContactPersonMobileNumber"])
            ->SetCellValue('G' . $j, $row["ApprovedConveyanceAmount"])
            ->SetCellValue('H' . $j, $row["ApprovedRefreshmentAmount"])
            ->SetCellValue('I' . $j, $row["ApprovedDinnerBillAmount"])
            ->SetCellValue('J' . $j, $row["AuthorisedBy"])
			;

    $TotalApprovedConveyanceAmount += $row["ApprovedConveyanceAmount"];
    $TotalApprovedRefreshmentAmount += $row["ApprovedRefreshmentAmount"];
    $TotalApprovedDinnerBillAmount += $row["ApprovedDinnerBillAmount"];

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
    
    /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
    $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('I' . $j . ':I' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('J' . $j . ':J' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
   
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
        cellColor('A' . $j . ':J' . $j, 'f6f8fb');
    }

    $i++;
    $j++;
}



/* * ******************Total start****************** */

    /* Value Set for Cells */
    $spreadsheet->getActiveSheet()
            ->SetCellValue('F' . $j, 'Total Amount')
            ->SetCellValue('G' . $j, $TotalApprovedConveyanceAmount)
            ->SetCellValue('H' . $j, $TotalApprovedRefreshmentAmount)
            ->SetCellValue('I' . $j, $TotalApprovedDinnerBillAmount)
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
    
    /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
    $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('H' . $j . ':H' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('I' . $j . ':I' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    $spreadsheet->getActiveSheet()->getStyle('J' . $j . ':J' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
   
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
        cellColor('A' . $j . ':J' . $j, 'f6f8fb');
    }

    $i++;
    $j++;
/******************************Total End****************************** */


$exportTime = date("Y-m-d-His", time());
$writer = new Xlsx($spreadsheet);
$file = 'ConveyanceReport-' . $exportTime . '.xlsx'; //Save file name
$writer->save('media/' . $file);
header('Location:media/' . $file); //File open location

function cellColor($cells, $color) {
    global $spreadsheet;

    $spreadsheet->getActiveSheet()->getStyle($cells)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
}

?>