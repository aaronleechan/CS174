<h1> Register </h1>

<div class="container">
    <form action="login.php" method="post" enctype="multipart/form-data">
        <h2>Select file to upload:</h2>
        <input type="text" name="email" placeholder="Email" required="required"><br>
        <input type="password" name="password" placeholder="Password" required="required"><br>
        <button type="submit" name="submit" value="upload">Submit</button>
    </form>
</div>

<?php

if(isset($_POST['submit'])){

    $servername = 'localhost';
    $db = 'cs174';
    $user = 'root';
    $password = '';
    $table = 'users';
    $connection = new mysqli($servername,$user,$password,$db);
    if($connection->connect_error)die($connection->connect_error);


    $username       = mysqli_real_escape_string($dbc,$_POST['email']);
    $userpassword   = mysqli_real_escape_string($dbc,$_POST['password']);

//    add_user($forename,$surname,$username,$userpassword);

}





