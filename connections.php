<?php

$connections = mysqli_connect("mysql.hostinger.com","u815942348_graphio_db","@Graphio12345","u815942348_graphio_db");
#$connections = mysqli_connect("localhost","root","","graphio_dbv3");

if(mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


?>
