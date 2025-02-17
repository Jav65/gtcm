


<!-- https://stackoverflow.com/questions/923885/capture-html-canvas-as-gif-jpg-png-pdf -->
<!-- testing dashboard -->
<?php session_start();
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="recentActivity.css">

  <?php
  include "head.html";
  ?>
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

    $('td:nth-child(2)').hover(
      function () {
        $(this).parent('tr').children('td').addClass('hover');
      },
      function () {
        $(this).parent('tr').children('td').removeClass('hover');
      }
    );
  </script>
  <style>
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
  <div style="max-width: 1980px; margin: auto; ">
    <div>
      <?php
      if (!isset($_SESSION['role'])) {
        header('location:login.html');
      } else if ($_SESSION['role'] != 'Observer Ministry') {
        header("Location: accessDenied.php");
      }
      include "connection.php";
      include "function/myFunc.php";

      ?>
    </div>
    <div class="container">
      <?php
      // list of cluster
      $clusterDashboard = array();
      $sqlCluster = "SELECT id FROM tb_cluster WHERE flag_active=1";
      $result = $conn->query($sqlCluster);
      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          array_push($clusterDashboard, $row['id']);
        }
      }
      ?>
    </div>
    <div>
      <?php
      //   $filter = array(
      //     "id_cluster" => "allCluster",
      //     "pic" => "allMinistry",
      //     "status" => "allStatus",
      //     "region" => "Nasional",
      //     "tahun_selesai" => "2019-2024",
      //   );
      
      //   // id to be called by Javascript
      //   $idFilterMinis = array(
      //     "allMinistry" => "allMinistry",
      //     "Kementrian PUPR" => "pupr",
      //     "Kementrian Perhubungan" => "hub",
      //     "Kementrian KLHK" => "klhk",
      //     "Kementrian ESDM" => "esdm",
      //     "Kementrian Parekraf" => "parekraf",
      //     "Kementrian KKP" => "kkp",
      //     "Kementrian Investasi" => "inves"
      //   );
      
      //   $idFilterStatus = array(
      //     "allStatus" => "allStatus",
      //     "Selesai" => "selesai",
      //     "Sedang Berjalan" => "progress",
      //     "Belum Dimulai" => "notstarted",
      //     "Suspend" => "suspend"
      //   );
      

      //   $filter['id_cluster'] = $_GET['id_cluster'] ?? "allCluster";
      //   $filter['pic'] = $_GET['ministry'] ?? "allMinistry";
      //   $filter['status'] = $_GET['status'] ?? "allStatus";
      //   $filter['region'] = $_GET['region'] ?? "Nasional";
      //   $filter['tahun_selesai'] = $_GET["year"] ?? "2019-2024";
      // ferdinand
      
      // $where = "SELECT * FROM tb_program WHERE flag_active=1";
      // foreach ($filter as $type => $val) {
      //   if ($filter[$type] != "allCluster" && $filter[$type] != "allMinistry" && $filter[$type] != "allStatus" && $filter[$type] != "Nasional" && $filter[$type] != "2019-2024") {
      //     if ($type == "region") {
      //       foreach ($regionGroup[$val] as $keyRegion => $valRegion) {
      //         if ($keyRegion == 0) {
      //           $where = $where . " AND " . $type . " IN ('" . $valRegion . "'";
      
      //         } else {
      //           $where = $where . ", '" . $valRegion . "'";
      //         }
      //       }
      //       $where = $where . ") ";
      
      //     } else if ($type == "tahun_selesai") {
      //       for ($bulan = 1; $bulan <= 12; $bulan++) {
      //         if ($bulan == 1) {
      //           $where = $where . " AND " . $type . " IN ('" . $val . "-01-01'";
      //         } else if ($bulan < 10) {
      //           $where = $where . ", '" . $val . "-0" . $bulan . "-01'";
      //         } else {
      //           $where = $where . ", '" . $val . "-" . $bulan . "-01'";
      //         }
      //       }
      //       $where = $where . ") ";
      //     } else {
      
      //       $where = $where . " AND " . $type . "= '" . $val . "'";
      
      //     }
      //     $index++;
      //     /* 
      //      */}
      // }
      ?>
    </div>

    <?php include "headerNavigation.php"; ?>

    <!-- ======= Breadcrumbs ======= -->
    <div class="grid-container">
      <div class="item2">
        <?php menu("daftar_cluster"); ?>

        <div class="container-fluid mt-3">
          <div class="grid-1">
            <h4 class='text-black'><br>Daftar Cluster</h4>

            <?php


            $sql = "SELECT * FROM tb_cluster WHERE flag_active=1";
            $result = $conn->query($sql);

            echo "<div  style='width:100%; overflow-x:auto;'>";
            if ($result->num_rows > 0) {
              //echo "<table class='table table-bordered'>";
              echo "<table class='example' class='display'>";
              // echo "<thead class='table-dark'>
              echo "<thead>
                    <tr>
                        <th>ID CLUSTER</th>
                        <th>CLUSTER</th>
                        <th>DESKRIPSI</th>
                        <th>TANGGAL MULAI</th>
                        <th>TANGGAL BERAKHIR</th>
                        <th class='text-center'>Jumlah Program</th>
                        <th class='text-center'>Jumlah Indikator</th>
                        <th class='text-center'>Jumlah Kegiatan</th>
                    </tr>
                <thead>";
              // output data of each row
            
              echo "<tbody>";
              while ($row = $result->fetch_assoc()) {
                $id_cluster = $row["id"];
                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                $cluster = $row["cluster"];
                $deskripsi = $row["deskripsi"];
                
                // $program = "<p class='text-center'><a href='programTabelOperatorMinistry.php?id_cluster=$id_cluster&deskripsi=$deskripsi'><i class='fa fa-eye'></i></a></p>";

                $dateStartText = dateToText($row['date_started']);
                $dateEndText = dateToText($row['date_end']);

                $sqlProgramCount = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id_cluster='$id_cluster'";
                $programCount = countNum($sqlProgramCount);

                $sqlIndikatorCount = "SELECT * FROM tb_indikator WHERE  flag_active=1 AND id_program LIKE '%" . $id_cluster . "%'";
                $indikatorCount = countNum($sqlIndikatorCount);

                $sqlKegiatanCount = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id_indikator LIKE '%" . $id_cluster . "%'";
                $kegiatanCount = countNum($sqlKegiatanCount);

                //echo "<tr onclick=\"submitFormProgramPage('" . $row['id_program'] . "')\">";
                echo "<tr>";

                echo "<td>" . $id_cluster . "</td>";
                echo "<td>" . $cluster . "</td>";
                echo "<td>" . $deskripsi . "</td>";
                echo "<td>" . $dateStartText . "</td>";
                echo "<td>" . $dateEndText . "</td>";

                //echo "<td>" . $program . "</td>";
                //echo "<td>" . $update_link . "</td>";
                echo "<td><a href=\"programTabelObserverMinistry.php?id_cluster=$id_cluster\"> $programCount</a></td>";
                echo "<td><a href=\"indikatorTabelObserverMinistry.php?id_cluster=$id_cluster\"> $indikatorCount</a></td>";
                echo "<td><a href=\"kegiatanTabelObserverMinistry.php?id_cluster=$id_cluster\"> $kegiatanCount</a></td>";
                echo "</tr>";
              }
              echo "</tbody>";
              echo "</table>";
            } else {
              echo "0 results";
            }
            echo "</div>";
            ?>
          </div>
        </div>
      </div>
    </div>
    </section>


    <!-- End Blog Section -->


    <!-- End #main -->

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

    <script>

      var finish = JSON.parse("<?php echo $jsSelesai_array; ?>");
      console.log(finish);
      var notStarted = JSON.parse("<?php echo $jsNotStarted_array; ?>");
      console.log(notStarted);
      var Sedang_Berjalan = JSON.parse("<?php echo $jsSedangJalan_array; ?>");
      console.log(Sedang_Berjalan);
      var Suspend = JSON.parse("<?php echo $jsSuspend_array; ?>");
      console.log(Suspend);
      var clusterSize = parseInt("<?php echo $clusterSize; ?>");

      for (var j = 0; j < clusterSize; j++) {
        // convert the value to integer
        finish[j] = parseInt(finish[j]);
        notStarted[j] = parseInt(notStarted[j]);
        Sedang_Berjalan[j] = parseInt(Sedang_Berjalan[j]);
        Suspend[j] = parseInt(Suspend[j]);

        var canvas = document.getElementsByClassName("myCanvas")[j];
        var ctx = canvas.getContext("2d");

        var values = [finish[j], Sedang_Berjalan[j], notStarted[j], Suspend[j]];
        //var values = [2, 1, 1, 1];
        var colors = ["#80DEEA", "#FFE082", "#FFAB91", "#CE93D8"];

        function drawPieChart() {
          var total = 0;
          for (var i = 0; i < values.length; i++) {
            total += values[i];
          }

          var currentAngle = -0.5 * Math.PI;
          for (var i = 0; i < values.length; i++) {
            var sliceAngle = 2 * Math.PI * values[i] / total;
            ctx.fillStyle = colors[i];
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, canvas.height / 2);
            ctx.arc(canvas.width / 2, canvas.height / 2, Math.min(canvas.width, canvas.height) / 2, currentAngle, currentAngle + sliceAngle);
            ctx.closePath();
            ctx.fill();
            currentAngle += sliceAngle;
          }
        }

        function resizeCanvas() {
          canvas.width = window.innerWidth * 0.8;
          canvas.height = canvas.width;
          drawPieChart();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();
      }
    </script>

    <!-- Filter -->
    <script src="filterDashboardMain.js"></script>
    <!-- Vendor JS Files -->
    <script src="assetsFilter/vendor/aos/aos.js"></script>
    <script src="assetsFilter/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assetsFilter/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assetsFilter/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assetsFilter/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assetsFilter/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assetsFilter/js/main.js"></script>
    <script>
      <?php
      $idCluster = $filter['id_cluster'];
      $idMinistry = $idFilterMinis[$filter['pic']];
      $idStatus = $idFilterStatus[$filter['status']];
      $idYear = $filter['tahun_selesai'];
      ?>
      document.getElementById("<?php echo $idCluster; ?>").checked = true;
      document.getElementById("<?php echo $idMinistry; ?>").checked = true;
      document.getElementById("<?php echo $idStatus; ?>").checked = true;
      document.getElementById("<?php echo $idYear; ?>").checked = true;
    </script>


    <?php $conn->close(); ?>
  </div>
</body>

</html>