<?php # Script 3.1 - db_sessions.inc.php

/* 
 *  This page creates the functional interface for 
 *  storing session data in a database.
 *  This page also starts the session.
 */

// Global variable used for the database 
// connections in all session functions:
$sdbc = NULL;

// Define the open_session() function:
// This function takes no arguments.
// This function should open the database connection.
// This function should return true.
function open_session() {
    global $sdbc;
    
    // Connect to the database:
    $sdbc = mysqli_connect ('localhost', 'username', 'password', 'test');
    
    return true;
} // End of open_session() function.
 
// Define the close_session() function:
// This function takes no arguments.
// This function closes the database connection.
// This function returns the closed status.
function close_session() {
    global $sdbc;
    
    return mysqli_close($sdbc);
} // End of close_session() function.

// Define the read_session() function:
// This function takes one argument: the session ID.
// This function retrieves the session data.
// This function returns the session data as a string.
function read_session($sid) {
    global $sdbc;

    // Query the database:
    $q = sprintf('SELECT data FROM sessions WHERE id="%s"', mysqli_real_escape_string($sdbc, $sid)); 
    $r = mysqli_query($sdbc, $q);
    
    // Retrieve the results:
    if (mysqli_num_rows($r) == 1) {
        list($data) = mysqli_fetch_array($r, MYSQLI_NUM);
        
        // Return the data:
        return $data;

    } else { // Return an empty string.
        return '';
    }
} // End of read_session() function.

// Define the write_session() function:
// This function takes two arguments: 
// the session ID and the session data.
function write_session($sid, $data) {
    global $sdbc;

    // Store in the database:
    $q = sprintf('REPLACE INTO sessions (id, data) VALUES ("%s", "%s")', mysqli_real_escape_string($sdbc, $sid), mysqli_real_escape_string($sdbc, $data)); 
    $r = mysqli_query($sdbc, $q);

	return true;
} // End of write_session() function.

// Define the destroy_session() function:
// This function takes one argument: the session ID.
function destroy_session($sid) {
    global $sdbc;

    // Delete from the database:
    $q = sprintf('DELETE FROM sessions WHERE id="%s"', mysqli_real_escape_string($sdbc, $sid)); 
    $r = mysqli_query($sdbc, $q);
    
    // Clear the $_SESSION array:
    $_SESSION = array();

    return true;
} // End of destroy_session() function.

// Define the clean_session() function:
// This function takes one argument: a value in seconds.
function clean_session($expire) {
    global $sdbc;

    // Delete old sessions:
    $q = sprintf('DELETE FROM sessions WHERE DATE_ADD(last_accessed, INTERVAL %d SECOND) < NOW()', (int) $expire); 
    $r = mysqli_query($sdbc, $q);

    return true;
} // End of clean_session() function.

# **************************** #
# ***** END OF FUNCTIONS ***** #
# **************************** #

// Declare the functions to use:
session_set_save_handler('open_session', 'close_session', 'read_session', 'write_session', 'destroy_session', 'clean_session');

// Make whatever other changes to the session settings, if you want.

// Start the session:
session_start();