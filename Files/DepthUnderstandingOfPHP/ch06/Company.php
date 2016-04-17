<?php # Script 6.9 - Company.php
// This script defines the Company namespace, with two classes.

// Declare the namespace:
namespace MyNamespace\Company;

# ***** CLASSES ***** #
class Department {
    private $_name;
    private $_employees;
    function __construct($name) {
        $this->_name = $name;
        $this->_employees = array();
    }
    function addEmployee(Employee $e) {
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to the {$this->_name} department.</p>";
    }
} // End of Department class.

class Employee {
    private $_name;
    function __construct($name) {
        $this->_name = $name;
    }
    function getName() {
        return $this->_name;
    }
} // End of Employee class.

# ***** END OF CLASSES ***** #