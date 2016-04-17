<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pets</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 5.1 - pets1.php
//  This page defines and uses the Pet, Cat, and Dog classes. 

# ***** CLASSES ***** #

/* Class Pet.
 *  The class contains one attribute: name.
 *  The class contains three methods: 
 *  - __construct()
 *  - eat()
 *  - sleep()
 */
class Pet {

    // Declare the attributes:
    public $name;

    // Constructor assigns the pet's name:
    function __construct($pet_name) {
        $this->name = $pet_name;
    }
    
    // Pets can eat:
    function eat() {
        echo "<p>$this->name is eating.</p>";
    }
    
    // Pets can sleep:
    function sleep() {
        echo "<p>$this->name is sleeping.</p>";
    }

} // End of Pet class.

/* Cat class extends Pet.
 * Cat has additional method: climb().
 */
class Cat extends Pet {
    function climb() {
        echo "<p>$this->name is climbing.</p>";
    }
} // End of Cat class.

/* Dog class extends Pet.
 * Dog has additional method: fetch().
 */
class Dog extends Pet {
    function fetch() {
        echo "<p>$this->name is fetching.</p>";
    }
} // End of Dog class.

# ***** END OF CLASSES ***** #

// Create a dog:
$dog = new Dog('Satchel');

// Create a cat:
$cat = new Cat('Bucky');

// Feed them:
$dog->eat();
$cat->eat();

// Nap time:
$dog->sleep();
$cat->sleep();

// Do animal-specific thing:
$dog->fetch();
$cat->climb();

// Delete the objects:
unset($dog, $cat);

?>
</body>
</html>