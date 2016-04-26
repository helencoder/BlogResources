<?php # Script 10.5 - service.php
// This script acts as a simple Web service.
// The script only reports back the data received, along with a bit of extra information.

// Check for proper usage:
if (isset($_POST['format'])) {
    
    // Switch the content type based upon the format:
    switch ($_POST['format']) {
        case 'csv':
            $type = 'text/csv';
            break;
        case 'json':
            $type = 'application/json';
            break;
        case 'xml':
            $type = 'text/xml';
            break;
        default:
            $type = 'text/plain';
            break;
    }
    
    // Create the response:
    $data = array();
    $data['timestamp'] = time();
    
    // Add back in the received data:
    foreach ($_POST as $k => $v) {
        $data[$k] = $v;
    }
    
    // Format the data accordingly:
    if ($type == 'application/json') {
        $output = json_encode($data);
        
    } elseif ($type == 'text/csv') {
    
        // Convert to a string:
        $output = '';
        foreach ($data as $v) {
            $output .= '"' . $v . '",';
        }
    
        // Chop off the final comma:
        $output = substr($output, 0, -1); 

    } elseif ($type == 'text/plain') {
        $output = print_r($data, 1);
    }

} else { // Incorrectly used!
    $type = 'text/plain';
    $output = 'This service has been incorrectly used.';
}

// Set the content-type header:
header("Content-Type: $type");
echo $output;