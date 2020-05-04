<?php

header("access-control-allow-origin: *");

require_once '../exe/defaults.php';
require_once '../exe/connection.php';

$users = simple_query("M", $con, "SELECT id, fname, lname, email, type FROM users;", []);

$arr = array();
foreach($users as $u){
    $arr[] = (object)[
        "id" => (int) $u["id"],
        "fname" => $u["fname"],
        "lname" => $u["lname"],
        "email" => $u["email"],
        "isStudent" => $u["type"] == 0,
        "isTeacher" => $u["type"] == 1
    ];
}

$o->users = $arr;

done();

?>