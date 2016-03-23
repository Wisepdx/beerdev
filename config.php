<?php

    //Live Server
    //define('DB_SERVER', '10.0.1.114');
    //define('DB_USERNAME', 'beer');
    //define('DB_PASSWORD', 'wisepdx');
    //define('DB_DATABASE', 'beer');

    //TEST SERVER
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_DATABASE', 'beer');
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
