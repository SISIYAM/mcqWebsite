<?php
include 'dbcon.php';

// search student information
if(isset($_POST['searchStudentInformation'])){
  $id = $_POST['id'];
  $output = "";
  $search = mysqli_query($con,"SELECT * FROM students WHERE id ='$id'");
  if(mysqli_num_rows($search) > 0){
     $row = mysqli_fetch_array($search);
     $output = ' 
   <label for="email">Student ID: </label>
     <div class="form-group">
       <input type="text" value="'.$row['student_id'].'" class="form-control" readonly>
     </div>
     <label for="name">Name: </label>
     <div class="form-group">
       <input type="text" value="'.$row['full_name'].'" class="form-control" readonly>
     </div>
     <label for="email">Username: </label>
     <div class="form-group">
       <input type="text" value="'.$row['username'].'" class="form-control" readonly>
     </div>
   <label for="email">Email: </label>
     <div class="form-group">
       <input type="text" value="'.$row['email'].'" class="form-control" readonly>
     </div>
     <label for="email">Mobile: </label>
     <div class="form-group">
       <input type="text" value="'.$row['mobile'].'" class="form-control" readonly>
     </div>
     <label for="email">College: </label>
     <div class="form-group">
       <input type="text" value="'.$row['college'].'" class="form-control" readonly>
     </div>
     <label for="email">HSC: </label>
     <div class="form-group">
       <input type="text" value="'.$row['hsc'].'" class="form-control" readonly>
     </div>
     ';
     echo $output;
  }
  else{
     $output = '<div class="alert alert-danger">No data found.</div>';
     echo $output;
  }
}

// active and inactive teachers account code
if(isset($_POST['deactivateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 0 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}

if(isset($_POST['activateTeacherBtn'])){
  $id = $_POST['id'];
  $sql = mysqli_query($con, "UPDATE admin SET status = 1 WHERE id='$id'");
  if($sql){
    echo 200;
  }else{
    echo 500;
  }
}
?>