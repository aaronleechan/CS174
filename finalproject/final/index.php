<!DOCTYPE html>
<html>
<head>
    <title>Final Project</title>
</head>

<style>

    header{
        width: 100%;
        height: 100px;
        background-color: grey;
        color: white;
        font-size: 70px;
        margin:0px;
        margin-top: -70px;
    }

    .container{
        width: 100%;
        height: auto;
        margin-top: 3px;
        background-color: ghostwhite;
        position: relative;
        text-align: center;
        border: 2px solid green;
    }

    input[type=file],select{
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 30px;
    }

    input[type=text],select{
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 30px;
    }

    button{
        width: 50%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 30px;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #333;
    }

    li {
        float: left;
    }

    li a {
        display: block;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

    li a:hover:not(.active) {
        background-color: #111;
    }

    .active {
        background-color: #4CAF50;
    }

</style>

<body>


<!-- Title of the Final Project -->

<ul>
    <li style="float:right"><a class="active" href="login.php">Admin Log In</a></li>
</ul>

<header>
    <center>
        <h3>File Detection</h3>
    </center>
</header>

<div class="container">

    <form action="index.php" method="post" enctype="multipart/form-data">
        <h2>Select file to upload:</h2>
        <input type="file" name="file" id="fileToUpload" required="required">
        <button type="submit" name="submit" value="upload">Scan</button>
    </form>
</div>


<!-- php class -->
<?php


//Start the Program
void_main();

//Declare Variable
function void_main(){

    $file_name  = "";   $file_type  = "";   $file_size  = 0;
    read_file();   //Read File
}

//Read file
function read_file(){
    if(isset($_POST["submit"])) {
        $file_name  = $_FILES['file']['name'];
        $file_type  = $_FILES['file']['type'];
        $file_size  = $_FILES['file']['size'];
        check_file($file_name, $file_type, $file_size);     //Check the file
    }
}

// Take the content of the file
function check_file($file_name,$file_type,$file_size){
    if( ($file_size > 0) )
    {
        $contextFile = file_get_contents($_FILES['file']['tmp_name']);
        connectDatabase($contextFile);
    }
    else{
        exit();
    }
}


function ascii2hex($ascii) {
    $hex = '';
    for ($i = 0; $i < strlen($ascii); $i++) {
        $byte = strtoupper(dechex(ord($ascii{$i})));
        $byte = str_repeat('0', 2 - strlen($byte)).$byte;
        $hex.=$byte." ";
    }
    return $hex;
}

function connectDatabase($contextFile){

    $byteInputValue = ascii2hex($contextFile);

    //Connect a  database
    $servername = 'localhost';
    $db = 'cs174';
    $user = 'root';
    $password = '';
    $table = 'DATA';

    //Create connection
    $conn = new mysqli($servername,$user,$password,$db);

    //Check connection
    if($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
    }else{
        $query = "SELECT * FROM $table";
        $result= $conn->query($query);
        if($result){

            readDatabase($result,$byteInputValue,$conn,$table);
        }
        if(!$result){
            die($conn->error);
        }
    }
}

// Read All the data from the database
function readDatabase($result,$byteInputValue,$conn,$table){

    //this will hold the first 20 byte of the data from the file
    $byteInputValue = str_replace(' ', '', $byteInputValue);
    $contextFile20byte = substr($byteInputValue,0,10);

    if($contextFile20byte !== ''){
        $row = $result->num_rows;
        $test = True;

        for($i = 0; $i<$row; $i++){
            $result->data_seek($i);
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $contextdata20byte = substr($row['INPUTDATA'],0,10);
            if(strcmp($contextdata20byte,$contextFile20byte) === 0){
                $test = False;
                echo "This is a virus";
                break;
            }else{
                echo " This file is not exist as a virus";
                break;
            }
        }

    }else{
        echo "The file is not exist";
    }
    $result->close();
}

?>

</body>
</html>