<?php # Script 3.2 - sessions.php

/*  This page does some silly things with sessions.
 *  It includes the db_sessions.inc.php script
 *  so that the session data will be stored in a database.
 */
 
// Include the sessions file:
// The file already starts the session.
require('db_sessions.inc.php');
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>DB Session Test</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
// Store some dummy data in the session, if no data is present:
if (empty($_SESSION)) {

    $_SESSION['blah'] = 'umlaut';
    $_SESSION['this'] = 3615684.45;
    $_SESSION['that'] = 'blue';
    
    // Print a message indicating what's going on:
    echo '<p>Session data stored.</p>';
    
} else { // Print the already-stored data:
    echo '<p>Session Data Exists:<pre>' . print_r($_SESSION, 1) . '</pre></p>';
}

// Log the user out, if applicable:
if (isset($_GET['logout'])) {

    session_destroy();
    echo '<p>Session destroyed.</p>';
    
} else { // Otherwise, print the "Log Out" link:
    echo '<a href="sessions.php?logout=true">Log Out</a>';
}

// Reprint the session data:
echo '<p>Session Data:<pre>' . print_r($_SESSION, 1) . '</pre></p>';

// Complete the page:
echo '</body>
</html>';

// Write and close the session:
session_write_close(); 
?>