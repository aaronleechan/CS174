<center>
    <div class="container">
        <form action="login.php" method="post" enctype="multipart/form-data">
            <h2>Admin Login</h2>
            <input type="text" name="email" placeholder="Email" required="required"><br>
            <input type="password" name="password" placeholder="Password" required="required"><br>
            <button type="submit" name="submit" value="upload">Submit</button>
        </form>
    </div>
</center>



<?php

$servername = 'localhost';
$db = 'cs174';
$user = 'root';
$password = '';
$table = 'admin';

$connection = new mysqli($servername,$user,$password,$db);
if($connection->connect_error) die($connection->connect_error);

if(isset($_POST['email']) && isset($_POST['password'])){
    $un_temp = mysql_entities_fix_string($connection, $_POST['email']);
    $pw_temp = mysql_entities_fix_string($connection, $_POST['password']);

    $query = "SELECT * FROM $table WHERE username='$un_temp'";
    $result = $connection->query($query);

    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $salt1 = '%9Xbqb';
        $salt2 = '*7(Dz_.t:LZNZ:';
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");
        if($token == $row[3]){
            session_start();
            $_SESSION['username'] = $un_temp;
            $_SESSION['password'] = $pw_temp;
            $_SESSION['forename'] = $row[0];
            $_SESSION['username'] = $row[1];
            $_SESSION['admin'] = 1;
            header('Location: adminscan.php');

        }
        else {
            $result->close();
            $connection->close();
            echo '<script> alert("Invalid username/password combination"); window.location = "index.php" </script>';

        }
    }
    else {
        $result->close();
        $connection->close();
        echo '<script> alert("Invalid username/password combination."); window.location = "index.php" </script>';


    }

}

$connection->close();
function mysql_entities_fix_string($connection,$string){
    return htmlentities(mysql_fix_string($connection,$string));
}
function mysql_fix_string($connection, $string)
{
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
}




?>

