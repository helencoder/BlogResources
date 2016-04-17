<?php # WriteToFileTest.php - Script 14.2
// This page defines the WriteToFileTest class.

// Need the WriteToFile class in order to work:
require('WriteToFile.php');

// Define the class:
class WriteToFileTest extends PHPUnit_Framework_TestCase {

    // Need this information:
    private $_fp = NULL;
    private $_file = 'somefile.txt';
    private $_data = 'test data';

    // Open the file for writing:
    function setUp() {
        $this->_fp = fopen($this->_file, 'w');
    }

    // Write and test:
    function testWrite() {
        fwrite($this->_fp, $this->_data);
        $this->assertEquals($this->_data, file_get_contents($this->_file));
    }

    // Close the file:
    function tearDown() {
        fclose($this->_fp);
    }

} // End of class.
