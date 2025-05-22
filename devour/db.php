<?php
    require 'vendor/autoload.php';
    use MongoDB\Client;

    $client = new Client("mongodb://localhost:27017");
    $db = $client->Sta_Ana;

    $Content = $db->Content;
?>
