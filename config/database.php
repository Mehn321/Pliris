<?php
$db_host = getenv('PGHOST');
$db_port = getenv('PGPORT');
$db_name = getenv('PGDATABASE');
$db_user = getenv('PGUSER');
$db_pass = getenv('PGPASSWORD');

$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name;";
$conn = new PDO($dsn, $db_user, $db_pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
