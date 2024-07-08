
<?php

session_start();

$_SESSION["login_user"] = $_POST['username'];
$_SESSION["password_user"] = $_POST['password'];

header('Location: index.php');    

?>


