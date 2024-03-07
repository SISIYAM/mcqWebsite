<?php
include 'dbcon.php';

// delete question
if(isset($_POST['deleteTeacherBtn'])){
  $id = $_POST['id'];

  $delete = mysqli_query($con, "DELETE FROM admin WHERE id='$id'");
  if($delete){
    echo 200;
  }else{
    echo 500;
  }
}
?>