<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Manrope">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript">
            var user_type = "";
            $(document).ready(function(){
                $("#se_penkra_cover .radio-button").click(function(){
                    var id = $(this).attr('id');
                    $("#"+id).addClass('selected');
                    switch (id){
                        case "student": 
                            user_type = "0";
                            $("#faculty").removeClass('selected'); 
                            break;
                        case "faculty": 
                            user_type = "1";
                            $("#student").removeClass('selected');
                            break;
                    }
                });
            });
            
            function signUp(){
                const fname = $("#fname").val().trim();
                const lname = $("#lname").val().trim();
                const email = $("#email").val().trim();
                const password = $("#password").val().trim();
                const address = email.split('@').pop();
                if (user_type == "") $("#signup-error").text("❌️ Select your user type");
                else if (fname == "") $("#signup-error").text("❌️ Provide your Firstname");
                else if (lname == "") $("#signup-error").text("❌️ Provide your Lastname");
                else if (!validateEmail(email) || address != "claflin.edu") $("#signup-error").text("❌️ Provide your valid Claflin Email Address");
                else if (password == "") $("#signup-error").text("❌️ Provide your Password");
                else {
                    $("#signup-error").text("");
                    $.post('exe/_signup', {user_type: user_type, fname : fname, lname : lname, email : email, password : password}, function(msg){
                        if (msg == ""){
                            alert("Your account has been created. Sign in with your email and password");
                            $("#signup-error").css('color', 'green').text("Close this page and sign in with your new credentials");
                        }else $("#signup-error").text("❌️ "+msg);
                    });
                }
            }
            
            function validateEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }
        </script>
        <style>
            #se_penkra_cover {
                display: flex;
            }
        </style>
    </head>
    <body>
        <div id="se_penkra_cover">
            <div class="se_penkra_main">
                <div class="se_penkra_title_2">Software Engineering</div>
                <div class="se_penkra_title_1">Create an Account</div>
                <br>
                <p class="error" id="signup-error"></p>
                <div class="flex">
                    <button class="radio-button" id="student">I'm a student</button>
                    <div class="space"></div>
                    <button class="radio-button" id="faculty">I'm a faculty</button>
                </div>
                <input id="fname" placeholder="Your Firstname">
                <input id="lname" placeholder="Your Lastname">
                <input id="email" placeholder="Your Email" type="email">
                <input id="password" placeholder="Your Password" type="password">
                <button class="button" onclick="signUp();">Sign Up</button>
            </div>
        </div>
    </body>
</html>