<?php

if(!isset($_SERVER['HTTPS'])){
    
    $sub = strtolower(explode('.', $_SERVER["HTTP_HOST"])[0]);
    $sub = $sub == "penkra" ? "" : "/".$sub;
    
    ob_start();
    header("Location: https://se.penkra.com".$sub.$_SERVER[REQUEST_URI]);
    ob_end_flush();
    exit();
}

?>