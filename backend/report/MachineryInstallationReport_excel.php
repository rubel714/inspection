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
$TransactionId = $_REQUEST['TransactionId'];
 
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
    $reporttitlelist[] = "Machinery Installation Report";
	// $reporttitlelist[] = "Start Date: ".$StartDate.", End Date: " . $_REQUEST['EndDate'];
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
		$spreadsheet->getActiveSheet()->mergeCells('A'.$rn.':F'.$rn);
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


$sql = "SELECT a.TransactionId id,
			DATE_FORMAT(a.TransactionDate, '%d-%b-%Y') AS TransactionDate,
			DATE_FORMAT(a.TransactionDate, '%h:%i:%s %p') AS TimeIn,
			'' AS TimeOut,a.UserId,b.UserName,d.CustomerCode,d.CustomerName,d.CompanyAddress as Address,g.MachineName,h.MachineModelName
			,a.MachineSerial,a.MachineComplain
			,(SELECT GROUP_CONCAT(concat(n.MachinePartsName,' (',round(m.Qty),')')) FROM `t_transaction_machineparts` m 
				inner join t_machineparts n on m.MachinePartsId=n.MachinePartsId 
				where m.TransactionId=a.TransactionId) as MachineParts
			,a.SelfDiscussion,a.customerToSuggestion as SuggestionToCustomer,a.customerBySuggestion as SuggestionFromCustomer
			FROM t_transaction a
			inner join t_users b on a.UserId=b.UserId
			inner join t_customer d on a.CustomerId =d.CustomerId
			inner join t_machine g on a.MachineId =g.MachineId
			inner join t_machinemodel h on a.MachineModelId =h.MachineModelId
			where a.TransactionTypeId=1
			AND a.TransactionId = $TransactionId
			ORDER BY a.TransactionDate DESC;";

$result = $db->query($sql);
// $i = 1;
// $j = $rn+1;

// $i=1;
// $j=4;

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

foreach ($result as $row) {

    $TransactionDate = $row['TransactionDate'];
    $TimeIn = $row['TimeIn'];
    $TimeOut = $row['TimeOut'];
    $UserName = $row['UserName'];
    $CustomerName = $row['CustomerName'];
    $Address = $row['Address'];
    $MachineName = $row['MachineName'];
    $MachineModelName = $row['MachineModelName'];
    $MachineSerial = $row['MachineSerial'];
    $MachineComplain = $row['MachineComplain'];
    $MachineParts = $row['MachineParts'];
    $SelfDiscussion = $row['SelfDiscussion'];
    $SuggestionToCustomer = $row['SuggestionToCustomer'];
    $SuggestionFromCustomer = $row['SuggestionFromCustomer'];
}



/* Width for Cells */

$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15);

/* * ******************Sub header start****************** */

$k = 4;
    /* Value Set for Cells */
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Date')
            ->SetCellValue('B' . $k, $TransactionDate)
            ->SetCellValue('C' . $k, "Time In")
            ->SetCellValue('D' . $k, $TimeIn)
            ->SetCellValue('E' . $k, 'Time Out')
            ->SetCellValue('F' . $k, 'Service Engineer')
			;
    
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Customer Name:')
            ->SetCellValue('B' . $k, $CustomerName)
			;
    
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Address:')
            ->SetCellValue('B' . $k, $Address)
			;
    
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Machine Name:')
            ->SetCellValue('B' . $k, $MachineName)
            ->SetCellValue('C' . $k, 'Model No:')
            ->SetCellValue('D' . $k, $MachineModelName)
            ->SetCellValue('E' . $k, 'Serial No:')
            ->SetCellValue('F' . $k, $MachineSerial)
            ;
    
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Customer Complaint/Problem/Symptom Description')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, $MachineComplain)
            ;

    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Machine Parts')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, $MachineParts)
            ;


    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Service Contents')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, $SelfDiscussion)
            ;



    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Suggestion to Customer to Rectify the Problem')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, $SuggestionToCustomer)
            ;


    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Suggestion by Customer')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, $SuggestionFromCustomer)
            ;

            


    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Customers Representative')
            ;

    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('B' . $k, 'Name')
            ->SetCellValue('D' . $k, 'Designation')
            ->SetCellValue('E' . $k, 'Signature')
            ;

    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, '1.......................................')
            ->SetCellValue('D' . $k, '.......................................')
            ->SetCellValue('E' . $k, '.......................................')
            ;

    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, '2.......................................')
            ->SetCellValue('D' . $k, '.......................................')
            ->SetCellValue('E' . $k, '.......................................')
            ;

    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, '3.......................................')
            ->SetCellValue('D' . $k, '.......................................')
            ->SetCellValue('E' . $k, '.......................................')
            ;

    $k++;
    $k++;
    $k++;
    $k++;
    $spreadsheet->getActiveSheet()
            ->SetCellValue('A' . $k, 'Service Engineer')
            ->SetCellValue('E' . $k, 'Head Of Service')
            ;
    /* border color set for cells */
    // $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->applyFromArray($styleThinBlackBorderOutline);
    // $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->applyFromArray($styleThinBlackBorderOutline);

    /* Text Alignment Horizontal(HORIZONTAL_LEFT,HORIZONTAL_CENTER,HORIZONTAL_RIGHT) */
    // $spreadsheet->getActiveSheet()->getStyle('A' . $j . ':A' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    // $spreadsheet->getActiveSheet()->getStyle('B' . $j . ':B' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('C' . $j . ':C' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('D' . $j . ':D' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('E' . $j . ':E' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
    // $spreadsheet->getActiveSheet()->getStyle('F' . $j . ':F' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
    // $spreadsheet->getActiveSheet()->getStyle('G' . $j . ':G' . $j)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

/******************************Sub header End****************************** */
 
$exportTime = date("Y-m-d-His", time());
$writer = new Xlsx($spreadsheet);
$file = 'MachineryInstallationReport-' . $exportTime . '.xlsx'; //Save file name
$writer->save('media/' . $file);
header('Location:media/' . $file); //File open location

function cellColor($cells, $color) {
    global $spreadsheet;

    $spreadsheet->getActiveSheet()->getStyle($cells)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($color);
}

?>