<?php //test1.php
	$username = "Donald Duck";
	echo $username;
	echo "<br>";
	$current_user = $username;
	echo $current_user;
	
	$team = array('Bill', 'Mary', 'Mike', 'Chris', 'Anne');

	$twoarray = array(

		array("A", "10"),
		array("B", "20"),
		array("C", "30"),
		array("D", "40"),
		array("E", "50")

		);

	for($i = 0; $i < sizeof($team)-1; $i++){
		echo $team[$i];
		echo "<br>";
	}

// The different of '' and "";

	$info = 'Preface variables with a $ like this: $variable';
	echo $info;

	echo "<br>";

	$count = 10;

	echo "This week $count people have viewed your profile";


	$author = "brain";
	echo <<<_END
		Type everything what we want and end with.

_END;	
?>