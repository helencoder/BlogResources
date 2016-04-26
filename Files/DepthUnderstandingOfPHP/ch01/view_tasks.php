<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Current To-Do List</h2>
<?php # Script 1.3 - view_tasks.php

/*  This page shows all existing tasks.
 *  A recursive function is used to show the 
 *  tasks as nested lists, as applicable.
 */

// Function for displaying a list.
// Receives one argument: an array.
function make_list($parent) {
    
    // Need the main $tasks array:
    global $tasks;

    echo '<ol>'; // Start an ordered list.
    
    // Loop through each subarray:
	foreach ($parent as $task_id => $todo) {
    
	    // Display the item:
	    echo "<li>$todo";
            
        // Check for subtasks:
		if (isset($tasks[$task_id])) { 
		    // Call this function again:
		    make_list($tasks[$task_id]);
		}
            
        echo '</li>'; // Complete the list item.
    
    } // End of FOREACH loop.
    
    echo '</ol>'; // Close the ordered list.

} // End of make_list() function.

// Connect to the database:
$dbc = mysqli_connect('localhost', 'username', 'password', 'test');

// Retrieve all the uncompleted tasks:
$q = 'SELECT task_id, parent_id, task FROM tasks WHERE date_completed="0000-00-00 00:00:00" ORDER BY parent_id, date_added ASC'; 
$r = mysqli_query($dbc, $q);

// Initialize the storage array:
$tasks = array();

// Loop through the results:
while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {

    // Add to the array:
    $tasks[$parent_id][$task_id] =  $task;

}

// For debugging:
//echo '<pre>' . print_r($tasks,1) . '</pre>';

// Send the first array element
// to the make_list() function:
make_list($tasks[0]);

?>
</body>
</html>