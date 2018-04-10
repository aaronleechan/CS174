<!--
	Filename: Homework_4_Leong_Alec_010301928.php

	Name: Alec Leong
	ID: 010301928
	Course: CS 174
	Sec: 02
	Instructor: Fabio Di Troia
	Term: Fall 2017
	Date: 10/15/2017
	Assignment: Homework 4
	Description: Create a web page that contains a form. 
	             The form allows the users to upload a text file with extension .txt (no other extensions are allowed).
	             The application then searches in the text file for all the numbers and print them directly on the web page.
-->

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<center>
	<form action="alec.php" method="post" enctype="multipart/form-data">
		<br>Option 1: File Submission<br><br>
		<input name="textfile" type="file" required=""/>
		<button type="submit">Submit File</button><br><br>
		<font color=red>File Restrictions: </font> 1) plain text file 2) file size <= 2MB AND file size within PHP configuration file size setting<br><br>
	</form>

	<form action="alec.php" method="post">
		<br>Option 2: Textbox for Testing Purposes<br><br>
		<textarea name="texttest" method="post" rows="4" cols="50" name="comment" placeholder="Enter text here..."></textarea><br>
		<button type="submit">Submit Test</button><br><br>
		<font color=red>Special/Failed Case: </font> a numeric decimal value followed a period<br><br>
</center>
		<font color=green>Test Me #1: </font>Hello,I told you 8 times how to close all the 4 doors. You still left 1 open!<font color=green> Correct Output: </font>8 4 1<br>
		<font color=green>Test Me #2: </font>If Hamsik17 scores another goal, he will reach Maradona10 with 116 total scores in Napoli<font color=green> Correct Output: </font>116<br><br>
	</form>
</html>

<!-- PHP -->
<?php
	void_main(); // call main

	// main method
	function void_main() {
		// Option 1: File Submission
		if (isset($_FILES['textfile']['name']) && isset($_FILES['textfile']['size'])
			&& !empty($_FILES['textfile']['name']) && !empty($_FILES['textfile']['size'])) {

			// test file type
			switch($_FILES['textfile']['type']) {
				case 'text/plain':
					break;
				default:
					echo '<script> alert("Invalid file type."); window.location = "alec.php"; </script>';
			}

			// test file error
			switch ($_FILES['textfile']['error']) {
				case UPLOAD_ERR_OK: // there is no error, the file uploaded with success
		    		break;
		        case UPLOAD_ERR_INI_SIZE:
		            echo '<script> alert("The uploaded file exceeds the upload_max_filesize directive in php.ini."); window.location = "alec.php"; </script>';
		        case UPLOAD_ERR_PARTIAL:
		            echo '<script> alert("The uploaded file was only partially uploaded."); window.location = "alec.php"; </script>';
		        case UPLOAD_ERR_NO_FILE:
		            echo '<script> alert("No file was uploaded."); window.location = "alec.php"; </script>';
		        default:
		            echo '<script> alert("Unknown file error."); window.location = "alec.php"; </script>';
		    }

		   	// test file size 
			if(!is_valid_file_size($_FILES['textfile']['size'])) { // check file size in bytes
				echo '<script> alert("File size exceeds 2MB."); window.location = "alec.php"; </script>';
			}

			// process file
			$file = $_FILES['textfile']['name'];
			$file_path = $_FILES['textfile']['tmp_name'];
			echo " AARON>>>>>>>>>>>>>>>>>>>>> $file + $file_path";
			move_uploaded_file($_FILES['textfile']['tmp_name'], $file);
			process_file($file);

		}

		// Option 2: Textbox Submission
		if(isset($_POST["texttest"]) && !empty($_POST["texttest"])) {
			$lines = explode("\n", $_POST["texttest"]);
			print_results($lines); 
		}

		// test cases
		test_cases(); 
	}

	/**
	 * This method checks a few test cases
	 */

	function test_cases() {
		echo '<font color="red">Test Cases:</font><br><br>';
		$str1 = "Hello,I told you 8 times how to close all the 4 doors. You still left 1 open!"; 
		$test1 = explode("\n", $str1);
		print_results($test1);

		$str2 = "If Hamsik17 scores another goal, he will reach Maradona10 with 116 total scores in Napoli"; 
		$test2 = explode("\n", $str2);
		print_results($test2);

		$str3 = "b4, 2u, johnny78"; 
		$test3 = explode("\n", $str3);
		print_results($test3);

		$str4 = $str1 . "\n" . $str2 . "\n" . $str3; 
		$test4 = explode("\n", $str4);
		print_results($test4);
	}

	/**
	 * This method checks if the file size is valid as set by the programmer of size 2MB. 
	 * @param int $size the file size in bytes
	 * @return true if file size is valid, else false
	 */

	function is_valid_file_size($size) {
		if ($size <= 2e+6) return true; 
		else return false; 
	}

	/**
	 * This method processes the file 
	 * @param string $file name of the file
	 */

	function process_file($file) {
		if(fopen($file, 'r')) {
			$user_text = file_get_contents($file);
			$lines = explode("\n", $user_text);
			print_results($lines); 

		}
		else {
			echo '<script> alert("Could not open file"); window.location = "alec.php"; </script>';
		}

	}

	/**
	 * This method prints the results.
	 * Special Case: if there is no numerical value in the text, then print "No results found."
	 * @param string $array is an array of lines the text file. 
	 */

	function print_results($array) {
		echo '<font color="blue">Text: </font><br><br>';

		for ($k = 0; $k < sizeof($array); $k++)
			echo $array[$k] . "<br>";
		echo "<br>";

		echo '<font color="blue">Output: </font><br><br>';

		$flag = false; // flag variable to test if numerical value exists
		
		for ($i = 0; $i < sizeof($array); $i++) {
			$words = explode(" ", $array[$i]);

			for ($j = 0; $j < sizeof($words); $j++) {
				$var = trim($words[$j]); 
				if(is_numeric($var)) {
					$flag = true; 
					echo $var . ' '; 
				}
			}

		}
		echo "<br><br>";  

		if (!$flag) // if there is no numerical value
			echo "No results found. <br>"; 

		echo "<br>"; 
	}

?>