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

  <!-- <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
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

  


  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
  <style>
    .dropdown-menu {
      max-height: 200px;
      overflow-y: auto;
    }
  </style>

  <style>
    #card_groupBar {
      max-width: 100%;
      max-height: 400px;
      display: flex;
      justify-content: center;
      margin-top: 2rem;
    }
  </style>-->

  <!-- dropdown -->
  <!-- <style>
    .select2-selection__arrow {
      right: 5px;
      top: 10px;
    }

    .form-group {
      display: inline-block;
    }
  </style>  -->

  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'>
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
  <style>
    .dropdown-menu {
      max-height: 200px;
      overflow-y: auto;
    }
  </style>
  <style>
    .select2-selection__arrow {
      right: 5px;
      top: 10px;
    }

    .form-group {
      display: inline-block;
    }
  </style>

  <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $('.example').DataTable({
        pagingType: 'full_numbers',
      });
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
  <div style="max-width: 1980px; margin: auto">
    <div>
      <?php
      if (!isset($_SESSION['role'])) {
        header('location:login.html');
      } else if ($_SESSION['role'] != 'Observer Ministry') {
        header("Location: accessDenied.php");
      }
      include "connection.php";
      include "function/myFunc.php";
      $userEmail = $_SESSION['email'];
      $sqlMinistry = "SELECT * FROM tb_master_pic WHERE email='$userEmail'";
      $resultMinistry = $conn->query($sqlMinistry);
      if ($resultMinistry->num_rows > 0) {
        while ($rowMinistry = $resultMinistry->fetch_assoc()) {
          $userMinistry = $rowMinistry['id_kementrian'];
        }
      }
      ?>
    </div>

    <div>
      <?php
      // $filter = array(
      //   "id_cluster" => "allCluster",
      //   "instansi_terkait" => "allInstansi",
      // );
      
      // // id to be called by Javascript
      // $idFilterMinis = array(
      //   "allMinistry" => "allMinistry",
      //   "Kementrian PUPR" => "pupr",
      //   "Kementrian Perhubungan" => "hub",
      //   "Kementrian KLHK" => "klhk",
      //   "Kementrian ESDM" => "esdm",
      //   "Kementrian Parekraf" => "parekraf",
      //   "Kementrian KKP" => "kkp",
      //   "Kementrian Investasi" => "inves"
      // );
      
      // $idFilterStatus = array(
      //   "allStatus" => "allStatus",
      //   "Selesai" => "selesai",
      //   "Sedang Berjalan" => "progress",
      //   "Belum Dimulai" => "notstarted",
      //   "Suspend" => "suspend"
      // );
      
      // if (isset($_GET['id_cluster'])) {
      //   $filter['id_cluster'] = $_GET['id_cluster'] ?? "allCluster";
      //   $filter['instansi_terkait'] = $_GET['instansi_terkait'] ?? "allInstansi";
      // $filter['status'] = $_GET['status'] ?? "allStatus";
      // $filter['tahun_selesai'] = $_GET["year"] ?? "2019-2024";
      
      // $_SESSION['id_cluster'] = $filter['id_cluster'];
      // $_SESSION['pic'] = $filter['pic'];
      // $_SESSION['status'] = $filter['status'];
      // $_SESSION['tahun_selesai'] = $filter['tahun_selesai'];
      // } else {
      //   $filter['id_cluster'] = "allCluster";
      //   $filter['instansi_terkait'] = "allInstansi";
      // }
      
      // if (isset($_GET['id_cluster'])) {
      //   $_SESSION['id_cluster'] = $_GET['id_cluster'];
      // }
      // if (isset($_GET['pic'])) {
      //   $_SESSION['pic'] = $_GET['pic'];
      // }
      // if (isset($_GET['status'])) {
      //   $_SESSION['status'] = $_GET['status'];
      // }
      // if (isset($_GET['tahun_selesai'])) {
      //   $_SESSION['tahun_selesai'] = $_GET['tahun_selesai'];
      // }
      
      // $filter['id_cluster'] = $_SESSION['id_cluster'] ?? "allCluster";
      // $filter['pic'] = $_SESSION['pic'] ?? "allMinistry";
      // $filter['status'] = $_SESSION['status'] ?? "allStatus";
      // $filter['tahun_selesai'] = $_SESSION["tahun_selesai"] ?? "allYear";
      
      // $clusterDashboard = array();
      // if ($filter['id_cluster'] == "allCluster") {
      //   $sqlCluster = "SELECT id FROM tb_cluster WHERE flag_active=1";
      //   $clusterDashboard = idListTable("tb_cluster");
      // $result = $conn->query($sqlCluster);
      // if ($result->num_rows > 0) {
      //   // output data of each row
      //   while ($row = $result->fetch_assoc()) {
      //     array_push($clusterDashboard, $row['id']);
      //   }
      // }
      // } else {
      //   array_push($clusterDashboard, $filter['id_cluster']);
      // }
      // $filterIdCluster = $filter['id_cluster'];
      
      $formType = $_GET['formType'] ?? "filter";

      ?>
    </div>

    <?php include "headerNavigation.php"; ?>

    <!-- isi disini -->
    <div class="grid-container">
      <div class="item2">
        <?php
        menu("daftar_program");
        ?>
        <!-- <div style="display: inline-block; justify-content: center; margin-bottom: 0.5rem;">
  <button class="button2" onclick="submitFormClusterPage()">Daftar Cluster </button>
  <button class="button2" style="color: #00008B;" onclick="submitFormProgramPage()">Daftar Program </button>
</div> -->

        <form action="programTabelObserverMinistry.php" id="programFilter" style="display: inline-block;" method="get">
          <div>
            <label for="id_cluster">Cluster:</label>
            <select name="id_cluster" id="id_cluster" class="form-control select2" required>
              <option value="" selected disabled hidden>Select</option>
              <?php
              if (isset($_GET['id_cluster']) && $_GET['id_cluster'] != "allCluster") {
                echo "<option value='allCluster'>Semua Cluster</option>";
              } else {
                echo "<option value='allCluster' selected>Semua Cluster</option>";
              }
              if (isset($_GET['id_cluster'])) {
                $filterCluster = $_GET['id_cluster'];
              } else {
                $filterCluster = "allCluster";
              }
              $idClusterArray = idListTable("tb_cluster");
              foreach ($idClusterArray as $id_cluster) {
                $clusterInfo = parentFromId($id_cluster, "tb_cluster");
                $cluster = $clusterInfo['cluster'];
                if (isset($_GET['id_cluster']) && $_GET['id_cluster'] == $id_cluster) {
                  echo "<option value='$id_cluster' selected>$cluster</option>";
                } else {
                  echo "<option value='$id_cluster'>$cluster</option>";
                }
              }
              ?>
            </select>
            <script>
              // Initialize Select2 with options
              // $('#id_cluster').select2({
              //   width: '200px',
              //   height: '200px',
              //   overflow- y: 'auto',
              //   placeholder: 'Select an option',
              //   allowClear: true
              // });
            </script>
          </div>
          <button type="submit" style="background-color: #FA8072; display: inline-block;">Filter</button>
        </form>

        <?php
        if (isset($_GET['id_cluster'])) {
          $id_cluster = $_GET['id_cluster'];
        } else {
          $id_cluster = "allCluster";
        }

        $arrayInstansi = array();

        $arrayInstansi[] = $userMinistry;

        $idProgramFilter_array = array();
        $idClusterArray = array();
        if ($id_cluster == "allCluster") {
          $idClusterArray = idListTable("tb_cluster");
        } else {
          $idClusterArray[] = $id_cluster;
        }
        foreach ($idClusterArray as $id_cluster) {
          $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
          $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
          if ($arrayInstansi[0] != "allInstansi") {
            $indexInstansi = 0;
            foreach ($arrayInstansi as $id_instansi) {
              if ($indexInstansi == 0) {
                $sqlProgramRecent = $sqlProgramRecent . " AND (instansi_terkait LIKE '%" . $id_instansi . "%'";
              } else {
                $sqlProgramRecent = $sqlProgramRecent . " OR instansi_terkait LIKE '%" . $id_instansi . "%'";
              }
              $indexInstansi++;
            }
            $sqlProgramRecent = $sqlProgramRecent . ")";
          }
          $resultProgramRecent = $conn->query($sqlProgramRecent);
          if ($resultProgramRecent->num_rows > 0) {
            while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
              array_push($idProgramFilter_array, $rowProgramRecent['id']);
            }
          }
        }

        ?>

        <div class="container-fluid mt-3">
          <div class="grid-1">
            <h4>Daftar Program</h4>
            <br>
          </div>

          <!-- Filter -->


          <p class="text-black" style="display: inline-block;">
            <?php
            // if ($filter['id_cluster'] == "allCluster") {
            //   $cluster = "allCluster";
            // } else {
            
            //   $rowCluster = parentFromId($filter['id_cluster'], "tb_cluster");
            //   if (isset($rowCluster['cluster'])) {
            //     $cluster = $rowCluster['cluster'];
            //   } else {
            //     $cluster = "0 data";
            //   }
            // }
            
            if ($filterCluster != "allCluster") {
              $clusterInfo = parentFromId($filterCluster, "tb_cluster");
              if (isset($clusterInfo['cluster'])) {
                $cluster = $clusterInfo['cluster'];
              } else {
                $cluster = "Invalid cluster";
              }
            } else {
              $cluster = "Semua Cluster";
            }

            if ($arrayInstansi[0] != "allInstansi") {
              $indexInstansi = 0;
              $instansiString = "Invalid Instansi";
              foreach ($arrayInstansi as $id_instansi) {
                $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");
                if (isset($instansiInfo['instansi'])) {
                  if ($indexInstansi == 0) {
                    $instansiString = $instansiInfo['instansi'];
                  } else {
                    $instansiString = $instansiString . ", " . $instansiInfo['instansi'];
                  }
                  $indexInstansi++;
                }

              }
            } else {
              $instansiString = "Semua Instansi";
            }

            echo "Filter: " . $cluster . " / " . $instansiString;
            ?>
          </p>

          <?php

          foreach ($idClusterArray as $id_cluster) {
            $rowCluster = parentFromId($id_cluster, "tb_cluster");
            if (isset($rowCluster['cluster'])) {
              $cluster = $rowCluster['cluster'];
            } else {
              $cluster = "0 data";
              continue;
            }
            echo "<h4 class='text-black'><br>Cluster: " . $cluster . "</h4><br>";

            $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
            $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
            if ($arrayInstansi[0] != "allInstansi") {
              $indexInstansi = 0;
              foreach ($arrayInstansi as $id_instansi) {
                if ($indexInstansi == 0) {
                  $sqlProgramRecent = $sqlProgramRecent . " AND (instansi_terkait LIKE '%" . $id_instansi . "%'";
                } else {
                  $sqlProgramRecent = $sqlProgramRecent . " OR instansi_terkait LIKE '%" . $id_instansi . "%'";
                }
                $indexInstansi++;
              }
              $sqlProgramRecent = $sqlProgramRecent . ")";
            }

            $resultProgramRecent = $conn->query($sqlProgramRecent);
            echo "<div style='width:100%; overflow-x:auto;'>";
            if ($resultProgramRecent->num_rows > 0) {
              echo "<table class='example display' style='width:100%'>";
              echo "<thead>";

              $sqlColName = "SELECT colName1,type1 FROM tb_colname_program WHERE id='$id_cluster'";
              $resultColName = $conn->query($sqlColName);
              if ($resultColName->num_rows > 0) {
                $arrayColTb = $resultColName->fetch_assoc();
              }

              $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
              $arrayColName = explode(", ", $arrayColName);

              $arrayColType = str_replace("'", "", $arrayColTb['type1']);
              $arrayColType = explode(", ", $arrayColType);

              echo "  <tr>";


              $child = 0;
              $maxChild = 0;
              $indexProgram = 0;
              foreach ($arrayColName as $index => $colName) {
                if ($indexProgram == 2) {
                  echo "    <th>Indikator & Kegiatan</th>";
                }
                $indexProgram++;
                if ($colName == "id_cluster" || $colName == "flag_active") {
                  continue;
                } else if ($colName == "penanggung_jawab_info") {
                  echo "<th>PENANGGUNG JAWAB NAMA</th>";
                  echo "<th>PENANGGUNG JAWAB POSISI</th>";
                  echo "<th>PENANGGUNG JAWAB HP</th>";
                  echo "<th>PENANGGUNG JAWAB EMAIL</th>";
                  continue;
                } else if ($child > 0) {
                  $child--;
                  continue;
                } else if (strpos($arrayColType[$index], "arent") != false) {
                  preg_match_all('!\d+!', $arrayColType[$index], $matches);
                  $numbers = $matches[0];
                  if (isset($numbers[0])) {
                    $child = $numbers[0];
                    $maxChild = max($maxChild, $numbers[0]);
                  }
                }
                $colNameEdited = convertSqlColName($colName);

                echo "<th>$colNameEdited</th>";
              }
              echo "  </tr>";
              echo "</thead>";

              $sqlColName = "SELECT colName1,type1 FROM tb_colname_program WHERE id='$id_cluster'";
              $resultColName = $conn->query($sqlColName);

              if ($resultColName->num_rows > 0) {
                $arrayColTb = $resultColName->fetch_assoc();
              }
              //$arrayColTb = parentFromId($id_cluster, "tb_colname_program");
              $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
              $arrayColName = explode(", ", $arrayColName);

              $arrayColType = str_replace("'", "", $arrayColTb['type1']);
              $arrayColType = explode(", ", $arrayColType);

              echo "<tbody>";


              $sqlColName = "SELECT colName1,type1 FROM tb_colname_program WHERE id='$id_cluster'";
              $idTbProgram = array();
              while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
                array_push($idTbProgram, $rowProgramRecent['id']);
                // array_push($idProgramFilter_array, $rowProgramRecent['id']);
              }
              foreach ($idTbProgram as $id_program) {
                echo "  <tr>";
                $sqlCountIndikator = "SELECT * FROM tb_indikator WHERE id_program='$id_program' AND flag_active=1";
                $indikatorCount = countNum($sqlCountIndikator);

                $parameterIndikator = array("id_program" => $id_program);
                $idIndikatorArray = idListTable("tb_indikator", $parameterIndikator);
                $kegiatanCount = 0;
                foreach ($idIndikatorArray as $id_indikator) {
                  $sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE id_indikator='$id_indikator' AND flag_active=1";
                  $kegiatanCount += countNum($sqlCountKegiatan);
                }




                $rowTbProgram = parentFromId($id_program, "tb_program_$id_clusterEdited");

                $child = 0;
                $indexLoop = -1;
                $indexProgram = 0;
                foreach ($rowTbProgram as $key => $colName) {
                  if ($indexProgram == 2) {
                    echo "<td>";
                    echo "<div>";
                    echo "  <a href=\"indikatorTabelObserverMinistry.php?id_program=$id_program\"
                        onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                        onmouseout=\"this.style.backgroundColor='white'; \">";
                    // echo "    <td style='cursor: pointer;'
                    //             onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                    //             onmouseout=\"this.style.backgroundColor='white'; \"
                    //             ><u><b>Indikator:</b> $indikatorCount</u></td>";
                    echo "    <p><u><b>Indikator:</b> $indikatorCount</u></p>";
                    echo "  </a>";
                    echo "  <a href=\"kegiatanTabelObserverMinistry.php?id_program=$id_program\"
                        onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                        onmouseout=\"this.style.backgroundColor='white'; \">";
                    // echo "    <td style='cursor: pointer;'
                    //             onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                    //             onmouseout=\"this.style.backgroundColor='white'; \"
                    //             ><u><b>Kegiatan:</b> $kegiatanCount</u></td>";
                    echo "<p><u><b>Kegiatan:</b> $kegiatanCount</u></p>";
                    echo "  </a>";
                    echo "</div>";
                    echo "</td>";
                  }
                  $indexProgram++;
                  $indexLoop++;
                  if ($arrayColType[$indexLoop] == "pic") {
                    $colValueArray = explode(",", $colName);
                    //$sizeColValue = sizeof($colValueArray);
                    $colName = "";
                    $indexPIC = 0;
                    echo "<td>";
                    echo "<div>";
                    $sizePic = sizeof($colValueArray);
                    $indexProgramPic = 0;
                    foreach ($colValueArray as $colValue) {
                      if($indexProgramPic == $sizePic-1){break;}
                      $arrayPIC = parentFromId($colValue, "tb_master_kementrian");
                      echo "<p>" . $arrayPIC['instansi'] . "</p>";
                      $indexProgramPic++;
                    }
                    echo "</div>";
                    echo "</td>";
                    continue;

                    // $arrayPIC = parentFromId($colName, "tb_master_kementrian");
                    // $colName = $arrayPIC['instansi'];
                  } else if ($key == "id_cluster" || $key == "flag_active") {
                    continue;
                  } else if ($key == "penanggung_jawab_info") {
                    $penanggungArray = array();
                    $sqlPenanggung = "SELECT * FROM tb_master_penanggung_jawab WHERE flag_active=1 AND id_div = '$id_program'";
                    $resultPenanggung = $conn->query($sqlPenanggung);
                    if ($resultPenanggung->num_rows > 0) {
                      while ($rowPenanggung = $resultPenanggung->fetch_assoc()) {
                        array_push($penanggungArray, $rowPenanggung['id']);
                      }
                    }
                    penanggungJawab($penanggungArray);
                  } else if ($child > 0) {
                    if ($child > 1) {
                      echo "<p style='border-bottom: 1px solid black;'><b>$key:</b> $colName</p>";
                    } else {
                      echo "<p><b>$key:</b> $colName</p>";
                      echo "</td>";
                    }

                    //else{echo "<br>";}
                    $child--;
                  } else if (strpos($arrayColType[$indexLoop], "arent") != false) {
                    preg_match_all('!\d+!', $colName, $matches);
                    $numbers = $matches[0];
                    if (isset($numbers[0])) {
                      $child = $numbers[0];
                    }
                    if ($child > 0) {
                      echo "<td>";
                    }

                  } else {
                    echo "<td>$colName</td>";
                  }
                }
                echo "</tr>";
              }
              echo "</tbody>";
              echo "</table>";

            }
            else{echo "<p>0 data</p>";}
            echo "</div>";
          }
          // foreach ($clusterDashboard as $id_cluster) {
          



          //   $filter['id_cluster'] = $id_cluster;
          //   $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
          
          //   $where = whereMaker($formType, $filter, "tb_program_$id_clusterEdited");
          
          //   // if ($filter['status'] == "Selesai") {
          //   //   $sqlSelesai = $where . " ORDER BY id ASC";
          //   // } else {
          //   //   $sqlSelesai = $where . " AND status='Selesai'" . " ORDER BY id ASC";
          //   // }
          
          //   $result = $conn->query($where);
          //   echo "<div style='width:100%; overflow-x:auto;'>";
          //   if ($result->num_rows > 0) {
          //     echo "<table class='example display' style='width:100%'>";
          //     echo "<thead>";
          

          //     $parameterFilterProgram = array("id_cluster" => $filter["id_cluster"]);
          //     $sqlDataProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id_cluster='$id_cluster'";
          //     $idTbProgram = idListTable("tb_program_$id_clusterEdited", $parameterFilterProgram);
          
          //   }
          //   echo "</div>";
          //   echo "<hr style='border-top: 4px solid #5A5A5A;'>";
          // }
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- isi disini -->


  <?php include "filterFormDashboard.php"; ?>

  </div>
</body>

</html>