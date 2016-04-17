<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Distance Calculator</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 3.3 - distance.php

/*  This page uses the zips database to
 *  calculate the distance between a given
 *  point and some stores.
 *  The three closest stores are returned.
 */
 
$zip = 64154; //User's zip code.

// Print a caption:
echo "<h1>Nearest stores to $zip:</h1>";

// Connect to the database:
$dbc = mysqli_connect('localhost', 'username', 'password', 'zips');

// Get the origination latitude and longitude:
$q = "SELECT latitude, longitude FROM zip_codes WHERE zip_code='$zip' AND latitude IS NOT NULL";
$r = mysqli_query($dbc, $q);

// Retrieve the results:
if (mysqli_num_rows($r) == 1) {

    list($lat, $long) = mysqli_fetch_array($r, MYSQLI_NUM);
    
    // Big, main, complex, wordy query:
    $q = "SELECT name, CONCAT_WS('<br>', address1, address2), city, state, stores.zip_code, phone, ROUND(DEGREES(ACOS(SIN(RADIANS($lat)) 
* SIN(RADIANS(latitude)) 
+ COS(RADIANS($lat))  
* COS(RADIANS(latitude))
* COS(RADIANS($long - longitude)))) * 69.09) AS distance FROM stores LEFT JOIN zip_codes USING (zip_code) ORDER BY distance ASC LIMIT 3";
    $r = mysqli_query($dbc, $q);
    
    if (mysqli_num_rows($r) > 0) {

        // Display the stores:
        while ($row = mysqli_fetch_array($r, MYSQLI_NUM)) {
            echo "<h2>$row[0]</h2>
    <p>$row[1]<br />" . ucfirst(strtolower($row[2])) . ", $row[3] $row[4]<br />
    $row[5] <br />
    (approximately $row[6] miles)</p>\n";

        } // End of WHILE loop.
        
    } else { // No stores returned.

        echo '<p class="error">No stores matched the search.</p>';

    }
    
} else { // Invalid zip code.

    echo '<p class="error">An invalid zip code was entered.</p>';

}

// Close the connection:
mysqli_close($dbc);

?>
</body>
</html>