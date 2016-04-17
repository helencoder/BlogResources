<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Factory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 7.4 - factory.php
// This page uses the ShapeFactory class (Script 7.2).

// Load the class definitions:
require('ShapeFactory.php');
require('Shape.php');
require('Triangle.php');
require('Rectangle.php');

// Minimal validation:
if (isset($_GET['shape'], $_GET['dimensions'])) {
    
    // Create the new object:
    $obj = ShapeFactory::Create($_GET['shape'], $_GET['dimensions']);
    
    // Print a little introduction:
    echo "<h2>Creating a {$_GET['shape']}...</h2>";

    // Print the area:
    echo '<p>The area is ' . $obj->getArea() . '</p>';

    // Print the perimeter:
    echo '<p>The perimeter is ' . $obj->getPerimeter() . '</p>';
    
} else {
    echo '<p class="error">Please provide a shape type and size.</p>';
}

// Delete the object:
unset($obj);

?>
</body>
</html>