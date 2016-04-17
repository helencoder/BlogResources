<?php # RectangleTest.php - Script 14.1
// This page defines the RectangleTest class.

// Need the Rectangle class in order to work:
require('Rectangle.php');

// Define the class:
class RectangleTest extends PHPUnit_Framework_TestCase {
    
    // Test the getArea() method:
    function testGetArea() {
        
        // Need a Rectangle:
        $r = new Rectangle(8,9);
        
        // The assertion tests the math:
        $this->assertEquals(72, $r->getArea());
        
    } // End of testGetArea() method.
    
} // End of RectangleTest class.