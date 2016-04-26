<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Composite</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 7. 8.8 - strategy.php
// This page uses the iSort interface, plus the MultiAlphaSort and MultiNumberSort classes (Script 7. 8.7).

// Load the class definition:
require('iSort.php');

/* The StudentsList class.
 * The class contains one attribute: $_students.
 * The class contains three methods:
 * - __construct()
 * - sort()
 * - display()
 */
class StudentsList {
	
	// Stores the list of students:
    private $_students = array();

	// Constructors stores the list internally:
    function __construct($list) {
        $this->_students = $list;
    }

	// Perform a sort using an iSort implementation:
    function sort(iSort $type) {
        $this->_students = $type->sort($this->_students);
    }

	// Display the students as an HTML list:
	function display() {
		echo '<ol>';
		foreach ($this->_students as $student) {
			echo "<li>{$student['name']} {$student['grade']}</li>";
		}
		echo '</ol>';
	}
	
} // End of StudentsList class.

// Create the array...
// Array structure:
// studentID => array('name' => 'Name', 'grade' => XX.X)
$students = array(
	256 => array('name' => 'Jon', 'grade' => 98.5),
	2 => array('name' => 'Vance', 'grade' => 85.1),
	9 => array('name' => 'Stephen', 'grade' => 94.0),
	364 => array('name' => 'Steve', 'grade' => 85.1),
	68 => array('name' => 'Rob', 'grade' => 74.6)
);

// Create the main object:
$list = new StudentsList($students);

// Show the original array:
echo '<h2>Original Array</h2>';
$list->display();

// Sort by name:
$list->sort(new MultiAlphaSort('name'));
echo '<h2>Sorted by Name</h2>';
$list->display();

// Sort by grade:
$list->sort(new MultiNumberSort('grade', 'descending'));
echo '<h2>Sorted by Grade</h2>';
$list->display();

// Delete the object:
unset($list);
?>
</body>
</html>