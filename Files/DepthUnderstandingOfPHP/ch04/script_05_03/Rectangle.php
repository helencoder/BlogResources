<?php # Script 4.3 - Rectangle.php
/*  This page defines the Rectangle class.
 *  The class contains two attributes: width and height.
 *  The class contains four methods: 
 *  - setSize()
 *  - getArea()
 *  - getPerimeter()
 *  - isSquare()
 */
 
class Rectangle {

    // Declare the attributes:
    public $width = 0;
    public $height = 0;
    
    // Method to set the dimensions:
    function setSize($w = 0, $h = 0) {
        $this->width = $w;
        $this->height = $h;
    }
    
    // Method to calculate and return the area.
    function getArea() {
        return ($this->width * $this->height);
    }
    
    // Method to calculate and return the perimeter.
    function getPerimeter() {
        return ( ($this->width + $this->height) * 2 );
    }
    
    // Method to determine if the rectange 
    // is also a square.
    function isSquare() {
        if ($this->width == $this->height) {
            return true; // Square
        } else {
            return false; // Not a square
        }
    }

} // End of Rectangle class.