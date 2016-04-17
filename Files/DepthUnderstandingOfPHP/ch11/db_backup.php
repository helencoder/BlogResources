<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Database Backup</title>
</head>
<body>
<?php # Script 11.1 - db_backup.php

/*  This page retrieves all the data from a database
 *  and writes that data to a text file.
 *  The text file is then compressed using zlib.
 */
 
// Establish variables and setup:
$db_name = 'test';

// Backup directory:
$dir = "backups/$db_name";

// Make the database-specific directory, if it doesn't exist: 
if (!is_dir($dir)) {
    if (!@mkdir($dir)) {
        die("<p>The backup directory--$dir--could not be created.</p></body></html>");
    }
}

// Get the current time for use in all filenames:
$time = time();

// Connect to the database:
$dbc = @mysqli_connect('localhost', 'username', 'password', $db_name) OR die("<p>The database--$db_name--could not be backed up.</p></body></html>");

// Retrieve the tables:
$r = mysqli_query($dbc, 'SHOW TABLES');

// Back up if at least one table exists:
if (mysqli_num_rows($r) > 0) {

    // Indicate what is happening:
    echo "<p>Backing up database '$db_name'.</p>";
    
    // Fetch each table name:
    while (list($table) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    
        // Get the records for this table:
        $q = "SELECT * FROM $table";
        $r2 = mysqli_query($dbc, $q);
        
        // Back up if records exist:
        if (mysqli_num_rows($r2) > 0) {

            // Attempt to open the file:
            if ($fp = gzopen ("$dir/{$table}_{$time}.sql.gz", 'w9')) {
            
                // Fetch all the records for this table:
                while ($row = mysqli_fetch_array($r2, MYSQLI_NUM)) {

                    // Write the data as a comma-delineated row:
                    foreach ($row as $value) {
                        $value = addslashes($value);
                        gzwrite ($fp, "'$value', ");
                    }
    
                    // Add a new line to each row:
                    gzwrite ($fp, "\n"); 

                } // End of WHILE loop.

                // Close the file:
                gzclose ($fp); 
            
                // Print the success:
                echo "<p>Table '$table' backed up.</p>";

            } else { // Could not create the file!
                echo "<p>The file--$dir/{$table}_{$time}.sql.gz--could not be opened for writing.</p>";
                break; // Leave the WHILE loop.
            } // End of gzopen() IF.

        } // End of mysqli_num_rows() IF.
        
    } // End of WHILE loop.

} else {
    echo "<p>The submitted database--$db_name--contains no tables.</p>";
}

?>
</body>
</html>