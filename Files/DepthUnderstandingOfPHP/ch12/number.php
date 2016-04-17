#!/usr/bin/php
<?php # Script 12.1 - number.php

/*  This page reads in a file.
 *  It then reprints the file, numbering the lines.
 *  This script is meant to be used with PHP CLI.
 */
 
// The file to number:
$file = 'states.txt';

// Print an intro message:
echo "\nNumbering the file named '$file'...
-------------------\n\n";

// Read in the file: 
$data = file($file);

// Line number counter:
$n = 1;

// Print each line:
foreach ($data as $line) {

    // Print number and line:
    echo "$n $line";
    
    // Increment line number:
    $n++;
    
} // End of FOREACH loop.

echo "\n-------------------
End of file '$file'.\n";
?>