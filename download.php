<?php
// Check if file parameter is provided
if(isset($_GET['file'])) {
    // Sanitize the filename
    $file = basename($_GET['file']);
    
    // Define the path to the uploads folder
    $filePath = 'uploads/' . $file;

    // Check if the file exists
    if(file_exists($filePath)) {
        // Get the MIME type of the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // Set headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $mimeType);
        header('Content-Disposition: attachment; filename=' . $file);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        // Read the file and output it to the browser
        readfile($filePath);
        exit;
    } else {
        // File not found
        echo "File not found.";
    }
} else {
    // File parameter not provided
    echo "Invalid request.";
}
?>