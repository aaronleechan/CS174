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
    <li style="float:right"><a class="active" href="logout.php" method="post" name="logoutfunction">Admin Log Out</a></li>
</ul>

<header>
    <center>
        <h3>File Detection</h3>
    </center>

</header>

<div class="container">
    <form action="adminscan.php" method="post" enctype="multipart/form-data">
        <h2>Select file to upload:</h2>
        <input type="text" id="vname" name="vname" placeholder="Input Virus Name" required="required"><br>
        <input type="file" name="file" id="fileToUpload" required="required">
        <button type="submit" name="submit" value="upload" onclick="checkstring()">Submit</button>
        <button type="scan" name="scan" value="scan">Scan</button>
    </form>

    <script type="text/javascript">

        function checkstring(){

            var testString = document.getElementById("vname").value;
            var testcharacter = /^[A-Za-z0-9]+?$/;
            var check = testcharacter.test(testString);

            if(!check){
                alert ( "Error Virus Name only can be English letters (capitalized or not) and digits");
            }

        }


    </script>
</div>


<!-- php class -->
<?php



//Start the Program
void_main();

//Declare Variable
// check the session
function void_main(){

    $file_name  = "";   $file_type  = "";   $file_size  = 0;
    require_once 'verify.php';
    verify_session(basename(__FILE__));
    read_file();   //Read File
}

//Read file
function read_file(){
    if((isset($_POST["submit"])) || (isset($_POST["scan"]))) {
        $file_name  = $_FILES['file']['name'];
        $file_type  = $_FILES['file']['type'];
        $file_size  = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
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

//Convert the file to byte--> Reference From https://stackoverflow.com/questions/24575247/convert-from-ascii-to-hex-in-php
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
    $name = $_POST["vname"];

    $checkname = preg_match("/^[A-Za-z0-9]+?$/",$name);


//    echo "TESTTTTT $checkname </br>";
//    if($checkname){
//        echo " IT IS TRUE";
//    }else{
//        echo " IT IS FALSE";
//    }


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
                exit;
            }
        }

        if($checkname){
            echo "File is successfully save in the data</br>";

            if($test && (isset($_POST["submit"]))){
                $query = "INSERT INTO $table(INPUTDATA,NAME)  VALUES('$contextFile20byte','$name')";
                mysqli_query($conn,$query);
            }else{
                echo " This is not found";
            }

        }else{
            echo " Virus Name only can be English letters (capitalized or not) and digits";
        }

    }else{
        echo "The file is Empty";
    }

    $result->close();
}
?>




</body>
</html>