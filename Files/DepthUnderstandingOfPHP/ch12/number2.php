#!/usr/bin/php
<?php # Script 12.2 - number2.php

/*  This page reads in a file.
 *  It then reprints the file, numbering the lines.
 *  This script is meant to be used with PHP CLI.
 *  This script expects one argument (plus the script's name):
 *  the name of the file to number.
 */
 
// Check that a filename was provided:
if ($_SERVER['argc'] == 2) {
    
    // Get the name of the file:
    $file = $_SERVER['argv'][1];

    // Make sure the file exists and is a file:
    if (file_exists($file) && is_file($file)) {
    
        // Read in the file:
        if ($data = file($file)) {

            // Print an intro message:
            echo "\nNumbering the file named '$file'...\n-------------------\n\n";

            // Line number counter:
            $n = 1;
    
            // Print each line:
            foreach ($data as $line) {
    
                // Print number and line:
                echo "$n  $line";
        
                // Increment line number:
                $n++;
        
            } // End of FOREACH loop.
    
            echo "\n-------------------\nEnd of file '$file'.\n";
            exit(0);
            
        } else {
            echo "The file could not be read.\n";
            exit(1);
        }
    
    } else {
        echo "The file does not exist.\n";
        exit(1);
    }
    
} else {

    // Print the usage:
    echo "\nUsage: number2.php <filename>\n\n";

    // Kill the script, indicate error:
    exit(1);
}

?>