<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Singleton</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Using a Singleton Config Object</h2>
<?php # Script 7.2 - singleton.php
// This page uses the Config class (Script 7.1).

// Load the class definition:
require('Config.php');

// Create the object:
$CONFIG = Config::getInstance();

// Set some value:
$CONFIG->set('live', 'true');

// Confirm the current value:
echo '<p>$CONFIG["live"]: ' . $CONFIG->get('live') . '</p>';

// Create a second object to confirm:
$TEST = Config::getInstance();
echo '<p>$TEST["live"]: ' . $TEST->get('live') . '</p>';

// Delete the objects:
unset($CONFIG, $TEST);

?>
</body>
</html>