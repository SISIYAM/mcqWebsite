$(document).ready(function () {
  // show student information
  $(".viewStudentInformationBtn").on("click", function () {
    const studentId = $(this).val();
    $.ajax({
      type: "post",
      url: "includes/ajax.php",
      data: {
        id: studentId,
        searchStudentInformation: "searchStudentInformation",
      },
      success: function (response) {
        $("#studentModalContent").html(response);
      },
    });
  });

  // deactivate teachers
  $(".teacherDeactivateBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            deactivateTeacherBtn: "deactivateTeacherBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // activate teachers
  $(".teacherActivateBtn").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirm",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/ajax.php",
          data: {
            id: id,
            activateTeacherBtn: "activateTeacherBtn",
          },
          success: function (response) {
            if (response == 200) {
              Swal2.fire({
                icon: "success",
                title: "Success",
              }).then(() => {
                location.reload();
              });
            } else {
              callError();
            }
          },
        });
      }
    });
  });

  // delete teacher
  $(".deleteTeacher").on("click", function () {
    const id = $(this).val();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "includes/delete.php",
          data: {
            id: id,
            deleteTeacherBtn: "deleteTeacherBtn",
          },
          success: function (deleteTeacherResponse) {
            if (deleteTeacherResponse == 200) {
              callDeleteSuccess();
            } else {
              callError();
            }
          },
        });
      }
    });
  });
});
