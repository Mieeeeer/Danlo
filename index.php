<?php
session_start();

// Optional: You can store a value to check if session is working
$_SESSION['active'] = true;

// Then load the home.html
include('home.html');
?>
