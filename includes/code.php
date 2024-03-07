<?php
// Register New student
if(isset($_POST['registerBtn'])){
  $studentID = rand(10000,99999);
  $full_name = mysqli_real_escape_string($con, $_POST['full_name']) ;
  $username = mysqli_real_escape_string($con, $_POST['username']) ;
  $email = mysqli_real_escape_string($con, $_POST['email']) ;
  $password = mysqli_real_escape_string($con, $_POST['password']) ;
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']) ;

  $pass = password_hash($password,  PASSWORD_BCRYPT);
  $cpass = password_hash($confirm_password, PASSWORD_BCRYPT);

    $user_count = "select * from students where username= '$username' ";
    $userQuery = mysqli_query($con,$user_count);
    $userCount = mysqli_num_rows($userQuery);

    if($userCount > 0){
     $_SESSION['errorMsg'] = "This Username Already Exists, Please Use Another Username";
    }else{
      $emailQuery = " select * from students where email= '$email'";
      $query = mysqli_query($con,$emailQuery);

      $emailCount = mysqli_num_rows($query);

    if($emailCount > 0){
     $_SESSION['errorMsg'] = "This Email Already Exists, Please Use Another Email";
    }else{
      if($password === $confirm_password){

          $insertQuery = "INSERT INTO `students` ( `student_id`,`full_name`, `username`, `email`, `password`, `confirm_password`)
          VALUES ('$studentID','$full_name', '$username', '$email', '$pass', '$cpass')";

            $iQuery = mysqli_query($con, $insertQuery);

          if($iQuery){
            $_SESSION['msg'] = "Congratulations ".$username."! Your account created successfully. Now you can log in!";
          }else{
            $_SESSION['errorMsg'] = "Registration Failed";    
          }

      }else{

        $_SESSION['errorMsg'] = "Password and confirm password do not match";

          }
    }
  }
}

// student login
if(isset($_POST['LoginBtn'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

    $username_search = " select * from students where username='$username'";
    $query = mysqli_query($con,$username_search);

    $username_count = mysqli_num_rows($query);

    if($username_count){
        $username_pass = mysqli_fetch_assoc($query);

        $db_pass = $username_pass['password'];
        
        $_SESSION['student_id'] = $username_pass['student_id'];
        
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

// submit and calculate result
if(isset($_POST['submitExam'])){
  $exam_id = $_POST['exam_id'];
  $insertStudentID = $_SESSION['student_id'];
  $right = 0;
  $wrong = 0;
  $noAns = 0;

  // check is student submit result before or not
  $checkStudent = mysqli_query($con, "SELECT * FROM result WHERE student_id='$insertStudentID' && exam_id='$exam_id'");
  if(mysqli_num_rows($checkStudent) > 0){

   ?>
<script>
Swal2.fire({
  icon: "error",
  title: "Exam Already Taken!",
}).then(() => {
  location.replace("result.php?Exam-History=<?=$exam_id?>");
});
</script>
<?php
  }else{

    $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$exam_id'");
    if(mysqli_num_rows($select) > 0){
     while($res = mysqli_fetch_array($select)){
      $mark = $res['mark'];
      $negative_mark = $res['negative_mark'];
       if($_POST[$res['id']] == $res['answer']){
         $right++;
       }elseif ($_POST[$res['id']] == 5) {
         $noAns ++;
       }else{
         $wrong++;
       }
       $question_id = $res['id'];
       $answered = $_POST[$res['id']];
       
       $query = mysqli_query($con, "INSERT INTO record (student_id,exam_id,question_id,answered) VALUES ('$insertStudentID','$exam_id','$question_id', '$answered')");
     }
   
     $totalAnswered = $wrong + $right;
     $result = ($right * $mark)-($wrong * $negative_mark);
     // if result less than 0 then set it's value into 0
     if($result < 0){
       $result = 0;
     }
     $insertResult = mysqli_query($con, "INSERT INTO result (`student_id`, `exam_id`, `result`, `answered`, `wrong_answered`, `right_answered`, `not_answered`) 
     VALUES ('$insertStudentID','$exam_id','$result','$totalAnswered','$wrong','$right','$noAns')");
    if($insertResult){ 
     ?>
<script>
Swal2.fire({
  icon: "success",
  title: "Submit Successfully!",
}).then(() => {
  location.replace("result.php?Exam-History=<?=$exam_id?>");
});
</script>
<?php
    }else{
     ?>
<script>
alert("Failed to insert Result");
</script>
<?php
    }
   
    }

  }
}
?>