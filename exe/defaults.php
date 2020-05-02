<?php

$i = array();
$o = new stdClass();

function error($err, $msg = ""){
    $o->_status = 0;
    $o->_error = $err;
    $o->_message = $msg;
    die(json_encode($o));
}

function done(){
    global $o;
    $o->_status = 1;
    $o->_message = "Success";
    die(json_encode($o));
}

function require_params($params){
    global $i;
    foreach($params as $param){
        if(!isset($_POST[$param])) error("", "Please provide all required fields");
        $i[$param] = trim($_POST[$param]);
    }
}

function gdate($time){
    return gmdate("d/m/y", $time);
}

function gtime($time){
    return gmdate("g:i A", $time);
}

function gvalue($con, $key){
    $query = $con->prepare("SELECT _value FROM safe_list WHERE _key = ? LIMIT 1;");
    $query->execute(array($key));
    $data = $query->fetch();
    return $data["_value"];
}

function http_post($url, $data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function simple_query($type, $con, $qry, $arr){
    try {
        $exe = $con->prepare($qry);
        $exe->execute($arr);
        switch($type){
            case "I": return $con->lastInsertId();
                break;
            case "S": return $exe->fetch();
                break;
            case "M": return $exe;
                break;
            case "U":
            case "D":
                break;
        }
    }catch (Exception $e){
        error("", $e->getMessage());
    }
}

function save_cookie($key, $value){
    setcookie($key, $value, time() + (86400 * 265), "/", null, null, true);
}

function delete_cookie($key){
    setcookie($key, "", time()-1, "/");
}

function get_cookie($key){
    return $_COOKIE[$key];
}

function replace_page($location){
    ob_start();
    header("Location: ".$location);
    ob_end_flush();
    exit();
}

function format_currency($c){
    return number_format((float) round($c, 2), 2, '.', '');
}

function format_time($t){
    $t = round($t);
    $hrs = floor($t / 60);
    if($hrs > 0) $t = round($t % 60);
    else return $t." mins";
    if($t == 0) return $hrs." hrs";
    return $hrs." hrs ".$t." mins";
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>