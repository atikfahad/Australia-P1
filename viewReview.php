<?php
session_start();
$title = "View Review";
require('model/model.php');
require('header.php');


$id = $_GET['id'];
if($id != ""){
	$review = getReview($id);
 ?>


<ul>
<li>Employee Id: <?php echo $review['employee_id']; ?></li>
<li>Surname: <?php echo $review['surname']; ?></li>
<li>First Name: <?php echo $review['firstname']; ?></li>
<li>Employment Mode: <?php echo $review['employment_mode']; ?></li>
<li>Review Year: <?php echo $review['review_year']; ?></li>
</ul>

<h2>Ratings:</h2>
<ul>
<li>Job Knowledge: <?php echo $review['job_knowledge']; ?></li>
<li>Work Quality: <?php echo $review['work_quality']; ?></li>
<li>Initiative: <?php echo $review['initiative']; ?></li>
<li>Communication: <?php echo $review['communication']; ?></li>
<li>Dependability: <?php echo $review['dependability']; ?></li>
</ul>


<h2>Evaluation and Action:</h2>
<ul>
<li>Additional Comments: <?php echo $review['additional_comment']; ?></li>
<li>Goals: <?php echo $review['goals']; ?></li>
<li>Action: <?php 
if($review['action']== 'N'){
	echo "No action required";
}
else{
	echo  $review['action']." months untill next review.";
}
?></li>

</ul>



 <?php
}
else{


	session_start();
	$_SESSION["error"] = "You are not Logged in.";
	header("Location: logoff.php");
}
?>


