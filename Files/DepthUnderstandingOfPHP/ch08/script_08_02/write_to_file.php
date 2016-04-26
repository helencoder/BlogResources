	<!doctype html>
	<html lang="en">
	<head>
	    <meta charset="utf-8">
	    <title>Handling Exceptions</title>
	    <link rel="stylesheet" href="style.css">
	</head>
	<body>
	<?php # Script 8.2 - write_to_file.php
	// This page uses the WriteToFile class (Script 8.1).

	// Load the class definition:
	require('WriteToFile.php');

	// Start the try...catch block:
	try {
    
	    // Create the object:
	    $fp = new WriteToFile('data.txt');
    
	    // Write the data:
	    $fp->write('This is a line of data.');
    
	    // Close the file:
	    $fp->close();
    
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