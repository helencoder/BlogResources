<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Get Stock Quotes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 10.1 - get_quote.php
//  This page retrieves a stock price from Yahoo!.

if (isset($_GET['symbol']) && !empty($_GET['symbol'])) { // Handle the form.

    // Identify the URL:
    $url = sprintf('http://quote.yahoo.com/d/quotes.csv?s=%s&f=nl1', $_GET['symbol']);

    // Open the "file".
    $fp = fopen($url, 'r');
        
    // Get the data:
    $read = fgetcsv($fp);
    
    // Close the "file":
    fclose($fp);
    
    // Check the results for improper symbols:
    if (strcasecmp($read[0], $_GET['symbol']) !== 0) {

        // Print the results:
        echo '<div>The latest value for <span class="quote">' . $read[0] . '</span> (<span class="quote">' . $_GET['symbol'] . '</span>) is $<span class="quote">' . $read[1] . '</span>.</div>';
        
    } else {
        echo '<div class="error">Invalid symbol!</div>';
    }

} // End of form submission IF.

// Show the form:
?><form action="get_quote.php" method="get">
    <fieldset>
        <legend>Enter a NYSE stock symbol to get the latest price:</legend>
        <p><label for="symbol">Symbol</label>: <input type="text" name="symbol" size="5" maxlength="5"></p>
        <p><input type="submit" name="submit" value="Fetch the Quote!" /></p>
    </fieldset>
</form>
</body>
</html>