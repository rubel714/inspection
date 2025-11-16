<?php

$TransactionId = isset($_REQUEST['TransactionId']) ? $_REQUEST['TransactionId'] : -1;
if ($TransactionId == -1) {
    echo "Parameter is invalid";
    exit;
}

include_once('../env.php');
require_once("../source/api/pdolibs/Db.class.php");
$db = new Db();

$sqlf = "SELECT a.TransactionId,a.InvoiceNo, a.ManyImgPrefix
			FROM t_transaction a
			where a.TransactionId = $TransactionId;";
$sqlLoop1result = $db->query($sqlf);

$ManyImgPrefix = "";
$InvoiceNo = "";
foreach ($sqlLoop1result as $result) {
    $ManyImgPrefix = $result['ManyImgPrefix'];
    $InvoiceNo = $result['InvoiceNo'];
}

if ($ManyImgPrefix == "") {
    echo "This invoice is not found";
    exit;
}



$zipFile = "../../media/files/$InvoiceNo"."_Images.zip";
// folder containing images
// $zipFile = 'images.zip';     // output zip file name

// Delete old zip if exists
if (file_exists($zipFile)) {
    unlink($zipFile);
}

$zip = new ZipArchive();

if ($zip->open($zipFile, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot open <$zipFile>\n");
}

// Allowed image extensions
$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

////////////////////current folder/////////////////////////////
// $reportimgfolder = "../../image/transaction/1763301073252";
$reportimgfolder = "../../image/transaction/$ManyImgPrefix";
$files = scandir($reportimgfolder);
foreach ($files as $file) {
    $filePath = $reportimgfolder . '/' . $file;
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    //Add only image files
    if (is_file($filePath) && in_array($ext, $allowed)) {
        $zip->addFile($filePath, $file);
    }
}

////////////////////bulkimg folder/////////////////////////////
// $bulkimgfolder = '../../image/transaction/1763301073252/bulkimg';
$bulkimgfolder = "../../image/transaction/$ManyImgPrefix/bulkimg";
if(is_dir($bulkimgfolder)) {
	$files = scandir($bulkimgfolder);
	foreach ($files as $file) {
		$filePath = $bulkimgfolder . '/' . $file;
		$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

		// Add only image files
		if (is_file($filePath) && in_array($ext, $allowed)) {
			$zip->addFile($filePath, $file);
		}
	}
}

$zip->close();

// Download the zip file
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
header('Content-Length: ' . filesize($zipFile));
readfile($zipFile);
exit;

?>
