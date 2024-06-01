<?php
echo "Hello World!";

$tasks = [];
$task = "";

if(isset($_POST['addtask'])){
  $task = $_POST['addtask'];
}
array_push($tasks, $task);
var_dump($tasks);
