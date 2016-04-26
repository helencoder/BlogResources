<?php # RectangleTest.php - Script 14.3 #2
// This page defines the RectangleTest class.

// Need the Rectangle class in order to work:
require('Rectangle.php');

// Define the class:
class RectangleTest extends PHPUnit_Framework_TestCase {
    
    // For storing the Rectangle object:
    protected $r;
    
    // Create an object to use:
	function setUp() {
	    $this->r = new Rectangle(8,9);
	}

    // Test the getArea() method:
	function testGetArea() {
	    $this->assertEquals(72, $this->r->getArea());
	}
    
    // Test the getPerimeter() method:
    function testGetPerimeter() {
        $this->assertEquals(34, $this->r->getPerimeter());
    }

    // Test the isSquare() method:
    function testIsSquare() {
        
        // Should not be a square in this case!
        $this->assertFalse($this->r->isSquare());
        
        // Make it a square and test again:
        $this->r->setSize(5,5);
        $this->assertTrue($this->r->isSquare());

    }

    // Test the setSize() method:
    function testSetSize() {
        $w = 5;
        $h = 8;
        $this->r->setSize($w, $h);
        $this->assertEquals($w, $this->r->width);
        $this->assertEquals($h, $this->r->height);
    }
    
} // End of RectangleTest class.