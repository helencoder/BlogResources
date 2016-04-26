<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Square</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 5.2 - square.php
//  This page declares and uses the Square class which is derived from Rectangle (Script 4.5).

// Include the first class definition:
require('Rectangle.php');

// Create the Square class.
// The class only adds its own constructor.
class Square extends Rectangle {

    // Constructor takes one argument.
    // This value is assigned to the
    // Rectangle width and height attributes.
    function __construct($side = 0) {
        $this->width = $side;
        $this->height = $side;
    }
    
} // End of Square class.

// Rectangle dimensions:
$width = 21;
$height = 98;

// Print a little introduction:
echo "<h2>With a width of $width and a height of $height...</h2>";
    
// Create a new rectangle:
$r = new Rectangle($width, $height);

// Print the area.
echo '<p>The area of the rectangle is ' . $r->getArea() . '</p>';
    
// Print the perimeter.
echo '<p>The perimeter of the rectangle is ' . $r->getPerimeter() . '</p>';

// Square dimensions:
$side = 60;

// Print a little introduction:
echo "<h2>With each side being $side...</h2>";
    
// Create a new object:
$s = new Square($side);

// Print the area.
echo '<p>The area of the square is ' . $s->getArea() . '</p>';
    
// Print the perimeter.
echo '<p>The perimeter of the square is ' . $s->getPerimeter() . '</p>';

// Delete the objects:
unset($r, $s);

?>
</body>
</html>