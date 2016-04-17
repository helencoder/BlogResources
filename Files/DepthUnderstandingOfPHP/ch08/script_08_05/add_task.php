<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add a Task</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 8.5 - add_task.php
//  This page adds tasks to the tasks table using PDO.

// Try to connect to the database:
try { 

    // Create the object:
    $pdo = new PDO('mysql:dbname=test;host=localhost', 'username', 'password');

    // Unset the object:
    unset($pdo);

} catch (PDOException $e) { // Report the error!
    echo '<p class="error">An error occurred: ' . $e->getMessage() . '</p>';
}

?>
</body>
</html>