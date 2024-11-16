<?php
define('host','localhost');
define('password','root');
define('username','root');
define('dbname',"todolist");
$dsn = sprintf("mysql:hostname=%s; dbname=%s",host,dbname);
$pdo= new PDO($dsn,username,password);
?>