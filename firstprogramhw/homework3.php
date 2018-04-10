<html>

<head>
    <title>HomeWork 3</title>

    <style>

        h3{
            font-size: 50px;
            color: red;
        }

    </style>

</head>

<h3> Homework 3 </h3>

<p>Question: </p>

<p>
    In the hexadecimal number system numbers are represented using 16 different digits:
    0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F
    The hexadecimal number AF when written in the decimal number system equals 10x16+15=175.
</p>

<p>
    In the 3-digit hexadecimal numbers 10A, 1A0, A10, and A01 the digits 0,1 and A are all present.
    Like numbers written in base ten we write hexadecimal numbers without leading zeroes.
</p>
<p>
    Write a PHP program with a function that given a value $n in input counts
    how many different number exist with all of the digits 0,1, and A present at least
    once for hexadecimal values from 1 to $n digits.
    Add comments, checks and test cases in addition to the code.
</p>

<form action="" method="get">
    Input the integer value:<br>
    <br>
    <input type="text" name="inputValue" id="inputValue"><br>
    <br>
    <input type="submit" name="submit" value="Submit">
</form>



<?php


$result = array();
$temporaryarray = array();
$count = 0;


    if( isset($_GET['submit']) )
    {
        $inputValue = htmlentities($_GET['inputValue']);

        $check = is_numeric ($inputValue) ? true : false;

        //print_r($array);
        $v = "01A";
        if($check){
            buildValue($temporaryarray,$inputValue,$v);
        }else{
            echo " Input can be only numberic value. ";
        }
    }

    function buildValue($temporaryarray,$inputValue,$v){

        $originalValue = array("0","1","A");
        $i = 0;


        if($inputValue >= 3) {

            for ($x = 0; $x < $inputValue - 3; $x++) {

                if($i == 2){
                    $i = 0;
                }

                $v .= $originalValue[$i];
                $i++;
            }

            $result = permutations($v,$inputValue);
            check($result);

        }
    }

    function check($result){

        $finalResult = array();
        $finalInteger = array();
        $zero = 0;
        $one = 1;
        $aero = 'A';

        $result = array_unique($result);
        $finalHex = array();
        $finalResult = array();



        foreach ($result as &$value) {

            if( strpos( $value, "0" )&&strpos( $value, "A" )&& strpos($value, "1" ) !== false ) {
                $finalvalue =  getcalculateHexValue($value,$finalHex);
                array_push($finalInteger,$finalvalue);
                array_push($finalResult,$value);
            }

            if( strpos( $value, "0" )&&strpos( $value, "1" )&& strpos($value, "A" ) !== false ) {
                $finalvalue =  getcalculateHexValue($value,$finalHex);
                array_push($finalInteger,$finalvalue);
                array_push($finalResult,$value);
            }
            echo "<pre></pre>";
        }

        //$solution =  array_combine (  $finalResult ,  $finalInteger );
        $max = sizeof($finalResult);
        echo " Total Value  $max";
        echo "<pre>";
        print_r($finalResult);
        echo "</pre>";

    }

    function getcalculateHexValue($value,$finalHex){

        $calculationResult = 0;
        $valueinput = $value;
        $calculationValue = 0;

        //echo " VALUE => $value";
        for($i= 0; $i < strlen($valueinput); $i++){

            if(is_numeric($value[$i])){
                $calculationValue = $calculationValue + (pow(16,2-$i) * $value[$i]);
            }else{
                $calculationValue = $calculationValue + (pow(16,2-$i) * 10);
            }
            //echo "$calculationValue =>    $value[$i]";
        }
        $calculationResult = $calculationValue;
        return $calculationResult;
        //array_push($finalHex,$calculationValue);
    }

    function permutations ($alphabet, $output_length=1)
    {

        $output = array();

        if ($alphabet AND ($output_length > 0)) {

            // Handles both string alphabets and array alphabets
            if (is_string($alphabet)) {
                $alphabet_length = strlen($alphabet);
                $symbol = str_split($alphabet);
            } elseif (is_array($alphabet)) {
                $alphabet_length = count($alphabet);
                $symbol = $alphabet;
            } else {
                return $output;
            }

            if ($alphabet_length < 2) return $output;

            $pointer = array_fill(-1, $output_length + 1, 0);

            $iterations = pow($alphabet_length, $output_length);

            $alphabet_length--;
            $output_length--;

            for ($i = 0; $i < $iterations; $i++) {
                $permutation = "";
                for ($c = 0; $c <= $output_length; $c++) {
                    $permutation .= $symbol[$pointer[$c]];
                }
                $output[] = $permutation;
                $c = $output_length;

                do {
                    $pointer[$c]++;
                    if ($pointer[$c] <= $alphabet_length) {
                        break;
                    } else {
                        $pointer[$c] = 0;
                        $c--;
                    }
                } while (TRUE);
            }
        }

        return $output;
    }

?>
</html>

