<?php

//mysql://b8777d0ae7827a:be3a7d4b@us-cdbr-east-04.cleardb.com/heroku_f9e3d90d4a52b4f?reconnect=true
 
// $host       = "us-cdbr-east-04.cleardb.com";
// $username   = "b8777d0ae7827a";
// $password   = "be3a7d4b";
// $dbname     = "heroku_f9e3d90d4a52b4f";

$host       = "localhost";
$username   = "eric";
$password   = "123456";
$dbname     = "Bank";

$dsn        = "mysql:host=$host;dbname=$dbname";

$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
?>
