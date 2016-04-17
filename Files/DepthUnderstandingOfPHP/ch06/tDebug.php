<?php # Script 6.5 - tDebug.php
// This page defines the tDebug trait.

/*  The tDebug trait.
 *  The trait defines one method: dumpObject(): 
 */
trait tDebug {
    
    // Method dumps out a lot of data about the current object:
    public function dumpObject() {
        
        // Get the class name:
        $class = get_class($this);
        
        // Get the attributes:
        $attributes = get_object_vars($this);

        // Get the methods:
        $methods = get_class_methods($this);
        
        // Print a heading:
        echo "<h2>Information about the $class object</h2>";
        
        // Print the attributes:
        echo '<h3>Attributes</h3><ul>';
        foreach ($attributes as $k => $v) {
            echo "<li>$k: $v</li>";
        }
        echo '</li></ul>';
        
        // Print the methods:
        echo '<h3>Methods</h3><ul>';
        foreach ($methods as $v) {
            echo "<li>$v</li>";
        }
        echo '</li></ul>';

    } // End of dumpObject() method.
    
} // End of tDebug trait.