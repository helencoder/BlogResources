<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Iterators</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 8.9 - iterator.php
//  This page defines and uses the Department and Employee classes. 

# ***** CLASSES ***** #

/* Class Department.
 *  The class contains two attribute: name and employees[].
 *  The class contains seven methods now! 
 */
class Department implements Iterator {
    private $_name;
    private $_employees;

    // For tracking iterations:
    private $_position = 0;
    
    function __construct($name) {
        $this->_name = $name;
        $this->_employees = array();
        $this->_position = 0;
    }
    function addEmployee(Employee $e) {
        $this->_employees[] = $e;
        echo "<p>{$e->getName()} has been added to the {$this->_name} department.</p>";
    }

    // Required by Iterator; returns the current value:
    function current() {
        return $this->_employees[$this->_position];
    }

    // Required by Iterator; returns the current key:
    function key() {
        return $this->_position;
    }
    
    // Required by Iterator; increments the position:
    function next() {
        $this->_position++;
    }

    // Required by Iterator; returns the position to the first spot:
    function rewind() {
        $this->_position = 0;
    }

    // Required by Iterator; returns a Boolean indiating if a value is indexed at this position:
    function valid() {
        return (isset($this->_employees[$this->_position]));
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

// Create a department:
$hr = new Department('Human Resources');

// Create employees:
$e1 = new Employee('Jane Doe');
$e2 = new Employee('John Doe');

// Add the employees to the department:
$hr->addEmployee($e1);
$hr->addEmployee($e2);

// Loop through the department:
echo "<h2>Department Employees</h2>";
foreach ($hr as $e) {
    echo "<p>{$e->getName()}</p>";
}

// Delete the objects:
unset($hr, $e1, $e2);

?>
</body>
</html>