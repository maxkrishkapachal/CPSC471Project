<?php
    $dbhost = "localhost"; 
    $dbuser = "root"; 
    $dbpass = "";

    $dbname = "cpsc471";

    // Create a connection 
    $conn = mysqli_connect($dbhost, 
        $dbuser, $dbpass, $dbname);

    // Code written below is a step taken
    // to check that our Database is 
    // connected properly or not. If our 
    // Database is properly connected we
    // can remove this part from the code 
    // or we can simply make it a comment 
    // for future reference.

    if(!$conn) {
        die("Error". mysqli_connect_error()); 
    } 
