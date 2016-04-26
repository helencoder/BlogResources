<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Composite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Using Composite</h2>
<?php # Script 7. 8.6 - composite.php
// This page uses the WorkUnit, Team, and Employee classes (Script 7. 8.5).

// Load the class definition:
require('WorkUnit.php');

// Create the objects:
$alpha = new Team('Alpha');
$john = new Employee('John');
$cynthia = new Employee('Cynthia');
$rashid = new Employee('Rashid');

// Assign employees to the team:
$alpha->add($john);
$alpha->add($rashid);

// Assign tasks:
$alpha->assignTask('Do something great.');
$cynthia->assignTask('Do something grand.');

// Complete a task:
$alpha->completeTask('Do something great.');

// Remove a team member:
$alpha->remove($john);

// Delete the objects:
unset($alpha, $john, $cynthia, $rashid);
?>
</body>
</html>