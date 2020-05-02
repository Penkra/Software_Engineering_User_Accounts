<?php

header("access-control-allow-origin: *");

require_once '../exe/defaults.php';
require_once '../exe/connection.php';

require_params(["email", "password"]);

$d = simple_query("S", $con, "SELECT id, password FROM users WHERE email = ? LIMIT 1;", [$i["email"]]);

if ($d === false) die("Your email is not signed up yet");
if(!password_verify($i["password"], $d["password"])) die("Your password is incorrect");

// save_cookie("user_id", $d["id"]);
session_start();
$_SESSION["user_id"] = $d["id"];

echo $d["id"];

?>