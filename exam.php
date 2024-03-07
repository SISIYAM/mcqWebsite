<?php
include './includes/login_required.php';
include './Admin/includes/dbcon.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Form Basics</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
  .inputGroup {
    background-color: #fff;
    display: block;
    margin: 10px 0;
    position: relative;
  }

  label {
    padding: 12px 40px;
    width: 100%;
    display: block;
    text-align: left;
    color: #3C454C;
    cursor: pointer;
    position: relative;
    z-index: 2;
    transition: color 200ms ease-in;
    overflow: hidden;
    border: 2px solid #cacaca;
    border-radius: 8px;

    &:before {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      content: '';
      background-color: #5562eb;
      position: absolute;
      transform: translate(-50%, -50%) scale3d(1, 1, 1);
      transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
      opacity: 0;
      z-index: -1;
      padding: 100%;

    }

    &:after {
      width: 22px;
      height: 22px;
      content: '';
      border: 2px solid #D1D7DC;
      background-color: #fff;
      background-position: 2px 3px;
      border-radius: 50%;
      z-index: 2;
      position: absolute;
      left: 5px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      transition: all 200ms ease-in;
    }
  }

  input:checked~label {
    color: #fff;

    &:before {
      transform: translate(-50%, -50%) scale3d(56, 56, 1);
      opacity: 1;
    }

    &:after {
      background-color: #54E0C7;
      border-color: #54E0C7;
    }
  }

  input {
    width: 32px;
    height: 32px;
    order: 1;
    z-index: 2;
    position: absolute;
    right: 30px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    visibility: hidden;
  }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include 'includes/nav.php' ?>

    <?php 
    if(isset($_GET['Exam-ID'])){
      $examId= $_GET['Exam-ID'];
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Exam</h1>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item">Exam</li>
          <li class="breadcrumb-item active" aria-current="page">Exam</li>
        </ol>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <!-- Form -->
          <form action="" method="post">
            <input type="hidden" value="<?=$examId?>" name="exam_id">
            <div class="card mb-4">
              <?php 
              $i = 1;
              $select = mysqli_query($con, "SELECT * FROM questions WHERE exam_id='$examId'");
              if(mysqli_num_rows($select) > 0)
              {
                while($row = mysqli_fetch_array($select)){
                  ?>
              <div class="card-body">
                <h6 class="mb-2 p-1 d-inline bg-gradient-primary rounded text-light font-weight-bold"
                  style="font-size:13px">Question : <?=$i?></h6>
                <b class="" style="float: right;">Mark : <?=$row['mark']?></b>
                <div class="form-group">
                  <p for="" class="font-weight-bold text-dark mt-3"><?=$row['question']?></p>
                  <?php
                 if(isset($row['option_1'])){
                  ?>
                  <div class="inputGroup">
                    <input id="radio1<?=$i?>" type="radio" name="<?=$row['id']?>" value="1" />
                    <label for="radio1<?=$i?>"><?=$row['option_1']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_2'])){
                  ?>
                  <div class="inputGroup">
                    <input id="radio2<?=$i?>" type="radio" name="<?=$row['id']?>" value="2" />
                    <label for="radio2<?=$i?>"><?=$row['option_2']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_3'])){
                  ?>
                  <div class="inputGroup">
                    <input id="radio3<?=$i?>" type="radio" name="<?=$row['id']?>" value="3" />
                    <label for="radio3<?=$i?>"><?=$row['option_3']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <?php
                 if(isset($row['option_4'])){
                  ?>
                  <div class="inputGroup">
                    <input id="radio4<?=$i?>" type="radio" name="<?=$row['id']?>" value="4" />
                    <label for="radio4<?=$i?>"><?=$row['option_4']?></label>
                  </div>
                  <?php
                 }
                 ?>
                  <input type="radio" checked value="5" name="<?=$row['id']?>" style="display:none;">
                </div>

              </div>

              <?php
              $i++;
                }
                ?>
              <button type="submit" class="btn btn-primary" name="submitExam">Submit</button>
              <?php
              }else{
                ?>
              <p class="alert alert-danger">No questions added yet!</p>
              <?php
              }
              ?>

            </div>

          </form>
        </div>
      </div>
      <!--Row-->
    </div>
    <!---Container Fluid-->
    <?php
    }else{
      ?>
    <!-- Container Fluid-->
    <div class="container-fluid" id="container-wrapper">
      <div class="text-center">
        <img src="img/error.svg" style="max-height: 100px;" class="mb-3">
        <h3 class="text-gray-800 font-weight-bold">Oopss!</h3>
        <p class="lead text-gray-800 mx-auto">404 Page Not Found</p>
        <button onclick="history.back()" class="btn btn-danger">&larr; Back to Dashboard</button>
      </div>
    </div>
    <!---Container Fluid-->
    <?php
    }
    ?>



    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to logout?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
            <a href="login.html" class="btn btn-primary">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>copyright &copy;
          <script>
          document.write(new Date().getFullYear());
          </script> - developed by
          <b><a href="#" target="_blank">Siyam</a></b>
        </span>
      </div>
    </div>
  </footer>
  <!-- Footer -->
  </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./Admin/js/sweetalert.js"></script>
  <?php include './includes/code.php';?>
</body>

</html>