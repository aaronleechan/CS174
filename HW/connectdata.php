	<h1> Test Project </h1>

	<!--Connect Database-->
	<?
		$hn = 'localhost';
		$db = 'CS174';
		$un = 'root';
		$pw = '';
		//require_once 'index.php';
		$conn = new mysqli($hn,$un,$pw,$db);
		if($conn->connect_error)die($conn->connect_error);

		//Get the value from Query
		$query = "SELECT * FROM EMPLOYEE";
		$result = $conn->query($query);
		if(!$result) die($conn->error);

		$rows = $result->num_rows;
		for($j = 0; $j<$rows; ++$j){

			$result->data_seek($j);
			$row = $result->fetch_array(MYSQLI_ASSOC);

			echo 'First Name:' .$row['firstname']. '<br>';
			echo 'Second Name:' .$row['lastname']. '<br>';
			echo '<br><br>';
		}

		$result->close();
		$conn->close();
	?>