<?php
require_once('TCPDF-master/examples/tcpdf_include.php');

// ✅ 1. Create a custom class with header & footer
class MyPDF extends TCPDF {

    // --- Page Header ---
   public function Header()
    {
         $TransactionDate="date"; $InvoiceNo=123; $CoverFilePages=2;

        // echo "TransactionDate=".$TransactionDate;
        // exit;

        // Logo
        $image_file = 'Intertek_Logo.png';
        $this->Image($image_file, 5, 5, 30, 10, 'PNG', '', '', false, 150, '', false, false, 1, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 10);

        // // Title
        // $this->Cell(7, 50, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->Write(36, 'INSPECTION REPORT', '', 0, 'L', true, 0, false, false, 0);
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

        $this->Cell(0, 0, 'REPORT NUMBER: ' . $InvoiceNo, 0, 'L', false, 0, '', '', true, 0, false, true, 0, 'T', true);

        $this->SetXY(150, 14); // adjust X and Y as needed
        // $ReportDate = 'REPORT DATE: 08-01-2025';
        $this->Cell(0, 0, 'REPORT DATE: ' . $TransactionDate, 0, 'L', false, 0, '', '', true, 0, false, true, 0, 'T', true);

        $this->SetXY(150, 18); // adjust X and Y as needed
        // $PageNumber = 'PAGE: 1  of  12';
        $currentPage = $this->getPage();
        // $totalPage=$this->getNumPages();
        $PageNumber = 'PAGE: ' . ($currentPage + $CoverFilePages);
        // $PageNumber = 'PAGE: ' . ($currentPage+$CoverFilePages) . '  of ' . ($totalPage);
        // $PageNumber = 'PAGE: ' . ($this->getAliasNumPage()+$CoverFilePages) . '  of ' . ($this->getAliasNbPages()+$CoverFilePages);
        $this->Cell(0, 0, $PageNumber, 0, 'L', false, 0, '', '', true, 0, false, true, 0, 'T', true);
    }

    // --- Page Footer ---
public function Footer()
    {
        $this->SetFont('helvetica', 'R', 8);
        // $this->SetFooterMargin(30); // or any value you need
        $this->SetY(-30);
        $Text = 'The results reflect our findings at time and place of inspection. This report does not relieve sellers/manufacturers from their contractual liabilities or prejudice buyers right for compensation for any apparent and/or hidden defects not detected during our random inspection or occurring thereafter This report does not evidence shipment.';
        $this->MultiCell(0, 0, $Text, 0, 'L', false, 1, '', '', true, 0, false, true, 0, 'T', true);

        $this->SetY(-19);
        $Text = 'ITS Labtest Bangladesh Ltd., Haidar Tower, House # 668, Choydana, Ward # 34, Gazipur City Corporation, Gazipur-1704, Bangladesh';
        $this->MultiCell(0, 0, $Text, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);

        $this->SetY(-15);
        $Text = 'Tel: +88 0966 677 6669, Web: www.intertek.com';
        $this->MultiCell(0, 0, $Text, 0, 'C', false, 1, '', '', true, 0, false, true, 0, 'T', true);
    }
}

// ✅ 2. Create PDF object
$pdf = new MyPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('PDF with Header, Footer and Image');
$pdf->SetMargins(15, 30, 15); // top margin must allow header space
$pdf->SetAutoPageBreak(true, 25); // bottom margin for footer


$page_width = $pdf->getPageWidth() - $pdf->getMargins()['left'] - $pdf->getMargins()['right']; // 200
$page_height = $pdf->getPageHeight() - 5; // space for header/footer // 292



$pdf->AddPage();

// ✅ 3. Draw 3:4 ratio box and insert image
$boxWidth  = 190;// $page_width;  // mm
$boxHeight = 225;//$page_height; // mm
// $boxWidth  = 90;  // mm
// $boxHeight = 120; // mm
$x = 10;
$y = 25;

$pdf->Rect($x, $y, $boxWidth, $boxHeight); // optional: container border

$imageFile = 'example.jpg'; // your image path
list($imgW, $imgH) = getimagesize($imageFile);
$imgRatio = $imgW / $imgH;
$boxRatio = $boxWidth / $boxHeight;

if ($imgRatio > $boxRatio) {
    $fitW = $boxWidth;
    $fitH = $boxWidth / $imgRatio;
} else {
    $fitH = $boxHeight;
    $fitW = $boxHeight * $imgRatio;
}

$imgX = $x + ($boxWidth - $fitW) / 2;
$imgY = $y + ($boxHeight - $fitH) / 2;

$pdf->Image($imageFile, $imgX, $imgY, $fitW, $fitH, '', '', '', false, 300, '', false, false, 0, false, false, false);

// ✅ 4. Add label below the box (auto-wrap if long)
$label = $page_height."This is a long sample label text that should automatically wrap into multiple lines if it exceeds the box width.";
$labelY = $y + $boxHeight + 2; // position below the box
$pdf->SetFont('helvetica', '', 12);

// MultiCell parameters: width, height, text, border, align, fill, ln, x, y
$pdf->MultiCell(
    $boxWidth,   // same width as box
    6,           // line height
    $label,      // label text
    0,           // no border
    'C',         // center align
    false,       // no fill
    1,           // move to next line after
    $x,          // same x as box
    $labelY      // position below box
);

///////////////////////////////////////////////////////////////////////////////////////////////////////////


// if($boxHeight > ){
	// $pdf->AddPage();
// }
$pdf->AddPage();
// ✅ 3. Draw 3:4 ratio box and insert image
$boxWidth  = 90;// $page_width;  // mm
$boxHeight = 60;//$page_height; // mm
// $boxWidth  = 90;  // mm
// $boxHeight = 120; // mm
$x = 10;
$y = 25;

$pdf->Rect($x, $y, $boxWidth, $boxHeight); // optional: container border

$imageFile = 'example.jpg'; // your image path
list($imgW, $imgH) = getimagesize($imageFile);
$imgRatio = $imgW / $imgH;
$boxRatio = $boxWidth / $boxHeight;

if ($imgRatio > $boxRatio) {
    $fitW = $boxWidth;
    $fitH = $boxWidth / $imgRatio;
} else {
    $fitH = $boxHeight;
    $fitW = $boxHeight * $imgRatio;
}

$imgX = $x + ($boxWidth - $fitW) / 2;
$imgY = $y + ($boxHeight - $fitH) / 2;

$pdf->Image($imageFile, $imgX, $imgY, $fitW, $fitH, '', '', '', false, 300, '', false, false, 0, false, false, false);

// ✅ 4. Add label below the box (auto-wrap if long)
$label = "This is a long sample label text that should automatically wrap into multiple lines if it exceeds the box width.";
$labelY = $y + $boxHeight + 2; // position below the box
$pdf->SetFont('helvetica', '', 12);

// MultiCell parameters: width, height, text, border, align, fill, ln, x, y
$pdf->MultiCell(
    $boxWidth,   // same width as box
    6,           // line height
    $label,      // label text
    0,           // no border
    'C',         // center align
    false,       // no fill
    1,           // move to next line after
    $x,          // same x as box
    $labelY      // position below box
);



/////////////////////////////////////////////////////////////////////////////////////


// $pdf->AddPage();

// ✅ 3. Draw 3:4 ratio box and insert image
$boxWidth  = 90;// $page_width;  // mm
$boxHeight = 60;//$page_height; // mm
// $boxWidth  = 90;  // mm
// $boxHeight = 120; // mm
$x = 10 + 10 + 90;
$y = 25;

$pdf->Rect($x, $y, $boxWidth, $boxHeight); // optional: container border

$imageFile = 'example.jpg'; // your image path
list($imgW, $imgH) = getimagesize($imageFile);
$imgRatio = $imgW / $imgH;
$boxRatio = $boxWidth / $boxHeight;

if ($imgRatio > $boxRatio) {
    $fitW = $boxWidth;
    $fitH = $boxWidth / $imgRatio;
} else {
    $fitH = $boxHeight;
    $fitW = $boxHeight * $imgRatio;
}

$imgX = $x + ($boxWidth - $fitW) / 2;
$imgY = $y + ($boxHeight - $fitH) / 2;

$pdf->Image($imageFile, $imgX, $imgY, $fitW, $fitH, '', '', '', false, 300, '', false, false, 0, false, false, false);

// ✅ 4. Add label below the box (auto-wrap if long)
$label = "This is a long sample label text that should automatically wrap into multiple lines if it exceeds the box width.";
$labelY = $y + $boxHeight + 2; // position below the box
$pdf->SetFont('helvetica', '', 12);

// MultiCell parameters: width, height, text, border, align, fill, ln, x, y
$pdf->MultiCell(
    $boxWidth,   // same width as box
    6,           // line height
    $label,      // label text
    0,           // no border
    'C',         // center align
    false,       // no fill
    1,           // move to next line after
    $x,          // same x as box
    $labelY      // position below box
);



/////////////////////////////////////////////////////////////////////////////////////


// $pdf->AddPage();

// ✅ 3. Draw 3:4 ratio box and insert image
$boxWidth  = 90;// $page_width;  // mm
$boxHeight = 60;//$page_height; // mm
// $boxWidth  = 90;  // mm
// $boxHeight = 120; // mm
$x = 10;
$y = 25 + 20 + 60;

$pdf->Rect($x, $y, $boxWidth, $boxHeight); // optional: container border

$imageFile = 'example.jpg'; // your image path
list($imgW, $imgH) = getimagesize($imageFile);
$imgRatio = $imgW / $imgH;
$boxRatio = $boxWidth / $boxHeight;

if ($imgRatio > $boxRatio) {
    $fitW = $boxWidth;
    $fitH = $boxWidth / $imgRatio;
} else {
    $fitH = $boxHeight;
    $fitW = $boxHeight * $imgRatio;
}

$imgX = $x + ($boxWidth - $fitW) / 2;
$imgY = $y + ($boxHeight - $fitH) / 2;

$pdf->Image($imageFile, $imgX, $imgY, $fitW, $fitH, '', '', '', false, 300, '', false, false, 0, false, false, false);

// ✅ 4. Add label below the box (auto-wrap if long)
$label = "This is a long sample label text that should automatically wrap into multiple lines if it exceeds the box width.";
$labelY = $y + $boxHeight + 2; // position below the box
$pdf->SetFont('helvetica', '', 12);

// MultiCell parameters: width, height, text, border, align, fill, ln, x, y
$pdf->MultiCell(
    $boxWidth,   // same width as box
    6,           // line height
    $label,      // label text
    0,           // no border
    'C',         // center align
    false,       // no fill
    1,           // move to next line after
    $x,          // same x as box
    $labelY      // position below box
);
















	
// ✅ 4. Output
$pdf->Output('header_footer_image.pdf', 'I');