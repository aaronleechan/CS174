<?php
/**
 * Created by PhpStorm.
 * User: aaron
 * Date: 11/29/17
 * Time: 3:41 PM
 */
$servername = 'localhost';
$db = 'cs174';
$user = 'root';
$password = '';
$table = 'admin';

$connection = new mysqli($servername,$user,$password,$db);
if($connection->connect_error) die($connection->connect_error);

if(isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
    $un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);

    $query = "SELECT * FROM $table WHERE username='$un_temp'";
    $result = $connection->query($query);

    print_r($result);
    if (!$result) die($connection->error);
    elseif ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();
        $salt1 = '%9Xbqb';
        $salt2 = '*7(Dz_.t:LZNZ:';
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");
        echo "token = $token</br>";
        echo "WHAT IS THE VALUE ::: $token";
        if($token == $row[3]){
            session_start();
            $_SESSION['username'] = $un_temp;
            $_SESSION['password'] = $pw_temp;
            $_SESSION['forename'] = $row[0];
            $_SESSION['username'] = $row[1];
            echo "$row[0] $row[1]: Hi $row[0],you are now logged in as $row[2]";
            die("<p><a href='index.php'>Click here to cointinue</a>");
        }
        else {

            die("Invalid username/password combination");

            header("location: index.php");
        }
    }
    else {
        echo "(((";
        die("Invalid username/password combination");

        header("location: index.php");
    }

}
else {
    header('WWW-Authenticate: Basic realm="Restricted Section“');
    header("HTTP/1.0 401 Unauthorized");
    die("Please enter your username and password");

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