<?php
session_start();
ob_start();
//include('security.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "head.html"; ?>
  <!-- Template Main CSS Tabel -->
  <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
  <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
  </style>
  <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
      $('.example').DataTable();
    });


  </script>

  <style>
    td.hover {
      background-color: #f1f1f1;
    }

    table {
      border: 1px solid black;
    }

    th,
    td {
      border: 1px solid black;
      padding: 8px;
    }
  </style>
</head>

<body>
  <div>
    <?php
    if (!isset($_SESSION['role'])) {
      header('location:login.html');
    } else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI') {
      header("Location: accessDenied.php");
    }
    include "connection.php";
    include "function/myFunc.php";

    ?>
  </div>
  <div>
    <?php

    $searchFeature = $_GET['search'] ?? "";

    $formType = $_GET['formType'] ?? "filter";
    if ($formType == "search") {
      $where = "SELECT * FROM tb_master_pic WHERE flag_active=1 AND (role LIKE '%" . $searchFeature . "%' OR nama_pic LIKE '%" . $searchFeature . "%')";
      $where = $where . " ORDER BY id ASC";
    } else {
      $where = "SELECT * FROM tb_master_pic WHERE flag_active=1";
      $where = $where . " ORDER BY id ASC";
    }

    ?>
  </div>

  <?php include "headerNavigation.php"; ?>

  <!-- isi disini -->
  <div class="grid-container">
    <div class="item2">
    <?php menu("master_user");?>

      <div class="container mt-3">
        <div class="grid-1">
          <div class="searchTable">
            <button style="background-color: green; border-color: rgb(68, 151, 68); color: white; border-radius:3px"
              onclick="window.location.href='addUserSuperadmin.php'" ;>
              + add
            </button>
          </div>
        </div>

        <?php
        $sql = $where;
        $result = $conn->query($sql);

        echo "<h4><br>Daftar User</h4>";
        echo "<div style='overflow-x:auto'>";
        if ($result->num_rows > 0) {
          echo "<table class='example' class='display' style='width:100%'>";
          echo "<thead>
                <tr>
                    <th>Aksi</th>
                    <th>ID PIC</th>
                    <th>Instansi</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>HP</th>
                    <th>Email</th>
    
                </tr>
            <thead>";
          echo "<tbody>";
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            $id_pic = $row["id"];
            $id_kementrian = $row["id_kementrian"];
            $instansi_info = parentFromId($id_kementrian, "tb_master_kementrian");
            $name = $row['nama_pic'];
            $role = $row['role'];
            $hp = $row['hp_pic'];
            $email = $row['email'];
            //$update_link = "<p class='text-center'><a href='updateUser.php?id_pic=$id_pic'><i class='fa fa-pencil' text-warning></i></a></p>";
            //$delete_link = "<p class='text-center'><a href='delete_User.php?id_pic=$id_pic'><i class='fa-solid fa-trash text-danger'></i></a></p>";
        


            //echo "<tr onclick=\"submitFormProgramPage('" . $row['id_program'] . "')\">";
            echo "<tr>";
            echo "<td>";

            echo "  <button type='button' onclick=\"window.location.href='updateUser.php?id_pic=$id_pic'\"
                            class='btn btn-primary' style='margin: 5px 0 3px 0'>Update</button>";
            echo "  <button type='button' onclick=\"window.location.href='delete_user.php?id_pic=$id_pic'\"
                            class='btn btn-danger' style='margin: 3px 0 5px 0'>Delete</i></button>";
            //echo "  <button type='button' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
            echo "</td>";
            echo "<td>" . $id_pic . "</td>";
            echo "<td>" . $instansi_info['instansi'] . "</td>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $role . "</td>";
            echo "<td>" . $hp . "</td>";
            echo "<td>" . $email . "</td>";

            //echo "<td>" . $update_link . "</td>";
            //echo "<td>" . $delete_link . "</td>";
            echo "</tr>";
          }
          echo "</tbody>";
          echo "</table>";
        } else {
          echo "0 results";
        }
        echo "</div>";
        $conn->close();
        ?>
      </div>
    </div>


  </div>
  <!-- isi disini -->




  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>