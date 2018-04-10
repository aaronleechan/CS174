<html>

<head>
    <title>HomeWork 2</title>

    <style>

        h3{
            font-size: 50px;
            color: red;
        }

    </style>

</head>

<h3> Homework 2 </h3>

<p>Question: </p>

<p>
    Write a PHP function that given an integer value n in input, returns the index of the first term in the Fibonacci sequence to contain n digits.
</p>

<form action="" method="get">
    Input the integer value:<br>
    <br>
    <input type="text" name="inputValue" id="inputValue"><br>
    <br>
    <input type="submit" name="submit" value="Submit">
</form>



    <?php

    if( isset($_GET['submit']) )
    {
        $inputValue = htmlentities($_GET['inputValue']);
        $count = 1;
        $res = 1;

        if($inputValue > 1) {

            $check = (pow(10,$inputValue-1));

            while($res < $check) {
                $res = fibonacci($count);
                $count++;
            }
        }
        if( $count > 1)
        $res = $count-1;
        echo "<h3>Answer is: $res</h3>";
    }

    function fibonacci($n)
    {
        return round(pow((sqrt(5)+1)/2, $n) / sqrt(5));
    }

    ?>


</html>

