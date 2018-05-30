<?php
    //session_start();
    session_start();
    $title = "Choose Review";
    require('model/model.php');
    require('header.php');
    $someJSON = chooseReview($_SESSION['eid']);
//review_id,review_year,date_completed
 // $someJSON = '[{"review_id":"123","review_year":2018,"date_completed":"11.22.18"},
 // {"review_id":"1213","review_year":2018,"date_completed":"11.22.18"},
 // {"review_id":"12123","review_year":2018,"date_completed":"11.22.18"}]';

  $someArray = json_decode($someJSON, true);
  if($_SESSION['type'] == "Employee")
      $supervisor = 0;
  else
    $supervisor = 1;
 ?>
 <h2>Your Current Reviews:</h2>
 <ol>
 <?php
foreach ($someArray as $key => $value) {
    $sen = "Review ID: ".$value["review_id"];
    if($value['completed'] == "Y")
      $link="'viewReview.php?id=".$value["review_id"]."'";
    else
      $link="'finaliseReview.php?id=".$value["review_id"]."'";
    $year = $value["review_year"];
    ?>   
      <li> <?php echo $sen.'<br>';  ?>
      Review Year:  
      <a href=<?php echo $link; ?>><?php echo $year?></a>
      </li>
   <?php   
  }
?>
</ol>

<?php

if($supervisor == 1){
  $some = chooseReviewSuper($_SESSION['type']);
  $sup = json_decode($some, true);

?>
  
 <h2>Department: <?= getDeptName($sup[0]['department_id']) ?></h2>
 <ol>
 <?php
foreach ($sup as $key => $value) {
  $name = "Surname: ".$value["surname"] .  "\t" ."Firstname: " . $value["firstname"];
  $year = $value["review_year"];
  $det  = "Review ID: ".$value["review_id"]."<br>"." Employee ID: ".$value["employee_id"]."<br>"." Completed: ".$value["completed"];
  $link="'finaliseReview.php?id=".$value["review_id"]."'";
  ?>
    <li> <?php echo $name."<br>"; ?>  
    Review Year:  
    <a href=<?php echo $link; ?>><?php echo $year."<br>"?></a> 
    <?php echo $det."<br>";  ?>
    </li>
 <?php   
  }
?>
</ol>

<?php 

}

?>


