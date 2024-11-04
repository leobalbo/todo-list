<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "todo_list";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}

?>
