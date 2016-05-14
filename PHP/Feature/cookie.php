<?php
/**
 * Created by PhpStorm.
 * User: helen
 * Date: 16-5-14
 * Time: 上午10:57
 */

/**
 * Setting new cookie
 * name is your cookie's name
 * value is cookie's value
 * $int is time of cookie expires
 */
$int = 10;
setcookie("name","value",time()+$int);

/**
 * Getting Cookie
 */
echo $_COOKIE["name"];

/**
 * Updating Cookie
 */
setcookie("color","red");
echo $_COOKIE["color"];
/*color is red*/
/* your codes and functions*/
setcookie("color","blue");
echo $_COOKIE["color"];
/*new color is blue*/

/**
 * Deleting Cookie
 */
unset($_COOKIE["yourcookie"]);
/*Or*/
setcookie("yourcookie","yourvalue",time()-1);
/*it expired so it's deleted*/