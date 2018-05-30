<html>
<head>
	<meta charset="UTF-8">
	<title><?= $title ?></title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<?php
	
		//$user = getUserInformation($_SESSION("eid"));
// 		$user = '{"id":"10101","surname":"Ahsan","firstname":"Chy","employment_mode":1,"review_year":2018,"review_id":10,"job_knowledge":3,"work_quality":4,"initiative":1,"communication":2,
// "dependability":5,"additional_comment":"snfdkjfbkjffdfjdf","goal":"fjkfdjkf","action":"10"}';
// 		$user = json_decode($user);
		//$_SESSION['type'] = "Employee";
		if(isset($_SESSION['surname'])){
		echo "<nav><ul>";
		echo "<li>Server Date : " . date("Y/m/d") . " | </li>";
		echo "<li>User Name : " . $_SESSION['surname']. " " . $_SESSION['firstname'] . " | </li>";
		if($_SESSION["type"] == "Employee")
			echo "<li>User Type : " . $_SESSION["type"] . " | </li>";
		else
			echo "<li>User Type : " . "Superviser" . " | </li>";
		echo '<li><a href="logoff.php"> Log Off</a></li>';
		echo "</ul></nav>";
		}
	
	?>
	
	