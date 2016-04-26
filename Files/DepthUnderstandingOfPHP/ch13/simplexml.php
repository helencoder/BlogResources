<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SimpleXML Parser</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 13.9 - simplexml.php

/*  This script will parse an XML file.
 *  It uses the simpleXML library, a DOM parser.
 */
 
 // Read the file:
$xml = simplexml_load_file('books4.xml');

// Iterate through each book:
foreach ($xml->book as $book) {

    // Print the title:
    echo "<div><h2>$book->title";
    
    // Check for an edition:
	if (isset($book->title['edition'])) {
	    echo " (Edition {$book->title['edition']})";
	}

	echo '</h2>';
    
    // Print the author(s):
	foreach ($book->author as $author) {
	    echo "<span class=\"label\">Author</span>: $author<br>";
	}
    
    // Print the other book info:
	echo "<span class=\"label\">Published:</span> $book->year<br>";

	if (isset($book->pages)) {
	    echo "<span class=\"label\">Pages:</span> $book->pages<br>";
	} 
    
    // Print each chapter:
	if (isset($book->chapter)) {
	    echo 'Table of Contents<ul>';
	    foreach ($book->chapter as $chapter) {
        
			echo '<li>';

			if (isset($chapter['number'])) {
			    echo "Chapter {$chapter['number']}: ";
			}

			echo $chapter;

			if (isset($chapter['pages'])) {
			    echo " ({$chapter['pages']} Pages)";
			}

			echo '</li>';
            
        }
        echo '</ul>';
    }
    
    // Handle the cover:
	if (isset($book->cover)) {

	    // Get the image info:
	    $image = @getimagesize ($book->cover['filename']);
    
	    // Make the image HTML:
	    echo "<img src=\"{$book->cover['filename']}\" $image[3] border=\"0\" /><br>";
    
	}
    
    // Close the book's DIV tag:
    echo '</div>';
    
} // End of foreach loop.
?>
</body>
</html>