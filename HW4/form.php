

<!DOCTYPE html>
<html>
<head>
   <title> Homework 4</title>
</head>
<body>

<p>Using PHP, create a web page that contains a form</p>
<p>The form allows the users to <strong>upload a text file with extension .txt</strong> (no other extensions are allowed).</p>
<p>The <strong>application then searches in the text file for all the numbers and print them directly on the web page.</strong></p>

<p>Example:</p>
<p>If the file contains: <strong>"Hello,I told you 8 times how to close all the 4 doors. You still left 1 open!"</strong></p>
<p>It should print in output: <strong>8 4 1</strong></p>
<p>Note: Numbers are never part of a word, that is, words like "b4, 2u, johnny78" </p>
<p>are not present in the file. And even if they were,</p>
<p>the number would still be considered just as a letter and part of the word. </p>

<hr/>

<form action="form.php" method="post" enctype="multipart/form-data">
    Upload a file:
    <p></p>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="ns" name="submit">
</form>


<?php

$target_dir = "";
$resultArray = array();
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Check if image file is a actual image or fake image
checkFile($fileType,$target_file);

echo "<hr/>";

// Check the file type
function checkFile($file,$target_file){

    if(isset($_POST["submit"])) {
        if($file === "txt"){
            fileReader($target_file);
        }
        else{
            echo "File is not txt file";
        }
    }
}

// Read File
function fileReader($target_file){
    $contextFile = file_get_contents($_FILES['fileToUpload']['tmp_name']);
    echo "<hr/>";
    findtheNumber($contextFile);
}

// Find the number from the file
function findtheNumber($contextFile){
    
    $text = explode(" ",$contextFile);
    foreach($text as $word){

        // Final Solution
        if(is_numeric($word)){
            echo "$word  <br />";
            //resultArray.push($word);
        }
    }
}

?>

</body>
</html>
