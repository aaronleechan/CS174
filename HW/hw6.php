<!DOCTYPE html>
<html>
<head>
    <title>HW 6</title>
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

</style>

<body>
<!-- Title of the Final Project -->
<header>
    <center>
        <h3>File Detection</h3>
    </center>

</header>

<div class="container">
    <form action="hw6.php" method="post" enctype="multipart/form-data">
        <h2>Select file to upload:</h2>
        <input type="file" name="file" id="fileToUpload">
        <button type="submit" name="submit" value="upload">Submit</button>
    </form>
</div>


<!-- php class -->
<?php

//Start the Program
void_main();

function void_main(){
    //Declare Variable
    $file_name  = "";   $file_type  = "";   $file_size  = 0;
    read_file();   //Read File
}

//Read file
function read_file(){
    if(isset($_POST["submit"])) {
        $file_name  = $_FILES['file']['name'];
        $file_type  = $_FILES['file']['type'];
        $file_size  = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        check_file($file_name, $file_type, $file_size);     //Check the file
    }
}

// Take the content of the file
// Check the file only txt available
function check_file($file_name,$file_type,$file_size){

    if( ($file_type === 'text/plain') )
    {
        $contextFile = file_get_contents($_FILES['file']['tmp_name']);
        connectDatabase($contextFile);
    }
    else{
        echo " Only txt File is available";
        exit();
    }
}

//Seprate the string get database and table name
// Connect the database
// Check Connection, Create Table if not exist in the Database
// Insert the data into database
function connectDatabase($contextFile){

    $readString = explode("\n", $contextFile);

    $databaseName = $readString[0];         // Database Name
    $tableName = $readString[1];            // Table name


    $key = array_search('---', $readString);   // find the index of ---
    $fieldcolumn = $key - 2;                          // Find the how many column need to create

    //Connect a  database
    $servername = 'localhost';
    $db = $databaseName;
    $user = 'root';
    $password = '';
    $table = 'collectiondata';

    //Create connection
    $conn = new mysqli($servername,$user,$password,$db);

    //Check connection
    if($conn->connect_error){
        die("Connection Failed: " . $conn->connect_error);
        exit();
    }else{
        // Database Exist, Check Table Add new table

        echo "Connect Database Successfully<br/>";

        $query = "SELECT * FROM $tableName";
        $result= $conn->query($query);
        if($result){
            echo "TABLE EXIST<br/>";
        }
        else if(!$result){
            echo "TABLE DOES NOT EXIST <br/>";

            $sql = "CREATE TABLE $tableName (";
                for($k = 0; $k < $fieldcolumn; $k++){
                       $sql .= "column$k VARCHAR(128),";
                };
                $sql .= "ID int AUTO_INCREMENT PRIMARY KEY";
                $sql .=")";


            if(mysqli_query($conn, $sql)){
                echo "Table created successfully.<br/>";
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                exit();
            }
        }
        $readStringLength = sizeof($readString);
        $resultString = array();

        //Insert the data into database
        // If the data is duplicated, it will overwrite the existing database.
        for($i = 0; $i<$readStringLength; $i++){

            if(
                ($readString[$i] != "---")         &&
                ($readString[$i] != $databaseName) &&
                ($readString[$i] != $tableName)    &&
                ($readString[$i] != '')
              )
            {
                array_push($resultString,$readString[$i]);
                $arraySIZEVALUE = sizeof($resultString);


                if($arraySIZEVALUE == $fieldcolumn){

                    $query = "INSERT INTO $tableName(";

                    for($z = 0; $z < $arraySIZEVALUE; $z++){
                        if($z == $arraySIZEVALUE-1){
                            $query .= "column$z) ";
                        }else{
                            $query .= "column$z,";
                        }

                    }

                    $query .=" SELECT * FROM ( SELECT ";

                    for($y = 0; $y < $arraySIZEVALUE; $y++){
                        if($y == $arraySIZEVALUE-1){
                            $query .= "'$resultString[$y]')";
                        }else{
                            $query .= "'$resultString[$y]',";
                        }

                    }

                    $query .= "AS tmp WHERE NOT EXISTS ( SELECT ";

                    for($z = 0; $z < $arraySIZEVALUE; $z++){
                        if($z == $arraySIZEVALUE-1){
                            $query .= "column$z  ";
                        }else{
                            $query .= "column$z, ";
                        }

                    }

                    $query .= "FROM $tableName WHERE ";

                    for($y = 0; $y < $arraySIZEVALUE; $y++){
                        if($y == $arraySIZEVALUE-1){
                            $query .= "column$y= '$resultString[$y]')";
                        }else{
                            $query .= "column$y= '$resultString[$y]' AND ";
                        }

                    }

                    $query .="LIMIT 1";


                    if(mysqli_query($conn, $query)){
                        echo "INSERT DATA successfully. <br/>";
                    } else{
                        echo "ERROR: Could not INSERT to execute $query. " . mysqli_error($conn);
                        exit();
                    }

                    unset($resultString);
                    $resultString = array();
                }

            }

        }
    }
    $conn->close();

}
?>
</body>
</html>