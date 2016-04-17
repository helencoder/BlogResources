<?php # Script 8.1 - WriteToFile.php
// This page defines a WriteToFile class.

/* The WriteToFile class.
 * The class contains one attribute: $_fp.
 * The class contains three methods: __construct(), write(), close(), and __destruct().
 */
class WriteToFile {
    
    // For storing the file pointer:
    private $_fp = NULL;
    
    // Constructor opens the file for writing:
    function __construct($file) {
    
        // Check that the file exists and is a file:
        if (!file_exists($file) || !is_file($file)) {
            throw new Exception('The file does not exist.');
        }
        
        // Open the file:
        if (!$this->_fp = @fopen($file, 'w')) {
            throw new Exception('Could not open the file.');
        }
    
    } // End of constructor.
    
    // This method writes data to the file:
    function write($data) {
    
        // Confirm the write:
        if (@!fwrite($this->_fp, $data . "\n")) {
            throw new Exception('Could not write to the file.');
        }
    
    } // End of write() method.
    
    // This method closes the file:
    function close() {
    
        // Make sure it's open:
        if ($this->_fp) {
            fclose($this->_fp);
            $this->_fp = NULL;
        }   
    
    } // End of close() method.

    // The destructor calls close(), just in case:
    function __destruct() {
        $this->close();
    } // End of destructor.
    
} // End of WriteToFile class.