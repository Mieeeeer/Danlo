<?php
    require 'vendor/autoload.php';
    use MongoDB\Client;

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
?>
