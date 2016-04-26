<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Using cURL</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>cURL Results:</h2>
<?php # Script 10.4 - curl.php
// This page uses cURL to post data to a Web service.
 
// Identify the URL:
$url = 'http://localhost/service.php';

// Start the process:
$curl = curl_init($url);   

// Tell cURL to fail if an error occurs:
curl_setopt($curl, CURLOPT_FAILONERROR, 1); 

// Allow for redirects:
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

// Assign the returned data to a variable:
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

// Set the timeout:
curl_setopt($curl, CURLOPT_TIMEOUT, 5);

// Use POST:
curl_setopt($curl, CURLOPT_POST, 1);

// Set the POST data:
curl_setopt($curl, CURLOPT_POSTFIELDS, 'name=foo&pass=bar&format=csv');

// Execute the transaction:
$r = curl_exec($curl);

// Close the connection:
curl_close($curl);

// Print the results:
print_r($r);

?>
</body>
</html>