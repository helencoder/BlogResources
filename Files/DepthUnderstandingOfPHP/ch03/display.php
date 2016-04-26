<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Cities and Zip Codes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 3.4 - display.php

/*  This page retrieves and displays all of the
 *  cities and zip codes for a particular state.
 *  The results will be shown in a table.
 */
 
// Abbreviation of state to show:
$state = 'AK';

// Items to display per row:
$items = 5;

// Print a caption:
echo "<h1>Cities and Zip Codes found in $state</h1>";

// Connect to the database:
$dbc = mysqli_connect ('localhost', 'username', 'password', 'zips');

// Get the cities and zip codes, ordered by city:
$q = "SELECT city, zip_code FROM zip_codes WHERE state='$state' ORDER BY city";
$r = mysqli_query($dbc, $q);

// Retrieve the results:
if (mysqli_num_rows($r) > 0) {

    // Start a table:
    echo '<table border="2" width="90%" cellspacing="3" cellpadding="3" align="center">';

    // Need a counter:
    $i = 0;

    // Retrieve each record:
    while (list($city, $zip_code) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    
        // Do we need to start a new row?
        if ($i == 0) {
            echo '<tr>';
        }
    
        // Print the record:
        echo "<td align=\"center\">$city, $zip_code</td>";
        
        // Increment the counter:
        $i++;
        
        // Do we need to end the row?
        if ($i == $items) {
            echo '</tr>';
            $i = 0; // Reset counter.
        }

    } // End of while loop.
    
    if ($i > 0) { // Last row was incomplete.

        // Print the necessary number of cells:
        for (;$i < $items; $i++) {
            echo "<td>&nbsp;</td>\n";
        }
    
        // Complete the row.
        echo '</tr>';
    
    } // End of ($i > 0) IF.
    
    // Close the table:
    echo '</table>';
        
} else { // Bad state abbreviation.

    echo '<p class="error">An invalid state abbreviation was used.</p>';

} // End of main IF.

// Close the database connection:
mysqli_close($dbc);

?>
</body>
</html>