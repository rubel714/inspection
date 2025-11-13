<?php
require 'vendor/autoload.php';

use iio\libmergepdf\Merger;
use iio\libmergepdf\Driver\TcpdiDriver;

try {
    // Use TCPDI driver (supports compressed PDFs)
    $merger = new Merger(new TcpdiDriver());

    // Add PDF files (must exist and be valid)
    $merger->addFile(__DIR__ . '/1111.pdf');
    $merger->addFile(__DIR__ . '/aaa.pdf');
    $merger->addFile(__DIR__ . '/2222.pdf');
    $merger->addFile(__DIR__ . '/bbb.pdf');

    // Merge them
    $createdPdf = $merger->merge();

    // Save the result
    file_put_contents(__DIR__ . '/merged.pdf', $createdPdf);

    echo "✅ Merge completed successfully!";
} catch (Exception $e) {
    echo "❌ Error merging PDFs: " . $e->getMessage();
}
