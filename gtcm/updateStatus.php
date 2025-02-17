<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="style_AddData01.css">
  <?php include "head.html"; ?>
  <link href="assetsOperatorTabel/css/main.css" rel="stylesheet">
</head>

<body>
  <div style="max-width: 1980px; margin: auto">
    <div>
      <?php
      if (!isset($_SESSION['role'])) {
        header('location:login.html');
      } else if ($_SESSION['role'] != 'Superadmin') {
        header("Location: accessDenied.php");
      }
      include "connection.php";
      include "function/myFunc.php";
      ?>
    </div>
    <div>
      <?php
      if (isset($_POST['submit'])) {
        $status = $_POST['status'];
        $id = $_POST['id'];

        $updated_by = $_SESSION['name'];

        $sqlStatus = "UPDATE tb_statuskegiatan 
            SET status = '$status', 
                updated_by = '$updated_by'
            WHERE id='$id'";

        if ($conn->multi_query($sqlStatus) === TRUE) {
          echo "New records created successfully";
          if ($_SESSION['role'] == "Superadmin") {
            header('location:statusTabel.php');
          } 
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      } else if(isset($_GET['id'])){
        $id = $_GET['id'];
        $statusInfo = parentFromId($id, "tb_statuskegiatan");
        $status = $statusInfo['status'];
      }
      else{
        //回家
      }
      ?>
    </div>

    <?php include "headerNavigation.php"; ?>

    <div id="main">
      <?php menu();?>

      <div id="right" class="text-black">
        <h2>Add Status Kegiatan</h1>

          <div class="container">
            <form action="./updateStatus.php" method="post">
                <input type="hidden" id="id" name="id" value="<?php echo $id;?>" required>
              <div class="row">
                <label for="status">Status</label>
                <input type="text" id="status" name="status" placeholder="nama status" value="<?php echo $status;?>" required>
              </div>

              <div class="row">
                <input type="submit" name="submit" value="Submit">
              </div>

            </form>
          </div>
      </div>
    </div>
    <?php $conn->close(); ?>
  </div>
</body>

</html>