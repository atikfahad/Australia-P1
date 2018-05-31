
<?php 

session_start();

$title = "Finalize Review";
require('model/model.php');
require('header.php');
if(!isset($_SESSION['eid'])) {
	echo "<script>window.location='logoff.php'</script>";
}
$id = $_GET['id'];
if($_SESSION['type'] != "Employee")
	$type = "supervisor";
else
	$type = "employee";
if($id){
	$query = "SELECT * FROM employee inner join review on employee.employee_id=review.employee_id having review_id='$id'";
	$result = mysqli_query($conn,$query);
	$review = mysqli_fetch_assoc($result);

	if (isset($review['accepted']) != NULL) {
		echo "<script>window.location='viewReview.php?id=". $_SESSION['eid']."'</script>";
	}

	if (isset($review['date_accepted']) != NULL) {
		echo "<script>window.location='viewReview.php?id=". $_SESSION['eid']."'</script>";
	}

	//$query2 = "SELECT * FROM employee inner join job on employee.job_id=job.job_id having ";
	$query2 = "SELECT job_title FROM job where job_id='".$review['job_id'] ."'";
	$result2 = mysqli_query($conn,$query2);
	$review2 = mysqli_fetch_assoc($result2);

	$query3 = "SELECT department_name FROM department where department_id='".$review['department_id'] ."'";
	$result3 = mysqli_query($conn,$query3);
	$review3 = mysqli_fetch_assoc($result3);
	if(isset($_POST['finalSave'])){
		$jk = $wq = $in = $cm = $dp = NULL;
		if ($_POST['JobKnowledge'] != 0) {
			$jk = $_POST['JobKnowledge'];
		}
		if ($_POST['JobQuality'] != 0) {
			$wq = $_POST['JobQuality'];
		}
		if ($_POST['Initiative'] != 0) {
			$in= $_POST['Initiative'];
		}
		if ($_POST['Communication'] != 0) {
			$cm = $_POST['Communication'];
		}
		if ($_POST['Dependability'] != 0) {
			$dp = $_POST['Dependability'];
		}
		$q = "UPDATE review SET 'job_knowledge' = '$jk', 'work_quality' = '$wq', 'initiative' = '$in', 'communication' = '$cm', 'dependability' = '$dp', 'additional_comment' = ".$_POST['Additional_comment'].", 'goals' = ".$_POST['GoalsE'].", 'action' = ".$_POST['actionRq'];
		$r = mysqli_query($conn,$q);
	}
	if(isset($_POST['finalSubmit'])){
		$date2 = date("Y/m/d");
		$jk2 = $wq2 = $in2 = $cm2 = $dp2 = NULL;
		if ($_POST['JobKnowledge'] != 0) {
			$jk2 = $_POST['JobKnowledge'];
		}
		if ($_POST['JobQuality'] != 0) {
			$wq2 = $_POST['JobQuality'];
		}
		if ($_POST['Initiative'] != 0) {
			$in2 = $_POST['Initiative'];
		}
		if ($_POST['Communication'] != 0) {
			$cm2 = $_POST['Communication'];
		}
		if ($_POST['Dependability'] != 0) {
			$dp2 = $_POST['Dependability'];
		}
		$q1 = "UPDATE review SET 'job_knowledge' = '$jk2', 'work_quality' = '$wq2', 'initiative' = '$in2', 'communication' = '$cm2', 'dependability' = '$dp2', 'additional_comment'= ".$_POST['Additional_comment'].", 'goals' = ".$_POST['GoalsE'].", 'action' = ".$_POST['actionRq'].", 'completed' = 'Y', 'date_completed' = '$date2' ";
		$r1 = mysqli_query($conn,$q1);
	}
	if(isset($_POST['accept'])){
		$date = date("Y/m/d");
		$qryA = "UPDATE review SET date_accepted= ".$date. ", accepted= 'Y' ";
		$resultA = mysqli_query($conn,$qryA);
	}
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

				echo '<input type="text" name="JobKnowledge" id="JobKnowledge">';
			} 
			else{
				echo  $review['job_knowledge'];
			}
			?>

			<br>
			<label> Job Quality     :  </label>
			<?php if($type == "supervisor"){

				echo '<input type="text" name="JobQuality" id="JobQuality">';
			} 
			else{
				echo  $review['work_quality'];
			}
			?>
			<br>
			<label> Initiative      :  </label>
			<?php if($type == "supervisor"){

				echo '<input type="text" name="Initiative" id="Initiative">';
			} 
			else{
				echo  $review['initiative'];
			}
			?>
			<br>
			<label> Communication   :  </label>
			<?php if($type == "supervisor"){


				echo '<input type="text" name="Communication" id="Communication">';
			} 
			else{
				echo  $review['communication'];
			}
			?>
			<br>
			<label> Dependability   :  </label>
			<?php if($type == "supervisor"){

				echo '<input type="text" name="Dependability" id="Dependability">';
			} 
			else{
				echo  $review['dependability'];
			}
			?>
		</div>

		<?php if($type == "supervisor"){
			echo '
			<div>
			<h2>Evaluation and Action</h2> 
			<label> Additioonal Comments   :  </label><br><textarea rows="3" cols="80" id="Additional_comment" name="Additional_comment"></textarea><br>
			<label> Goals for the Employee :  </label><br><textarea rows="3" cols="80" id="GoalsE" name="GoalsE"></textarea><br>
			<label> Action Required        :  </label><input type="text" name="actionRq" id="actionRq" maxlength="2" required><br><br>
			</div>
			'; }
			?>
			<div>
				<span id="showRatErr"></span>
			</div>
			<div><?php if($type == "supervisor"){
				echo '<label>   </label> <input type="submit" id="finalSubmit" name="finalSubmit" value="Submit" onclick="return validationFinal()">
				<label> </label> <input type="button" name="finalSave" id="finalSave" value="Save" onclick="return validationSave()"></a>'; } 
				else{
					$adcmnt =  $review['additional_comment'];
					$goal =  $review['goals'];
					$act =  $review['action'];
					echo "<div>
					<label> Additioonal Comments   :  </label><p>'$adcmnt'</p>
					<label> Goals for the Employee :  </label><p>$goal</p>
					<label> Action Required        :  </label>$act<br>
					</div>";
					echo '<div><p>Thank you for taking part in your Performance Review. This review is an important aspect
					of the development of our organisation and its profits and of you as a valued employee.
					By electronically signing this form, you confirm that you have discussed this review in
					detail with your supervisor. The fine print: Signing this form does not necessarily indicate that you agree
					with this evaluation. If you do not agree with this evaluation please feel free to find another job outside of Wayne
					Enterprisesä.</p>';
					echo '<div>
				<span id="showRatErr2"></span>
			</div>';
					echo '<input type="checkbox" id ="agree" name="agree"><label>Agree with Term & Conditions</label></div>';
					echo '<label>   </label> <input type="submit" id="accept" name="accept" value="Accept" onclick="return validationAccept()">';
				}
				?>
			</div>

		</form>
		<script type="text/javascript">
			function validationSave() {
		//alert("some");
		var v1 = Number(document.getElementById("JobKnowledge").value);
		var v2 = Number(document.getElementById("JobQuality").value);
		var v3 = Number(document.getElementById("Initiative").value);
		var v4 = Number(document.getElementById("Communication").value);
		var v5 = Number(document.getElementById("Dependability").value);

		if (v1<0 || v1>5 || v2<0 || v2>5 || v3<0 || v3>5 || v4<0 || v4>5 || v5<0 || v5>5 ) {
			document.getElementById("showRatErr").innerHTML = "The Rating Value Must Be Between 1 to 5 !";
			return false;
		}
		else{
			var regex1 = /^[a-zA-Z0-9 "!?.-]+$/;
			var val = String(document.getElementById("actionRq").value);
			var chk = regex1.test(val);	
			if(!chk)
			{
				document.getElementById("showRatErr").innerHTML = " Goals may only contain alphanumeric, characters, spaces, hyphens, commas, period and exclamation marks !";
				return false;
			}	
			else{
				var actn = Number(document.getElementById("actionRq").value);
				var acts = String(document.getElementById("actionRq").value);
				var chk2 = /N?/.test(acts);	
				if(actn!= 0){
					if (actn<1 || actn>18 || chk2) {
						document.getElementById("showRatErr").innerHTML = "The Action Value Must Be Between 1 to 18 or N !";
						return false;
					}

				}

			}

			document.getElementById("showRatErr").innerHTML = "";
			return true;
		}
	}



function validationFinal(){
	return validationSave();
}
function validationAccept() {
	var b1 = document.getElementById('agree').checked;
	if (!b1){
		document.getElementById("showRatErr2").innerHTML = "You Have To Read The Terms & Condition and Agree !";
		return false;
	}
	return true;
}
</script>
<?php } ?>