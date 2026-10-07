<?php

$conn = mysqli_connect("localhost", "root", "", "gamezone");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>