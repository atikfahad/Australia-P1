<?php 

session_start();
$title = "Finalize Review";
    require('model/model.php');
    require('header.php');

$id = $_GET['id'];
if($_SESSION['type'] != "Employee")
	$type = "supervisor";
else
	$type = "employee";
if($id){
	$query = "SELECT * FROM employee inner join review on employee.employee_id=review.employee_id having review_id='$id'";
    $result = mysqli_query($conn,$query);
	$review = mysqli_fetch_assoc($result);

	//$query2 = "SELECT * FROM employee inner join job on employee.job_id=job.job_id having ";
	$query2 = "SELECT job_title FROM job where job_id='".$review['job_id'] ."'";
	$result2 = mysqli_query($conn,$query2);
	$review2 = mysqli_fetch_assoc($result2);

	$query3 = "SELECT department_name FROM department where department_id='".$review['department_id'] ."'";
	$result3 = mysqli_query($conn,$query3);
	$review3 = mysqli_fetch_assoc($result3);


	//$roomInfo = json_decode($review);
 ?>
 <form method="post">
 	<div>
 		<h2>Employee Informations</h2>
 		<label> Employee ID     :  <?php echo $review['employee_id']; ?></label><br>
 		<label> Family Name     :  <?php echo $review['surname']; ?></label><br>
 		<label> Given Name      :  <?php echo $review['firstname']; ?></label><br>
 		<label> Job Title       :  <?php echo $review2['job_title']; ?></label><br>
 		<label> Employment mode :  <?php echo $review['employment_mode']; ?></label><br>
 		<label> Department Name :  <?php echo $review3['department_name']; ?></label><br>
 		<label> Review Year     :  <?php echo $review['review_year']; ?></label>
 	</div>
 	 	<div>
 		<h2>Ratings</h2>
 		<label> Job Knowledge   :  </label>
 		<?php if($type == "supervisor"){
 				
 		echo '<input type="text" name="JobKnowledge" id="JobKnowledge" onkeypress="validationRating(JobKnowledge)">';
 		} 
 		else{
 			echo  $review['job_knowledge'];
 		}
 		?>
 		
 		<br>
 		<label> Job Quality     :  </label>
 		<?php if($type == "supervisor"){
 			
 		echo '<input type="text" name="JobQuality" id="JobQuality" onkeypress="validationRating';
 		echo "('JobQuality')";
 		echo '>;';
 		} 
 		else{
 			echo  $review['work_quality'];
 		}
 		?>
 		<br>
 		<label> Initiative      :  </label>
 		<?php if($type == "supervisor"){
 			
 		echo '<input type="text" name="Initiative" id="Initiative" onkeypress="validationRating("Initiative")">';
 		} 
 		else{
 			echo  $review['initiative'];
 		}
 		?>
 		<br>
 		<label> Communication   :  </label>
 		<?php if($type == "supervisor"){
 			
 			
 		echo '<input type="text" name="Communication" id="Communication" onkeypress="validationRating("Communication")">';
 		} 
 		else{
 			echo  $review['communication'];
 		}
 		?>
 		<br>
 		<label> Dependability   :  </label>
 		<?php if($type == "supervisor"){
 			
 		echo '<input type="text" name="Dependability" id="Dependability" onkeypress="validationRating("Dependability")">';
 		} 
 		else{
 			echo  $review['dependability'];
 		}
 		?>
 		<div>
 		<span id="showRatErr"></span>
 		</div>
 	</div>
 	
 	<?php if($type == "supervisor"){
 		echo '
 		<div>
 		<h2>Evaluation and Action</h2> 
 		<label> Additioonal Comments   :  </label><br><textarea rows="3" cols="80"></textarea><br>
 		<label> Goals for the Employee :  </label><br><textarea rows="3" cols="80"></textarea><br>
 		<label> Action Required        :  </label><input type="text" name="actionRq" id="actionRq"><br><br>
 	</div>
 	'; }
 	?>

 	<div><?php if($type == "supervisor"){
 		echo '<label>   </label> <input type="submit" id="finalSubmit" name="finalSubmit" value="Submit" onclick="return validationFinal()">
 		<label> </label> <input type="submit" id="finalSave" name="finalSave" value="Save" onclick="return validationSave()">'; } 
 		else{
 			$adcmnt =  $review['additional_comment'];
 			$goal =  $review['goals'];
 			$act =  $review['action'];
 			echo "<div><p>'$adcmnt'</p><p>$goal</p>$act<br></div>";
 			echo '<div><p>Thank you for taking part in your Performance Review. This review is an important aspect
of the development of our organisation and its profits and of you as a valued employee.
By electronically signing this form, you confirm that you have discussed this review in
detail with your supervisor. The fine print: Signing this form does not necessarily indicate that you agree
with this evaluation. If you do not agree with this evaluation please feel free to find another job outside of Wayne
Enterprisesä.</p>';
			echo '<input type="checkbox" name="agree"><label>Agree with Term & Conditions</label></div>';
 			echo '<label>   </label> <input type="submit" id="accept" name="accept" value="Accept" onclick="">';
 		}
 			?>
 	</div>
 </form>
 <?php } ?>