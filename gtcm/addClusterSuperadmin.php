<?php 
session_start();
ob_start(); 
?>
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
        $cluster = mysqli_real_escape_string($conn, $_POST['cluster']);
        $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

        $date_started = mysqli_real_escape_string($conn, $_POST['date_started'] . "-01");
        $date_end = mysqli_real_escape_string($conn, $_POST['date_end'] . "-01");
        $created_by = mysqli_real_escape_string($conn, $_SESSION['name']);
        $updated_by = mysqli_real_escape_string($conn, $_SESSION['name']);

        $clusterNum = "SELECT * FROM tb_cluster";
        # note that it is not ==, but '=' (assign value to result and check the value of result)
        if ($result = $conn->query($clusterNum)) {
          // Return the number of rows in result set
          $clusterCount = mysqli_num_rows($result) + 1;
        }
        $id_cluster = "CL-" . $clusterCount;

        $sql = "INSERT INTO tb_cluster (id, cluster, deskripsi, date_started, date_end, created_by, updated_by)
                VALUES ('$id_cluster', '$cluster', '$deskripsi', '$date_started', '$date_end', '$created_by', '$updated_by')";

        if ($conn->multi_query($sql) === TRUE) {
          echo "New records created successfully";
          $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
          $colArray = array(
            "colName" =>
            array("id", "id_cluster", "nama_ro", "penanggung_jawab_info", "instansi_terkait", "percent_capaian", "b04", "b06", "b09", "b12"),
            "colType" =>
            array("varchar", "varchar", "text", "int", "pic", "parent(4)", "float", "float", "float", "float")
          );
          $indexCol = 0;
          $colSize = sizeof($colArray['colName']);
          $sqlCreateTable = "CREATE TABLE tb_program_$id_clusterEdited (";
          foreach ($colArray['colName'] as $colName) {
            if ($colArray['colType'][$indexCol] == "varchar") {
              $sqlCreateTable = $sqlCreateTable . $colName . " varchar(255), ";
            } else if ($colArray['colType'][$indexCol] == "text") {
              $sqlCreateTable = $sqlCreateTable . $colName . " text, ";
            } else if ($colArray['colType'][$indexCol] == "float") {
              $sqlCreateTable = $sqlCreateTable . $colName . " float(5,2), ";
            } else if ($colArray['colType'][$indexCol] == "pic") {
              $sqlCreateTable = $sqlCreateTable . $colName . " text, ";
            } else if ($colArray['colType'][$indexCol] == "int") {
              $sqlCreateTable = $sqlCreateTable . $colName . " int DEFAULT 0, ";
            } else if (strpos($colArray['colType'][$indexCol], "arent") != false) {
              $sqlCreateTable = $sqlCreateTable . $colName . " text, ";
            }

            //$sqlCreateTable = $sqlCreateTable . $colName . " " . $colArray['colType'] . ", ";
            if ($indexCol == $colSize - 1) {
              $sqlCreateTable = $sqlCreateTable . "
                flag_active tinyint DEFAULT 1, 
                created_by varchar(255), 
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
                updated_by varchar(255), 
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
                PRIMARY KEY (id), 
                CONSTRAINT FK_program_$id_clusterEdited FOREIGN KEY (id_cluster) REFERENCES tb_cluster(id)
                )";
            }
            $indexCol++;
          }

          //echo $sqlCreateTable . '<br>';
          if ($conn->query($sqlCreateTable) === TRUE) {
            $colValue = "";
            $colType = "";
            $indexCol = 0;
            foreach ($colArray['colName'] as $colName) {
              // $colValue = $colValue . "'" . $colName . "', ";
              $colValue = $colValue . $colName . ", ";
              // $colType = $colType . "'" . $colArray["colType"][$indexCol] . "', ";
              $colType = $colType . $colArray["colType"][$indexCol] . ", ";
              $indexCol++;
            }
            $colValue = $colValue . "flag_active, created_by, created_at, updated_by, updated_at";
            $colType = $colType . "tinyint, varchar, timestamp, varchar, timestamp";

            $sqlColName = "INSERT INTO tb_colname_program (id, colName1, type1) VALUES (\"$id_cluster\", \"$colValue\", \"$colType\")";
            if ($conn->query($sqlColName) === TRUE) {
              echo "Table MyGuests created successfully";
              echo "<form action='addColumnTable.php' method='post' id='addColumnPage'>";
              echo "<input type='hidden' name='id_cluster' value=\"$id_cluster\">";
              echo "</form>";

              echo "<script>";
              echo "document.getElementById('addColumnPage').submit()";
              echo "</script>";
            } else {
              echo "Error creating colname: " . $conn->error;
            }

          } else {
            echo "Error creating table: " . $conn->error;
          }



          // if ($_SESSION['role'] == "Superadmin") {
          //   header('location:superadminMainCMMAI.php');
          // } 
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
      ?>
    </div>

    <?php include "headerNavigation.php"; ?>

    <div id="main">
      <?php menu(); ?>

      <div id="right" class="text-black">
        <h2>Add Cluster</h1>

          <div class="container">
            <form action="./addClusterSuperadmin.php" method="post">
              <div class="row">
                <label for="cluster">Cluster</label>
                <textarea id="cluster" name="cluster" rows="4" cols="50" placeholder="Add Cluster" required></textarea>
              </div>

              <div class="row">
                <label for="deskripsi">deskripsi</label>
                <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                <textarea id="deskripsi" name="deskripsi" rows="4" cols="50" placeholder="Add Deskripsi"
                  required></textarea>
              </div>

              <div class="row">
                <label for="date_started">Tanggal Mulai</label>
                <input type="month" id="date_started" name="date_started" required>
              </div>

              <div class="row">
                <label for="tahun_selesai">Tanggal Selesai</label>
                <input type="month" id="date_end" name="date_end" required>
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