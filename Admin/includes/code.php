<?php
// Register New Admin
if(isset($_POST['registerAdminBtn'])){
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from admin where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
     $_SESSION['errorMsg'] = "This Username Already Exists, Please Use Another Username";
    }else{
      $emailQuery = " select * from admin where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
     $_SESSION['errorMsg'] = "This Email Already Exists, Please Use Another Email";
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `admin` ( `full_name`, `username`, `email`, `password`, `confirm_password`)
          VALUES ( '$full_name', '$username', '$email', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
            $_SESSION['msg'] = "Congratulations ".$username."! Your account created successfully";
          }else{
            $_SESSION['errorMsg'] = "Registration Failed";    
          }

      }else{

        $_SESSION['errorMsg'] = "Password and confirm password do not match";

          }
    }
  }
}

// admin login
if(isset($_POST['adminLoginBtn'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

    $username_search = " select * from admin where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];

        $_SESSION['username'] = $username_pass['username'];
        $_SESSION['email'] = $username_pass['email'];
        $_SESSION['id'] = $username_pass['id'];
        $_SESSION['post'] = $username_pass['post'];
        
        $pass_decode = password_verify($password, $db_pass);

        if($pass_decode){
          ?>
<script>
location.replace("index.php");
</script>
<?php
         }else{
          $_SESSION['errorMsg'] = "Incorrect Password";
         }

     }else{
      $_SESSION['errorMsg'] = "Invalid Username";
     }

}

// add exam
if (isset($_POST['submitExamBtn'])) {
  $ChangeExam_name = $_POST['exam_name'];
  $exam_name = str_replace("'","\'", $ChangeExam_name);
  $exam_id = uniqid();
  $duration = (($_POST['duration_hour'] * 3600) + ($_POST['duration_minute'] * 60) + ($_POST['duration_seconds']));
  
  if($_POST['exam_start_minutes'] == "" || $_POST['exam_start_minutes'] == 00){
    $exam_start = $_POST['exam_start_date']." " .$_POST['exam_start_month']." ".$_POST['exam_start_year']." ".$_POST['exam_start_hours'].$_POST['exam_start_am_pm'];
  }else{
    $exam_start = $_POST['exam_start_date']." " .$_POST['exam_start_month']." ".$_POST['exam_start_year']." ".$_POST['exam_start_hours'].":".$_POST['exam_start_minutes'].$_POST['exam_start_am_pm'];
  
  }

  if($_POST['exam_end_minutes'] == "" || $_POST['exam_end_minutes'] == 00){
    $exam_end = $_POST['exam_end_date']." " .$_POST['exam_end_month']." ".$_POST['exam_end_year']." ".$_POST['exam_end_hours'].$_POST['exam_end_am_pm'];
  }else{
    $exam_end = $_POST['exam_end_date']." " .$_POST['exam_end_month']." ".$_POST['exam_end_year']." ".$_POST['exam_end_hours'].":".$_POST['exam_end_minutes'].$_POST['exam_end_am_pm'];
  
  }
  $mcq_marks = $_POST['mcq_marks'];
  $written_marks = $_POST['written_marks'];
  
    $sql = "INSERT INTO `exam`(`exam_name`, `exam_id`, `duration`, `exam_start`, `exam_end`, `mcq_marks`, `written_marks`) 
    VALUES ('$exam_name','$exam_id','$duration','$exam_start','$exam_end','$mcq_marks','$written_marks')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Exam");
</script>
<?php
  
    }
}

// Add Question
if (isset($_POST['addQuestion'])) {
  $exam_id = $_POST['exam_id'];
  $marks = $_POST['marks'];
  $negative_marks = $_POST['negative_marks'];
  $changeQuestion = $_POST['question'];
  $question = str_replace("'","\'", $changeQuestion);
  $changeOption_1 = $_POST['option_1'];
  $option_1 = str_replace("'","\'", $changeOption_1);
  $changeOption_2 = $_POST['option_2'];
  $option_2 = str_replace("'","\'", $changeOption_2);
  $changeOption_3 = $_POST['option_3'];
  $option_3 = str_replace("'","\'", $changeOption_3);
  $changeOption_4 = $_POST['option_4'];
  $option_4 = str_replace("'","\'", $changeOption_4);
  $changeSolution = $_POST['solution'];
  $solution = str_replace("'","\'", $changeSolution);
  $answer = $_POST['answer'];
  
  
    $sql = "INSERT INTO `questions`(`exam_id`, `question`, `option_1`, `option_2`, `option_3`, `option_4`, `answer`, `mark`, `negative_mark`,`solution`)
    VALUES ('$exam_id','$question','$option_1','$option_2','$option_3','$option_4','$answer','$marks','$negative_marks','$solution')";
    $query = mysqli_query($con, $sql);
  
    if ($query) {
      $_SESSION['message'] = "Success";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
    } else {
      $_SESSION['error'] = "Failed";
      ?>
<script>
location.replace("list.php?Questions");
</script>
<?php
  
    }
}

// deactivate teachers
if(isset($_POST['teacherDeactivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='1' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}

// activate teacher
if(isset($_POST['teacherActivateBtn'])){
  $id = $_POST['id'];

  $query = mysqli_query($con, "UPDATE admin SET status='0' WHERE id='$id'");
  if($query){
    ?>
<script>
location.replace("list.php?Teachers");
</script>
<?php
  }else{
    ?>
<script>
alert("Failed");
</script>
<?php
  }
}

?>