<?php

header("access-control-allow-origin: *");

require_once '../exe/defaults.php';
require_once '../exe/connection.php';

require_params(["email", "password"]);

$d = simple_query("S", $con, "SELECT id, fname, lname, email, type, password FROM users WHERE email = ? LIMIT 1;", [$i["email"]]);

if ($d === false) error("Your email is not signed up yet");
if(!password_verify($i["password"], $d["password"])) error("Your password is incorrect");

$o->id = (int) $d["id"];
$o->fname = $d["fname"];
$o->lname = $d["lname"];
$o->email = $d["email"];
$o->isStudent = $d["type"] == 0;
$o->isTeacher = $d["type"] == 1;

done();

?>