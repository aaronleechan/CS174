<h1> Register </h1>

<div class="container">
    <form action="Register.php" method="post" enctype="multipart/form-data">
        <h2>Select file to upload:</h2>
        <input type="text" name="firstName" placeholder="First Name" required="required"><br>
        <input type="text" name="lastName" placeholder="Last Name" required="required"><br>
        <input type="text" name="email" placeholder="Email" required="required"><br>
        <input type="password" name="password" placeholder="Password" required="required"><br>
        <button type="submit" name="submit" value="upload">Submit</button>
    </form>
</div>

<?php

if(isset($_POST['submit'])){
    echo " ===========> TESTING </br>";

    $forename   = $_POST['firstName'];
    $surname    = $_POST['lastName'];
    $username   = $_POST['email'];
    $userpassword   = $_POST['password'];

    add_user($forename,$surname,$username,$userpassword);

}

function add_user($forename,$surename,$username,$userpassword){

    echo " +++++++++++> ABC TEST";

    $servername = 'localhost';
    $db = 'cs174';
    $user = 'root';
    $password = '';
    $table = 'users';
    $connection = new mysqli($servername,$user,$password,$db);
    if($connection->connect_error)die($connection->connect_error);

    $salt1 = "%19test";
    $salt2 = "*7jdkm:";
    $token = hash('ripemd128','$salt1$password$salt2');
    $query = "INSERT INTO users VALUES ('$forename','$surename','$username','$token')";
    $result = $connection->query($query);
    if(!$result) die($connection->error);


    $result->close();
    $connection->close();
}



