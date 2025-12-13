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



// $zipFile = "../../media/files/$InvoiceNo"."_Images.zip";
$zipFile = STORAGE_PATH . "media/files/$InvoiceNo"."_Images.zip";
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
// $reportimgfolder = "../../image/transaction/$ManyImgPrefix";
$reportimgfolder = STORAGE_PATH . "image/transaction/$ManyImgPrefix";
// echo $reportimgfolder;
// exit;
// echo "<pre>";
$files = scandir($reportimgfolder);
foreach ($files as $file) {
    $filePath = $reportimgfolder . '/' . $file;

    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

    //Add only image files
    if (is_file($filePath) && in_array($ext, $allowed)) {
            // echo $filePath;
    // echo "<br/>";
        $zip->addFile($filePath, $file);
    }
}
// exit;
////////////////////bulkimg folder/////////////////////////////
// $bulkimgfolder = '../../image/transaction/1763301073252/bulkimg';
// $bulkimgfolder = "../../image/transaction/$ManyImgPrefix/bulkimg";

$bulkimgfolder = STORAGE_PATH . "image/transaction/$ManyImgPrefix/bulkimg";
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

// Stream the ZIP file as a clean binary response
// Ensure no buffered output or compression interferes
if (function_exists('apache_setenv')) {
    @apache_setenv('no-gzip', '1');
}
if (function_exists('ini_set')) {
    @ini_set('zlib.output_compression', '0');
}

// Clear any output buffers to avoid corrupting the ZIP
while (ob_get_level() > 0) {
    @ob_end_clean();
}

// Send headers for file download
header('Content-Type: application/zip');
header('Content-Transfer-Encoding: binary');
header('Content-Disposition: attachment; filename="' . basename($zipFile) . '"');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: public');
header('Expires: 0');

// Validate file before streaming
if (!file_exists($zipFile) || !is_readable($zipFile)) {
    http_response_code(404);
    echo 'File not found';
    exit;
}

$size = filesize($zipFile);
if ($size !== false) {
    header('Content-Length: ' . $size);
}

$fp = fopen($zipFile, 'rb');
if ($fp) {
    fpassthru($fp);
    fclose($fp);
}
exit;
