<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Using SplFileObject</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 8.8 - write_to_file3.php
// This page uses the SplFileObject class.

// Start the try...catch block:
try {
    
    // Create the object:
    $fp = new SplFileObject('data.txt', 'w');
    
    // Write the data:
    $fp->fwrite("This is a line of data.\n");
    
    // Delete the object:
    unset($fp);

    // If we got this far, everything worked!
    echo '<p>The data has been written.</p>';

} catch (Exception $e) {
    echo '<p>The process could not be completed because the script: ' . $e->getMessage() . '</p>';
}

echo '<p>This is the end of the script.</p>';

?>
</body>
</html>