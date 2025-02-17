<?php
include "connection.php";
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
  // Get the username and password from the form
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $sql = "SELECT setPW FROM tb_master_pic WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if ($row['setPW'] == 0) {
        echo "<form id='setPW' action='setPassword.php' method='post'>";
        echo "<input type='hidden' id='email' name='email' value='$email'></input>";
        echo "</form>";

        echo "<script>";
        echo "document.getElementById('setPW').submit();";
        echo "</script>";
      } else {
        // Retrieve the hashed password from the users table
        $selectStmt = $conn->prepare("SELECT password FROM tb_master_pic WHERE flag_active=1 AND email = ?");
        $selectStmt->bind_param("s", $email);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the password hash using password_verify()
        if (password_verify($password, $hashedPassword)) {
          // The password is correct
          echo "Password is correct!";

          $sql = "SELECT * FROM tb_master_pic WHERE email='$email'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            // output data of each row
            if ($row = $result->fetch_assoc()) {
              $_SESSION['email'] = $email;
              $_SESSION['name'] = $row['nama_pic'];
              $_SESSION['id_pic'] = $row['id'];
              $_SESSION['ministry'] = $row['id_kementrian'];
              $_SESSION['role'] = $row['role'];
              if ($_SESSION['role'] == 'Observer CMMAI') {
                header("Location: dashboardMainCMMAI.php");
              } else if ($_SESSION['role'] == 'Observer Ministry') {

                header("Location: dashboardMainMinistry.php");
              } else if ($_SESSION['role'] == 'Superadmin') {
                $_SESSION['id_cluster'] = "allCluster";
                $_SESSION['pic'] = "allMinistry";
                $_SESSION['status'] = "allStatus";
                $_SESSION['region'] = "Nasional";
                $_SESSION['tahun_selesai'] = "2019-2024";
                header("Location: superadminMainCMMAI.php");
              } else if ($_SESSION['role'] == 'Operator CMMAI') {
                $_SESSION['id_cluster'] = "allCluster";
                $_SESSION['pic'] = "allMinistry";
                $_SESSION['status'] = "allStatus";
                $_SESSION['region'] = "Nasional";
                $_SESSION['tahun_selesai'] = "2019-2024";
                header("Location: operatorMainCMMAI.php");
              } else if ($_SESSION['role'] == 'Operator Ministry') {
                $_SESSION['id_cluster'] = "allCluster";

                $_SESSION['status'] = "allStatus";
                $_SESSION['region'] = "Nasional";
                $_SESSION['tahun_selesai'] = "2019-2024";
                header("Location: operator_ministryMain.php");
              } else if ($_SESSION['role'] == 'user') {
                header("Location: user_dashboard.php");
              }
            }
          } else {
            $_SESSION['error'] = "error";
            echo "Invalid credentials";
            header("Location: login.html");

          }
        } else {
          // The password is incorrect
          echo "Password is incorrect.";
          header("Location: login.html");
        }
      }

    }
  }
}
else if(isset($_SESSION['role'])){
  if ( $_SESSION['role'] == 'Observer CMMAI') {
    header( "Location: dashboardMainCMMAI.php" );
  }
  else if ( $_SESSION['role'] == 'Observer Ministry') {
    header( "Location: dashboardMainMinistry.php" );
  }
  else if($_SESSION['role'] == 'Superadmin') {
    header( "Location: superadminMainCMMAI.php" );
  }
  else if($_SESSION['role'] == 'Operator CMMAI') {
      header( "Location: operatorMainCMMAI.php" );
    }
  else if($_SESSION['role'] == 'Operator Ministry') {
    $_SESSION['id_cluster'] = "allCluster";
        
        $_SESSION['status'] = "allStatus";
        $_SESSION['region'] = "Nasional";
        $_SESSION['tahun_selesai'] = "2019-2024";
        header( "Location: operator_ministryMain.php" );
  }
  else if($_SESSION['role'] == 'user') {
      header( "Location: user_dashboard.php" );
    }
  else{
    header( "Location: login.html" );
  }
}
else{
  header( "Location: login.html" );
}



// Connect to the MySQL database




// Close the database connection



// Close the database connection

$conn->close();
?>