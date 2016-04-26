<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add a Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 1.7 - add_task2.php

/*	This page adds tasks to the tasks table.
 *	The page both displays and handles the form.
 *	
 */
 
$dbc = mysqli_connect('localhost', 'username', 'password', 'test');

if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST['task'])) {
    if (isset($_POST['parent_id']) && 
    filter_var($_POST['parent_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
       $parent_id = $_POST['parent_id'];
    } else {
       $parent_id = 0;
    }
   	
	// Add the task to the database.
	$q = sprintf("INSERT INTO tasks (parent_id, task) VALUES (%d, '%s')", $parent_id, mysqli_real_escape_string($dbc, strip_tags($_POST['task']))); 
	$r = mysqli_query($dbc, $q);
	
	if (mysqli_affected_rows($dbc) == 1) {
		echo '<p>The task has been added!</p>';
	} else {
		echo '<p>The task could not be added!</p>';
	}

} // End of submission IF.

// Display the form:
echo '<form action="add_task2.php" method="post">
<fieldset>
	<legend>Add a Task</legend>
	<p>Task: <input name="task" type="text" size="60" maxlength="100"></p>
	<p>Parent Task: <select name="parent_id"><option value="0">None</option>';
$q = 'SELECT task_id, parent_id, task FROM tasks WHERE date_completed="0000-00-00 00:00:00" ORDER BY date_added ASC'; 
$r = mysqli_query($dbc, $q);
$tasks = array();
while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
   echo "<option value=\"$task_id\">$task</option>\n";
   $tasks[] = array('task_id' => $task_id, 'parent_id' => $parent_id, 'task' => $task);
}
echo '</select></p>
<input name="submit" type="submit" value="Add This Task">
</fieldset>
</form>';
?>
</body>
</html>