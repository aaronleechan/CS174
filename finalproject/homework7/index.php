<!DOCTYPE html>
<html>
<body>

<form>
    User name:<br>
    <input id="username" type="text" name="username" placeholder="Username" >
    <br>
    Email:<br>
    <input id="email" type="text" name="email" placeholder="Email" required="required"><br>
    <br>
    Password:<br>
    <input id="password" type="password" name="password" placeholder="Password" required="required"><br>
    <br><br>

    <input type="submit"
           onclick="check()"
           value="Submit"
    >
</form>

<p>If you click the "Submit" button, Invalid user (name, email and password) will alert as FALSE. Password length only can be max 8".</p>

</body>
</html>


<script>
    function check(){

        var user_name       = document.getElementById("username").value;
        var user_email      = document.getElementById("email").value;
        var user_password   = document.getElementById("password").value;

        var username_check      = usernameIsValid(user_name);
        var useremail_check     = useremailIsValid(user_email);
        var userpassword_check  = userpasswordIsValid(user_password);

        alert(" USER NAME " + username_check + " USER EMAIL " +  useremail_check + " USER PASSWORD " + userpassword_check);
    }

    function usernameIsValid(username) {

        var testcharacter = /^[0-9a-zA-Z_.-]/;
        var check = testcharacter.test(username);
        return check;
    }

    function useremailIsValid(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    function userpasswordIsValid(password){

        if(password.length > 8 ){
            return false;
        }else{
            return true;
        }
    }

</script>


