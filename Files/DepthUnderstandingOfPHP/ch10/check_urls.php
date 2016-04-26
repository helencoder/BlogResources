<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Validate URLs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 10.2 - check_urls.php
// This page validates a list of URLs. It uses fsockopen() and parse_url() to do so.

// This function will try to connect to a URL:
function check_url($url) { 

    // Break the URL down into its parts:
    $url_pieces = parse_url($url);
    
    // Set the $path and $port:
    $path = (isset($url_pieces['path'])) ? $url_pieces['path'] :  '/'; 
    $port = (isset($url_pieces['port'])) ? $url_pieces['port'] : 80; 

    // Connect using fsockopen():
    if ($fp = fsockopen($url_pieces['host'], $port, $errno, $errstr, 30)) { 

        // Send some data:
        $send = "HEAD $path HTTP/1.1\r\n";
        $send .= "HOST: {$url_pieces['host']}\r\n";
        $send .= "CONNECTION: Close\r\n\r\n";
        fwrite($fp, $send);
        
        // Read the response:
        $data = fgets($fp, 128); 

        // Close the connection:
        fclose($fp); 

        // Return the response code:
        list($response, $code) = explode(' ', $data); 
        if ($code == 200) {
            return array($code, 'good');
        } else {
            return array($code, 'bad');
        }

    } else { // No connection, return the error message:
        return array($errstr, 'bad');
    }
     
} // End of check_url() function.

// Create the list of URLs:
$urls = array(
'http://www.larryullman.com/',
'http://www.larryullman.com/wp-admin/',
'http://www.yiiframework.com/tutorials/',
'http://video.google.com/videoplay?docid=-5137581991288263801&q=loose+change'
);

// Print a header:
echo '<h2>Validating URLs</h2>';

// Kill the PHP time limit:
set_time_limit(0);

// Validate each URL:
foreach ($urls as $url) {
    list($code, $class) = check_url($url);
    echo "<p><a href=\"$url\" target=\"_new\">$url</a> (<span class=\"$class\">$code</span>)</p>\n";
} 
?>
</body>
</html>