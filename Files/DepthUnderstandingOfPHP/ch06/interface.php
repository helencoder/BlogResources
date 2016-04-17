<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Interface</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 6.4 - interface.php
// This page defines and uses the iCrud interface.

/*  The iCrud interface.
 *  The interface identifies four methods: 
 *  - create()
 *  - read()
 *  - update()
 *  - delete()
 */
interface iCrud {
    public function create($data);
    public function read();
    public function update($data);
    public function delete();
}

/*  The User class implements the iCrud interface.
 *  The class contains two attributes: 
 *  - private $_userId
 *  - private $_username
 *  The class contains the four interface methods, plus a constructor.
 */
class User implements iCrud {
    
    private $_userId = NULL;
    private $_username = NULL;

    // Constructor takes an array of data:
    function __construct($data) {
        $this->_userId = uniqid();
        $this->_username = $data['username'];
    } // End of constructor.

    // This method also takes an array of data:
    function create($data) {
        self::__construct($data);
    }
    
    // Function for returning information about the current object:
    function read() {
        return array('userId' => $this->_userId, 'username' => $this->_username);
    }
    
    // Function for updating the current object:
    function update($data) {
        $this->_username = $data['username'];
    }

    // Function for getting rid of the current object:
    public function delete() {
        $this->_username = NULL;
        $this->_userId = NULL;
    }
    
} // End of User class.

// Identify the user information:
$user = array('username' => 'trout');

// Print a little introduction:
echo "<h2>Creating a New User</h2>";

// Create a new User:
$me = new User($user);

// Get the user's ID:
$info = $me->read();
echo "<p>The user ID is {$info['userId']}.</p>";

// Change the user's name:
$me->update(array('username' => 'troutster'));

// Confirm the updated name:
$info = $me->read();
echo "<p>The user name is now {$info['username']}.</p>";

// Delete the record:
$me->delete();
    
// Delete the object:
unset($me);

?>
</body>
</html>