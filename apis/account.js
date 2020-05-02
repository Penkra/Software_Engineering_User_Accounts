//DEPENDENT ON JQUERY

var user_id = localStorage.getItem("user_id");
var user_firstname, user_lastname, user_email;

$(document).ready(function(){
    //CHECK IF USER IS LOGGED IN
    addHeaders();
    checkLogin();
});

function addHeaders(){
    let t = '<div id="se_penkra_cover"><div class="se_penkra_main"><div class="se_penkra_title_2">Software Engineering</div><div class="se_penkra_title_1">Login to Access</div><a href="https://se.penkra.com/signup" target="_blank">Don\'t have an account yet? Sign Up 👉</a><br><p class="error" id="signup-error"></p><input placeholder="Your Email" type="email" id="email"><input id="password" placeholder="Your Password" type="password"><button class="button" onclick="login();">Login</button></div></div>';
    
    t += '<div id="se_penkra_header">Software<br>Engineering<div id="se_penkra_links"><a href="#">Link 1</a><a href="#">Link 2</a><a href="#">Link 3</a><a href="#">Link 4</a></div><div id="se_penkra_account"><div id="se_penkra_name"></div><div id="se_penkra_logout" onclick="logout();">Logout</div></div></div>';
    $("body").prepend(t);
}

function checkLogin(){
    if (user_id != null){
        $.post('https://se.penkra.com/apis/checkLogin', {user_id: user_id}, function(msg){
            $("#se_penkra_cover").css('display', 'none');
            let info = JSON.parse(msg);
            user_firstname = info.fname;
            user_lastname = info.lname;
            user_email = info.email;
            $("#se_penkra_name").text(user_firstname + " " + user_lastname);
        });
    }else $("#se_penkra_cover").css('display', 'flex');
}

function login(){
    let email = $("#email").val().trim();
    let password = $("#password").val().trim();
    if(!validateEmail(email)) $("#signup-error").text("❌️ Provide your valid Claflin Email Address");
    else if (password == "") $("#signup-error").text("❌️ Provide your password");
    else {
        $("#signup-error").text("");
        $.post('https://se.penkra.com/apis/signIn', {email: email, password: password}, function(msg){
            if (msg > 0){
                localStorage.setItem("user_id", msg);
                location.reload();
            }else $("#signup-error").text("❌️ "+msg);
        });
    }
}

function logout(){
    localStorage.removeItem("user_id");
    location.reload();
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}