<?php

require_once 'defaults.php';

require_params(["user_type", "fname", "lname", "email", "password"]);

require_once 'connection.php';

if(simple_query("S", $con, "SELECT id FROM users WHERE email = ? LIMIT 1;", [$i["email"]]) !== false) die("You already have an account with us. Please sign in");

$i["password"] = password_hash($i["password"], PASSWORD_DEFAULT);

simple_query("I", $con, "INSERT INTO users (fname, lname, email, type, password) VALUES (?, ?, ?, ?, ?);", [$i["fname"], $i["lname"], $i["email"], $i["user_type"], $i["password"]]);

?>