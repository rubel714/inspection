<?php
 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$BulkFolderName = isset($_REQUEST['BulkFolderName']) ? $_REQUEST['BulkFolderName'] : '';
if (empty($BulkFolderName)) {
    http_response_code(400);
    echo 'BulkFolderName parameter is required.';
    exit;
}
// $StartDate = isset($_REQUEST['StartDate']) ? $_REQUEST['StartDate'] : -1;
// $EndDateWithoutTime = isset($_REQUEST['EndDate']) ? $_REQUEST['EndDate'] : "";
// $EndDate = $EndDateWithoutTime . " 23-59-59";
// $BuyerName = isset($_REQUEST['BuyerId']) ? $_REQUEST['BuyerId'] : -1;
// $FactoryName = isset($_REQUEST['FactoryId']) ? $_REQUEST['FactoryId'] : -1;
include_once('../env.php');
// require_once("../source/api/pdolibs/Db.class.php");
// $db = new Db();

// $query = "SELECT a.TransactionId, DATE(a.`TransactionDate`) TransactionDate, 
// 		a.InvoiceNo,a.BuyerName,a.SupplierName,a.FactoryName,d.TemplateName, e.`UserName` as InspectorUserName
// 		FROM `t_transaction` a
// 	   LEFT JOIN `t_template` d ON a.`TemplateId` = d.`TemplateId`
// 	   LEFT JOIN `t_users` e ON a.`InspectorUserId` = e.`UserId`
// 		where (a.TransactionDate between '$StartDate' and '$EndDate')
// 		and (a.BuyerName = '$BuyerName' or '$BuyerName' = '0')
// 		and (a.FactoryName = '$FactoryName' or '$FactoryName' = '0')
// 		and a.CoverFileUrl is not null and a.CoverFileUrl != ''
// 		and a.FooterFileUrl is not null and a.FooterFileUrl != ''
// 		and a.`TemplateId` is not null
// 		ORDER BY a.`TransactionDate` DESC, a.InvoiceNo ASC;";

// $resultdatalist = $db->query($query);
// $BulkFolderName = "Inspection_reports_{$StartDate}_to_{$EndDateWithoutTime}_generated_" . date("Y_m_d_H_i_s");

// foreach ($resultdatalist as $key => $value) {
//     $TransactionId = $value['TransactionId'];
 
//     // echo DOMAIN_URL . 'backend/report/ReportGenerate_pdf.php?TransactionId=' . $TransactionId . '&BulkFolderName=' . $BulkFolderName;
//     $curl = curl_init();

//     curl_setopt_array($curl, array(
//         // CURLOPT_URL => 'http://localhost/inspection/backend/report/ReportGenerate_pdf.php?TransactionId=' . $TransactionId . '&BulkFolderName=' . $BulkFolderName,
//         CURLOPT_URL => DOMAIN_URL . 'backend/report/ReportGenerate_pdf.php?TransactionId=' . $TransactionId . '&BulkFolderName=' . $BulkFolderName,
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => '',
//         CURLOPT_MAXREDIRS => 30,
//         CURLOPT_TIMEOUT => 60, // 1 minutes timeout per PDF
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_SSL_VERIFYPEER => false,
//         CURLOPT_SSL_VERIFYHOST => false,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         // CURLOPT_CUSTOMREQUEST => 'GET',
//     ));

//     if (curl_exec($curl)) {
//         echo "Success for TransactionId " . $TransactionId . "\n";
//     } else {
//         error_log('cURL failed for TransactionId ' . $TransactionId . ': ' . curl_error($curl));
//     }
//     curl_close($curl);
// }


// Build filesystem paths for the bulk folder and target zip
$sourceDir = STORAGE_PATH . 'media/files/' . $BulkFolderName;
$zipPath = STORAGE_PATH . 'media/files/' . $BulkFolderName . '.zip';

// Create a zip archive of the bulk folder
if (is_dir($sourceDir)) {
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($sourceDir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sourceDir) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        // Redirect to the zip file URL for download
        $zipUrl = STORAGE_PATH_URL . 'media/files/' . $BulkFolderName . '.zip';
        header('Location: ' . $zipUrl);
        exit;
    } else {
        http_response_code(500);
        echo 'Failed to create zip archive.';
        exit;
    }
} else {
    http_response_code(404);
    echo 'Bulk folder not found: ' . htmlspecialchars($sourceDir);
    exit;
}
