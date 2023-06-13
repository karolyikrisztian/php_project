<?php
// Prompt the user for input
echo "Enter your name: ";

// Read input from the user
$handle = fopen("php://stdin", "r");
$name = fgets($handle);

// Remove any trailing newline characters
$name = trim($name);

// Display the user's name
echo "Hello, $name!";

// Close the input stream
fclose($handle);
?>