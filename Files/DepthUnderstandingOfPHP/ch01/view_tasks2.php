<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Current To-Do List</h2>
<?php # Script 1.6 - view_tasks2.php

/*  This page shows all existing tasks.
 *  A recursive function is used to show the 
 *  tasks as nested lists, as applicable.
 *  Tasks can now be marked as completed.
 */

// Function for displaying a list.
// Receives one argument: an array.
function make_list ($parent) {
    global $tasks;
    echo '<ol>'; // Start an ordered list.
    foreach ($parent as $task_id => $todo) {
        
        // Start with a checkbox!
        echo <<<EOT
<li><input type="checkbox" name="tasks[$task_id]" value="done"> $todo
EOT;
            
        // Check for subtasks:
        if (isset($tasks[$task_id])) { 
            make_list($tasks[$task_id]);
        }
        echo '</li>'; // Complete the list item.    
    } // End of FOREACH loop.
    echo '</ol>'; // Close the ordered list.
} // End of make_list() function.

// Connect to the database:
$dbc = mysqli_connect('localhost', 'username', 'password', 'test');

// Check if the form has been submitted:
if (($_SERVER['REQUEST_METHOD'] == 'POST') 
    && isset($_POST['tasks']) 
    && is_array($_POST['tasks'])
    && !empty($_POST['tasks'])) {

    // Define the query:
	$q = 'UPDATE tasks SET date_completed=NOW() WHERE task_id IN (';

	// Add each task ID:
	foreach ($_POST['tasks'] as $task_id => $v) {
	    $q .= $task_id . ', ';
	}

	// Complete the query and execute:
	$q = substr($q, 0, -2) . ')';
	$r = mysqli_query($dbc, $q);

    // Report on the results:
	if (mysqli_affected_rows($dbc) == count($_POST['tasks'])) {
	    echo '<p>The task(s) have been marked as completed!</p>';
	} else {
	    echo '<p>Not all tasks could be marked as completed!</p>';
	}

} // End of submission IF.

// Retrieve all the uncompleted tasks:
$q = 'SELECT task_id, parent_id, task FROM tasks WHERE date_completed="0000-00-00 00:00:00" ORDER BY parent_id, date_added ASC'; 
$r = mysqli_query($dbc, $q);
$tasks = array();
while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    $tasks[$parent_id][$task_id] =  $task;
}

// Make a form:
echo <<<EOT
<p>Check the box next to a task and click "Update" to mark a task as completed (it, and any subtasks, will no longer appear in this list).</p>
<form action="view_tasks2.php" method="post">
EOT;

make_list($tasks[0]);

// Complete the form:
echo <<<EOT
<input name="submit" type="submit" value="Update" />
</form>
EOT;

?>
</body>
</html>