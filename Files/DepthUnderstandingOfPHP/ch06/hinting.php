<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Type Hinting</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 6.8 - hinting.php
//  This page defines and uses the Department and Employee classes. 

# ***** CLASSES ***** #

/* Class Department.
 *  The class contains two attribute: name and employees[].
 *  The class contains two methods: 
 *  - __construct()
 *  - addEmployee()
 */
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

/* Class Employee.
 *  The class contains one attribute: name.
 *  The class contains two methods: 
 *  - __construct()
 *  - getName()
 */
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

// Delete the objects:
unset($hr, $e1, $e2);

?>
</body>
</html>