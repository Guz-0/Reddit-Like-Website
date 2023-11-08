<?php
#echo $_GET['request'];

include_once "db_connection.php";

$thread_id = $_GET['thread_id'];

$connection = connectToDB("website1");
$sql = "DELETE FROM thread WHERE thread_id = '$thread_id' ";
$result = mysqli_query($connection, $sql);

var_dump($result);
