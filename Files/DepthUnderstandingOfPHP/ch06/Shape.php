<?php # Script 6.1 - Shape.php
/*  This page defines the Shape abstract class.
 *  The class contains no attributes.
 *  The class contains two abstract methods: 
 *  - getArea()
 *  - getPerimeter()
 */
 
abstract class Shape {
    // No attributes to declare.
    // No constructor or destructor defined here.

    // Method to calculate and return the area.
    abstract protected function getArea();
    
    // Method to calculate and return the perimeter.
    abstract protected function getPerimeter();
    
} // End of Shape class.