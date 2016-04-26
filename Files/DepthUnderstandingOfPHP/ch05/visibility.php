<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Visibility</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 5.4 - visibility.php
//  This page defines and uses the Test and LittleTest classes. 

# ***** CLASSES ***** #

/* Class Test.
 *  The class contains three attributes:
 *  - public $public
 *  - protected $protected
 *  - private $_private
 *  The class defines one method: printVar().
 */
class Test {

    // Declare the attributes:
    public $public = 'public';
    protected $protected = 'protected';
    private $_private = 'private';  

    // Function for printing a variable's value:
    function printVar($var) {
        echo "<p>In Test, \$$var: '{$this->$var}'.</p>";
    }

} // End of Test class.

/* LittleTest class extends Test.
 * LittleTest overrides printVar().
 */
class LittleTest extends Test {
    function printVar($var) {
        echo "<p>In LittleTest, \$$var: '{$this->$var}'.</p>";
    }
} // End of LittleTest class.

# ***** END OF CLASSES ***** #

// Create the objects:
$parent = new Test();
$child = new LittleTest();

// Print the current value of $public:
echo '<h1>Public</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('public');
$child->printVar('public');
// Also echo $parent->public or echo $child->public.

// Modify $public and reprint:
echo '<h2>Modifying $parent->public...</h2>';
$parent->public = 'modified';
$parent->printVar('public');
$child->printVar('public');

// Print the current value of $protected:
echo '<hr><h1>Protected</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('protected');
$child->printVar('protected');

// Attempt to modify $protected and reprint:
echo '<h2>Attempting to modify $parent->protected...</h2>';
$parent->protected = 'modified';
$parent->printVar('protected');
$child->printVar('protected');

// Print the current value of $_private:
echo '<hr><h1>Private</h1>';
echo '<h2>Initially...</h2>';
$parent->printVar('_private');
$child->printVar('_private');

// Attempt to modify $_private and reprint:
echo '<h2>Attempting to modify $parent->_private...</h2>';
$parent->_private = 'modified';
$parent->printVar('_private');
$child->printVar('_private');

// Delete the objects:
unset($parent, $child);

?>
</body>
</html>