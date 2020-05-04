$(document).ready(function(){
    //CHECK IF USER IS LOGGED IN
    addHeaders();
    checkLogin();
    getAllUsers();
});

function addHeaders(){
    let t = '<div id="se_penkra_cover"><div class="se_penkra_main"><div class="se_penkra_title_2">Software Engineering</div><div class="se_penkra_title_1">Login to Access</div><a href="https://se.penkra.com/signup" target="_blank">Don\'t have an account yet? Sign Up 👉</a><br><p class="error" id="signup-error"></p><input placeholder="Your Email" type="email" id="email"><input id="password" placeholder="Your Password" type="password"><button class="button" onclick="login();">Login</button></div></div>';
    
    t += '<div id="se_penkra_header">Software<br>Engineering<div id="se_penkra_links"><a href="#">Link 1</a><a href="#">Link 2</a><a href="#">Link 3</a><a href="#">Link 4</a></div><div id="se_penkra_account"><div id="se_penkra_name"></div><div id="se_penkra_logout" onclick="logout();">Logout</div></div></div>';
    $("body").prepend(t);
    $("#se_penkra_name").text(getUserData('firstname') + " " + getUserData('lastname'));
}

function checkLogin(){
    if (getUserData('id') == null) $("#se_penkra_cover").css('display', 'flex');
}

function getUserData($key){
    return localStorage.getItem("user_" + $key);
}

function saveUserData($key, $value){
    localStorage.setItem($key, $value);
}

function getOneUser($uid){
    let users = JSON.parse(localStorage.getItem("all_users"));
    return users.find(o => o.id === $uid);
}

function getAllUsers(){
    $.post('https://se.penkra.com/apis/fetchUsers', {}, function(msg){
        let all = JSON.parse(msg);
        let users = localStorage.getItem("all_users");
        saveUserData("all_users", JSON.stringify(all.users));
        if(users == null) location.reload();
    });
}

function login(){
    let email = $("#email").val().trim();
    let password = $("#password").val().trim();
    if(!validateEmail(email)) $("#signup-error").text("❌️ Provide your valid Claflin Email Address");
    else if (password == "") $("#signup-error").text("❌️ Provide your password");
    else {
        $("#signup-error").text("");
        $.post('https://se.penkra.com/apis/signIn', {email: email, password: password}, function(msg){
            let info = JSON.parse(msg);
            if (info._status == 0){
                $("#signup-error").text("❌️ " + info._error);
                return;
            }
            saveUserData('user_id', info.id);
            saveUserData('user_firstname', info.fname);
            saveUserData('user_lastname', info.lname);
            saveUserData('user_email', info.email);
            saveUserData('user_isStudent', info.isStudent);
            saveUserData('user_isTeacher', info.isTeacher);
            location.reload();
        });
    }
}

function logout(){
    localStorage.removeItem("user_id");
    localStorage.removeItem("user_firstname");
    localStorage.removeItem("user_lastname");
    localStorage.removeItem("user_email");
    localStorage.removeItem("user_isStudent");
    localStorage.removeItem("user_isTeacher");
    location.reload();
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}