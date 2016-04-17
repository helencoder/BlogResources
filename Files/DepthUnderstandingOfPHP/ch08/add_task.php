<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add a Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 8.7 - add_task.php #3 (in this chapter)
//  This page adds tasks to the tasks table using PDO.

// Try to connect to the database:
try { 

    // Create the object:
    $pdo = new PDO('mysql:dbname=test;host=localhost', 'username', 'password');

    // Check for a form submission:
    if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST['task'])) {
    
        // Minimal validation:
        if (isset($_POST['parent_id']) && 
        filter_var($_POST['parent_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
           $parent_id = $_POST['parent_id'];
        } else {
           $parent_id = 0;
        }

        // Add the task to the database:
        $q = 'INSERT INTO tasks (parent_id, task) VALUES (:parent_id, :task)';
        $stmt = $pdo->prepare($q);

        // Confirm the results:
        if ($stmt->execute(array(':parent_id' => $parent_id, ':task' => $_POST['task']))) {
            echo '<p>The task has been added!</p>';
        } else {
            echo '<p>The task could not be added!</p>';
        }

    } // End of submission IF.

    // Start the form:
    echo '<form action="add_task.php" method="post">
    <fieldset>
        <legend>Add a Task</legend>
        <p>Task: <input name="task" type="text" size="60" maxlength="100"></p>
        <p>Parent Task: <select name="parent_id"><option value="0">None</option>';
        
    // Run the query:
    $q = 'SELECT task_id, task FROM tasks WHERE date_completed="0000-00-00 00:00:00" ORDER BY date_added ASC'; 
    $r = $pdo->query($q);
    
    // Set the fetch mode:
    $r->setFetchMode(PDO::FETCH_NUM);
    
    // Show the results:
    while ($row = $r->fetch()) {
       echo "<option value=\"$row[0]\">$row[1]</option>\n";
    }
    
    // Complete the form:
    echo '</select></p>
    <input name="submit" type="submit" value="Add This Task">
    </fieldset>
    </form>';

    // Unset the object:
    unset($pdo);

} catch (PDOException $e) { // Report the error!
    echo '<p class="error">An error occurred: ' . $e->getMessage() . '</p>';
}

?>
</body>
</html>