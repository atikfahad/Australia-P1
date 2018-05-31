<?php 
    $error = "Incorrect UserName/Password";
    // SEESION START
    session_start();
    $title = "Login";
    require('header.php');
    require('model/model.php');
    if(isset($_SESSION['eid'])) {
    echo "<script>window.location='choosereview.php?eid=".$_SESSION['eid']."&type=". $_SESSION['type']."'</script>";
    } 
// LOG IN
    
    if(isset($_POST['enter']))
    {
        $eid = $_POST['eid'];
        $pass = $_POST['password'];
        
    if($eid!="" || $pass!="")
        {
            $p = hash('sha256', $pass);
            $query = "SELECT * FROM employee where employee_id='$eid' and password= '$p'";
            $result = mysqli_query($conn,$query) ;
            $temp = mysqli_fetch_assoc($result);
            if(!mysqli_num_rows($result) == 0)
            { 
                getInfoMain($eid);
                // $_SESSION['eid']= $temp['employee_id'];
                // if ($eid == "supervisor") {
                //      $_SESSION['type'] = "supervisor";
                // }
                // else{
                //     $_SESSION['type'] = "employee";
                // }
                echo "<script>window.location='choosereview.php?eid=".$temp['employee_id']."&type=". $_SESSION['type']."'</script>";
            }
            else{
                $_SESSION['error'] = $error;
                // echo "<script>window.location='login.php'</script>"; //send user back to the login page.
        }
    }
}
?>
<script type="text/javascript">
    function validation(){
        var id = document.getElementById("eid").value;
        var pas = document.getElementById("password").value;
        if(id == "" || pas == "")
        {
            window.location='login.php';
            document.getElementById("err").innerHTML = "Username/Password cannot be empty";
            return false;
        }
        return true;
    }
</script>
<div class="login-form">
                <div class="inner-box">
                    <form method="post">
                        <div>
                            <h2 style="
    text-align:  center;
">Login Portal</h2>
                            <div>
                                <label> Employee ID</label><br /> <input type="text" id="eid" name="eid">
                            </div>
                            <div>
                                <label> Password</label><br />
                                <input type="password" id="password" name="password"> 
                            </div>
                            <div>
                                <input type="submit" id="enter" name="enter" value="Log In" onclick="return validation()"> <br />
                                <?php
                                    if(isset($_SESSION["error"])){
                                    $error = $_SESSION["error"];
                                    echo "<span id='err'>$error</span>";
                                    }
                                ?> 
                                <span id='err'></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


<?php
    unset($_SESSION["error"]);
    
?>