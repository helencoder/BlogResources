<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Extending Exceptions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 8.4 - write_to_file.php #2
// This page uses the WriteToFile class (Script 8.3).

// Load the class definition:
require('WriteToFile.php');

// Start the try...catch block:
try {
   
    // Create the object:
    $fp = new WriteToFile('data.txt', 'w');
   
    // Write the data:
    $fp->write('This is a line of data.');
   
    // Close the file:
    $fp->close();
   
    // Delete the object:
    unset($fp);

    // If we got this far, everything worked!
    echo '<p>The data has been written.</p>';

} catch (FileException $e) {
    echo '<p>The process could not be completed. Debugging information:<br>' . $e->getMessage() . '<br>' . $e->getDetails() . '</p>';
}

echo '<p>This is the end of the script.</p>';

?>
</body>
</html>