<?php
    require __DIR__ . '/../vendor/autoload.php';
    use MongoDB\Client;



    $conn = new mysqli('localhost', 'root', '', 'school_portal');
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $client = new Client("mongodb://localhost:27017");
    $db = $client->Sta_Ana;

    $Enrollment = $db->Enrollment; 
    $Logo = $db->Logo;
    $Home = $db->Home;
    $Contact = $db->Contact;
    $Welcome = $db->Welcome;
    $About = $db->About;
    $OrgChart = $db->OrgChart;
    $AnnouncementLink = $db->AnnouncementLinks;
    $Content = $db->Content; // Collection for news, blog posts, and Facebook posts
?>
