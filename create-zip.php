
<?php
function createZip() {
    $zip = new ZipArchive();
    $zipFileName = 'jsmf-website-' . date('Y-m-d-H-i-s') . '.zip';
    
    if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
        die("Cannot create zip file: $zipFileName");
    }
    
    // Add files to zip
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator('.'),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($files as $name => $file) {
        // Skip directories and unwanted files
        if (!$file->isDir() && 
            !preg_match('/\.(git|zip|log|tmp)$/', $file) &&
            !strpos($file, '/.git/') &&
            !strpos($file, '/vendor/') &&
            !strpos($file, '/node_modules/')) {
            
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen(realpath('.')) + 1);
            $zip->addFile($filePath, $relativePath);
        }
    }
    
    $zip->close();
    
    // Download the zip file
    if (file_exists($zipFileName)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
        header('Content-Length: ' . filesize($zipFileName));
        readfile($zipFileName);
        unlink($zipFileName); // Delete after download
        exit;
    } else {
        echo "Error creating zip file.";
    }
}

createZip();
?>
