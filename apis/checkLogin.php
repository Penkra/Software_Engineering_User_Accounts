<?php

header("access-control-allow-origin: *");

require_once '../exe/defaults.php';
require_once '../exe/connection.php';

require_params(["user_id"]);

$d = simple_query("S", $con, "SELECT fname, lname, email FROM users WHERE id = ? LIMIT 1;", [$i["user_id"]]);

$o->fname = $d["fname"];
$o->lname = $d["lname"];
$o->email = $d["email"];

done();

?>