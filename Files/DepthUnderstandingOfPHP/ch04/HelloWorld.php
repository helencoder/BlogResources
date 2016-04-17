<?php # Script 4.8 - HelloWorld.php #2
/**
 * This page defines the HelloWorld class.
 *
 * Written for Chapter 5, "Basic Object-Oriented Programming" 
 * of the book "PHP Advanced and Object-Oriented Programming"
 * @author Larry Ullman <Larry@LarryUllman.com>
 * @copyright 2012
 */

/**
 * The HelloWorld class says "Hello, world!" in different languages.
 *
 * The HelloWorld class is mostly for 
 * demonstration purposes. 
 * It's not really a good use of OOP.
 */
class HelloWorld {

    /**
     * Function that says "Hello, world!" in different languages.
     * @param string $language Default is "English"
     * @returns void
     */
    function sayHello($language = 'English') {

        // Put the greeting within P tags:
        echo '<p>';
        
        // Print a message specific to a language:
        switch ($language) {
            case 'Dutch':
                echo 'Hallo, wereld!';
                break;
            case 'French':
                echo 'Bonjour, monde!';
                break;
            case 'German':
                echo 'Hallo, Welt!';
                break;
            case 'Italian':
                echo 'Ciao, mondo!';
                break;
            case 'Spanish':
                echo '¡Hola, mundo!';
                break;
            case 'English':
            default:
                echo 'Hello, world!';
                break;
        } // End of switch.

        // Close the HTML paragraph:
        echo '</p>';

        } // End of sayHello() method.
    
} // End of HelloWorld class.