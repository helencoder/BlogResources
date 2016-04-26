<?php # Script 7.7 - iSort.php
// This page defines an iSort interface and two classes. 
// This page implements the Strategy pattern.

// The Sort interface defines the sort() method:
interface iSort {
    function sort(array $list);
}

// The MultiAlphaSort sorts a multidimensional array alphabetically.
class MultiAlphaSort implements iSort {
    
    // How to sort:
    private $_order;
    
    // Sort index:
    private $_index;
    
    // Constructor sets the sort index and order:
    function __construct($index, $order = 'ascending') {
        $this->_index = $index;
        $this->_order = $order;
    }
    
    // Function does the actual sorting:
    function sort(array $list) {

        // Change the algorithm to match the sort preference:
        if ($this->_order == 'ascending') {
            uasort($list, array($this, 'ascSort'));
        } else {
            uasort($list, array($this, 'descSort'));
        }

        // Return the sorted list:
        return $list;
    
    }// End of sort() method.

    // Functions that compares two values:
    function ascSort($x, $y) {
        return strcasecmp($x[$this->_index], $y[$this->_index]);                                        
    }
    function descSort($x, $y) {
        return strcasecmp($y[$this->_index], $x[$this->_index]);                
    }

} // End of MultiAlphaSort class.

// The MultiNumberSort sorts a multidimensional array numerically.
class MultiNumberSort implements iSort {
    
    // How to sort:
    private $_order;
    
    // Sort index:
    private $_index;
    
    // Constructor sets the sort index and order:
    function __construct($index, $order = 'ascending') {
        $this->_index = $index;
        $this->_order = $order;
    }
    
    // Function does the actual sorting:
    function sort(array $list) {

        // Change the algorithm to match the sort preference:
        if ($this->_order == 'ascending') {
            uasort($list, array($this, 'ascSort'));
        } else {
            uasort($list, array($this, 'descSort'));
        }

        // Return the sorted list:
        return $list;

    }// End of sort() method.

    // Functions that compares two values:
    function ascSort($x, $y) {
        return ($x[$this->_index] > $y[$this->_index]);
    }
    function descSort($x, $y) {
        return ($x[$this->_index] < $y[$this->_index]);
    }

} // End of MultiNumberSort class.