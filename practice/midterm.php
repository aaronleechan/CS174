<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="jumbotron text-center">
    <h1>Practice</h1>
</div>

<div class="container">

    <h5> Remember substr( $string, (start Index) , (length of string) )</h5>
    <?php
        $number = 12345 * 67890;
        $string = "My name is Aaron";
        echo "$number <br />";
        echo " substr($number, 5,3) <br />";
        echo substr($number, 5,3);
        echo "<br /><br/>";

        echo "$string <br />";
        echo "substr( $string,11,5 ) <br />";
        echo substr($string,11,5);
    ?>
    <hr/>

    <?php
    echo "This is line ".__LINE__. " of file " .__FILE__;
    echo "<br/>";
    $b ?print"TRUE": print"FALSE";
    echo "<br/>";
    ?>
    <hr />

    <?php
    echo " This is time() function";
    echo "<br />";
    echo time();
    //time_machine(0);
    function time_machine($a){
        echo time()+ $a;
    }
    echo "<hr/>";
    ?>

    <?php
    echo longdate(time());
    function longdate($timestamp)
    {
        $temp = date("l F jS Y", $timestamp);
        return "The date is $temp";
    }
    ?>
    <hr/>

    <?php
    $x = -3;
    $y = 3 * (abs(2*$x)+4);
    echo " This is result:  $y";
    echo " <br/>";
    ?>

    <?php
    $fuel = 5;
    echo $fuel <= 1 ? "Fill tank now": "No enough";
    ?>
    <hr/>

    <?php
    $count = 1;
    while($count < 12){
        echo " This is testing $count";

        if($count === 5)
            echo " This is count ==>  $count";
        $count++;
        echo "<br/>";
    }
    ?>
    <hr/>

    <?php

    echo " <h3> This is i value </h3>";

    for($i = 0; $i < 10; $i++)
    {
        echo "This is i ===  $i";
        echo "<br/>";
    }

    echo " <hr/>";

    echo " <h3> This is j value </h3>";

    for($j = 0; $j < 10; ++$j)
    {
        echo "This is j === $j";
        echo "<br/>";
    }
    ?>

    <hr/>


    <?php
    $value = '10e^5';
    $intvalue = (int)$value;
    $flvalue  = (float)$value;

    echo "Testing: $intvalue <br/>";
    echo "Testing: $flvalue  <br/>";
    ?>
    <hr/>
    <?php
    $article = "This is Testing Article";
    echo " Original ==> $article <br/>";

    echo " Reverse <br/>";
    $reverseArticle = strrev($article);
    echo " Reverse ==> $reverseArticle <br/>" ;

    echo " Upper <br/>";
    $upperArticle = strtoupper($article);
    echo " Upper ==> $upperArticle <br/>";

    echo " Lower <br/>";
    $lowerArticle = strtolower($article);
    echo " Lower ==> $lowerArticle <br/>";

    echo " First Article <br/>";
    $ucFirst = ucfirst($lowerArticle);
    echo " uc First ==> $ucFirst <br/>";

    ?>

    <?php
    echo " Explode <br/>";
    $temp = explode(' ',"This is a testing article");
    print_r($temp);
    echo "<br/>";
    echo ' Number <br/>';
    $checkNumber = "12,23,4,5,1,2,0,5";
    $tempNumber = explode(',',$checkNumber);
    print_r($tempNumber);
    echo " <br />";
    sort($tempNumber);
    print_r($tempNumber);

    ?>
    <hr/>

    <?php
    $firstName = "Aaron";
    $lastName = " Chan";
    $combineStringtoArray = compact('firstName', 'lastName');
    print_r($combineStringtoArray);

    ?>
    <hr/>

    <?php
    $j = 23;
    $temp = "Hello";
    $address = "1 Old Street";
    $age = 61;

    print_r(compact(explode(' ', 'j temp address age')));
    ?>
    <hr/>
    <?php
    if(file_exists("file.txt"))
        $fileRead = fopen('file.txt','r') or die("File is not exist");

    $line = fgets($fileRead);
    echo "::: $line ";
    echo " <br />";
    $value = file_get_contents('file.txt');
    echo $value;

    fclose($fileRead);


    ?>




</div>

</body>
</html>
