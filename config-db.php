<?php
// définition des constantes
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "todo_list");

// Create connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}

// echo 'Success: A proper connection to MySQL was made.';
// echo '<br>';
// echo 'Host information: ' . $mysqli->host_info;
// echo '<br>';
// echo 'Protocol version: ' . $mysqli->protocol_version;

// $mysqli->close();
