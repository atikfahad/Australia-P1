<?php
$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
if ($conn->connect_error) {
	exit("Failed to connect to database " . $conn->connect_error);
}
function getEmployee($employee_id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	$sql = "SELECT employee_id, surname, firstname from employee where employee_id = '". $employee_id."';";
	//$result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	$result = mysqli_query($conn,$sql);
	$temp= mysqli_fetch_assoc($result);
	return $temp;
 //    if(count($temp) > 0){
 //    	return json_encode($temp);
 //    }
	// // while($row = mysqli_fetch_assoc($result)) {
	// // 	$arr[]=$row;
	// // }
	// //echo json_encode($arr);
	// else
	// 	return ;
}

function getInfoMain($id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	//$employee = json_decode(getEmployee($id));
	$employee = getEmployee($id);
	//echo $employee;
	$sql = "SELECT supervisor_id from employee;";
	$isSupervisor = '';
	$result = mysqli_query($conn,$sql);
	$arr=array();
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	//$superviserList = json_decode($arr);
	$superviserList = $arr;
	//echo $superviserList;
	foreach ($superviserList as $key => $value) {
		if($employee['employee_id'] == $value['supervisor_id']){
			$isSupervisor = $value['supervisor_id'];
		}
	}
	//session_start();
	$_SESSION['eid'] = $employee['employee_id'];
	$_SESSION['surname'] = $employee['surname'];
	$_SESSION['firstname'] = $employee['firstname'];
	if($isSupervisor != '')
		$_SESSION['type'] = $isSupervisor;
	else
		$_SESSION['type'] = "Employee";
	return true;
}
function chooseReview($id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	$sql = "SELECT * FROM review where employee_id = '". $id. "' order by review_year desc";
	//$result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	$arr = array();
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	return json_encode($arr);
}

function chooseReviewSuper($id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	//$sql = "SELECT * FROM employee inner join review on employee.employee_id = review.employee_id where review.supervisor_id = '".$id."';";
	$sql = "SELECT * FROM employee inner join review on employee.employee_id = review.employee_id having review.supervisor_id = '".$id."';";
	//$result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	$arr = array();
	$result = mysqli_query($conn,$sql);
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	return json_encode($arr);
}

function getDeptName($id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	$sql = "SELECT department_name from department where department_id='".$id."'";
	$result = mysqli_query($conn,$sql);
	$temp= mysqli_fetch_assoc($result);
	return $temp['department_name'];

}

function getReview($id){
	$conn = new mysqli("localhost", "twa045", "twa045gh", "performancereview045"); 
	if ($conn->connect_error) {
		exit("Failed to connect to database " . $conn->connect_error);
	}
	//$sql = "SELECT * FROM employee inner join review on employee.employee_id = review.employee_id where review.supervisor_id = '".$id."';";
	$sql = "SELECT * FROM employee inner join review on employee.employee_id = review.employee_id having review.review_id = '".$id."';";
	//$result = mysqli_query($conn, $sql)or die(mysqli_error($conn));
	$arr = array();
	$result = mysqli_query($conn,$sql);
	// while($row = mysqli_fetch_assoc($result)) {
	// 	$arr[]=$row;
	// }
	// return json_encode($arr);
	$row = mysqli_fetch_assoc($result);
	return $row;

}

function updateDB($sql){
	$conn = mysqli_connect("localhost", "root", "", "wbd");
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	if(mysqli_query($conn, $sql)) {
		echo "Updated";
	}
	else{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

function getJSONFromDB($sql){
	$conn = mysqli_connect("localhost", "root", "","wbd");
	//echo $sql;
	$result = mysqli_query($conn, $sql)or die(mysqli_error($$conn));
	$arr=array();
	//print_r($result);
	while($row = mysqli_fetch_assoc($result)) {
		$arr[]=$row;
	}
	return json_encode($arr);
}
function deleteDB($sql){
// Create connection
$conn = mysqli_connect("localhost", "root", "","wbd");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to delete a record
//$sql = "DELETE FROM MyGuests WHERE id=3";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
}
?>