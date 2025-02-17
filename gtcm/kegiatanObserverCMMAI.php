<?php

session_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
  header('location:login.html');
} else if ($_SESSION['role'] != 'Observer CMMAI') {
  header("Location: accessDenied.php");
}
include "connection.php";
include "function/myFunc.php";

if (isset($_GET['id_program'])) {
  $_SESSION['id_program'] = $_GET['id_program'];
}

//$id_program = $_SESSION['id_program'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "head.html"; ?>
  <!-- Template Main CSS Tabel -->
  <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">

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
      //$program = $_SESSION['program'];
      //$id_program = $_SESSION['id_program'];
      //$id_cluster = $_SESSION['id_cluster'];      
      // salah
      
      if (isset($_GET['id_indikator']) && $_GET['id_indikator'] != "allIndikator") {
        $id_indikator = $_GET['id_indikator'];
        $id_cluster = explode("_", $id_indikator)[0];
        $id_program = explode("_", $id_indikator)[0] . "_" . explode("_", $id_indikator)[1];
        $id_programSubStr = $id_program;
        $filterIndikator = $id_indikator;
        $filterProgram = $id_program;
        $filterCluster = $id_cluster;
        $accessFrom = "indikator";
      } else if (isset($_GET['id_program']) && $_GET['id_program'] != "allProgram") {
        $id_programSubStr = $_GET['id_program'];
        $filterProgram = $_GET['id_program'];

        $filterIndikator = "allIndikator";

        $id_cluster = explode("_", $id_programSubStr)[0];
        $filterCluster = $id_cluster;
        $accessFrom = "program";
      } else if (isset($_GET['id_cluster']) && $_GET['id_cluster'] != "allCluster") {
        $id_cluster = $_GET['id_cluster'];
        $filterCluster = $id_cluster;
        $filterProgram = "allProgram";
        $filterIndikator = "allIndikator";
        $accessFrom = "cluster";
      } else {
        $filterIndikator = "allIndikator";
        $filterCluster = "allCluster";
        $filterProgram = "allProgram";
        $id_programSubStr = "";
        $id_cluster = "allCluster";
        $accessFrom = "dashboard";
      }

      // if (isset($_GET['id_indikator']) && $_GET['id_indikator'] != "allIndikator") {
      //   $id_indikator = $_GET['id_indikator'];
      //   $id_cluster = explode("_", $id_indikator)[0];
      //   $id_program = explode("_", $id_indikator)[0] . "_" . explode("_", $id_indikator)[1];
      //   $id_programSubStr = $id_program;
      //   $accessFrom = "indikator";
      // } else if (isset($_GET['id_program']) && $_GET['id_program'] != "allProgram") {
      //   $id_programSubStr = $_GET['id_program'];
      //   $id_cluster = explode("_", $_GET['id_program'])[0];
      //   $accessFrom = "program";
      //   $id_indikator = "";
      
      // } else if (isset($_GET['id_cluster']) && $_GET['id_program'] != "allCluster") {
      //   $id_cluster = $_GET['id_cluster'];
      //   $id_programSubStr = $id_cluster;
      //   $accessFrom = "cluster";
      
      //   $id_program = "";
      //   $id_indikator = "";
      // } else {
      //   $id_programSubStr = "";
      //   $id_cluster = "allCluster";
      //   $accessFrom = "dashboard";
      //   $id_program = "";
      //   $id_indikator = "";
      // }
      
      $clusterDashboard = array();
      if ($filterCluster == "allCluster") {
        $clusterDashboard = idListTable("tb_cluster");
      } else {
        array_push($clusterDashboard, $filterCluster);
      }

      //$id_indikator = $_SESSION['id_indikator'];
      ?>
      <?php

      // $sql = "SELECT indikator, id_program FROM tb_indikator WHERE id = '$id_indikator'";
      // $result = $conn->query($sql);
      
      // if ($result->num_rows > 0) {
      //   while ($row = $result->fetch_assoc()) {
      //     $indikator = $row['indikator'];
      //     $_SESSION['indikator'] = $indikator;
      //     $id_program = $row['id_program'];
      //     $_SESSION['id_program'] = $id_program;
      //   }
      // }
      
      // $sql = "SELECT program, id_cluster FROM tb_program WHERE id_program = '$id_program'";
      // $result = $conn->query($sql);
      
      // if ($result->num_rows > 0) {
      //   while ($row = $result->fetch_assoc()) {
      //     $program = $row['program'];
      //     $_SESSION['program'] = $program;
      //     $id_cluster = $row['id_cluster'];
      //     $_SESSION['id_cluster'] = $id_cluster;
      //   }
      // }
      


      // $searchFeature = $_GET['search'] ?? "";
      

      // $formType = $_GET['formType'] ?? "filter";
      // if ($formType == "search") {
      //   $where = "SELECT * FROM tb_kegiatan 
      //           WHERE id_indikator = '$id_indikator' AND flag_active=1 AND kegiatan LIKE '%" . $searchFeature . "%'";
      //   $where = $where . " ORDER BY id_kegiatan ASC";
      // } else {
      //   $where = "SELECT * FROM tb_kegiatan WHERE id_indikator = '$id_indikator' AND flag_active=1";
      //   $where = $where . " ORDER BY id_kegiatan ASC";
      // }
      ?>
    </div>

    <?php include "headerNavigation.php"; ?>


    <!-- isi disini -->
    <div class="grid-container">
      <div class="item2">
        <?php menu("daftar_kegiatan"); ?>

        <form action="kegiatanObserverCMMAI.php" id="kegiatanFilter" style="display: inline-block;" method="get">
          <div>
            <label for="id_cluster">Cluster:</label>
            <select name="id_cluster" id="id_cluster" class="form-control select2" onchange="filterData('cluster')">
              <option value="allCluster" selected disabled hidden>Select</option>
              <?php
              if ($filterCluster != "allCluster") {
                echo "<option value='allCluster'>Semua Cluster</option>";
              } else {
                echo "<option value='allCluster' selected>Semua Cluster</option>";
              }
              $idClusterArray = idListTable("tb_cluster");
              foreach ($idClusterArray as $id_cluster) {
                $clusterInfo = parentFromId($id_cluster, "tb_cluster");
                $cluster = $clusterInfo['cluster'];
                if ($filterCluster == $id_cluster) {
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
                            //     width: '200px',
                            //     placeholder: 'Select an option',
                            //     allowClear: true
                            // });
            </script>
          </div>

          <div>
            <label for="id_program">Program:</label>
            <select name="id_program" id="id_program" class="form-control select2" required
              onchange="filterData('program')">
              <?php
              $idClusterArray = array();
              if ($filterCluster != "allCluster") {
                $id_cluster = $filterCluster;
                $idClusterArray[] = $id_cluster;

              } else {
                $id_cluster = "allCluster";
                $idClusterArray = idListTable("tb_cluster");
              }
              if ($filterProgram != "allProgram") {
                echo "<option value='allProgram'>Semua Program</option>";
              } else {
                echo "<option value='allProgram' selected>Semua Program</option>";
              }

              foreach ($idClusterArray as $id_cluster) {
                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                $sqlProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
                $resultProgram = $conn->query($sqlProgram);
                if ($resultProgram->num_rows > 0) {
                  while ($rowProgram = $resultProgram->fetch_assoc()) {
                    $indexProgram = 0;
                    $id_program = $rowProgram['id'];
                    foreach ($rowProgram as $colName => $value) {
                      if ($indexProgram == 2) {
                        if ($filterProgram == $id_program) {
                          echo "<option value='$id_program' selected>$value</option>";
                        } else {
                          echo "<option value='$id_program'>$value</option>";
                        }
                      }
                      $indexProgram++;
                    }
                  }
                }
              }
              ?>

            </select>
            <script>
                            // Initialize Select2 with options
                            // $('#id_cluster').select2({
                            //     width: '200px',
                            //     placeholder: 'Select an option',
                            //     allowClear: true
                            // });
            </script>
          </div>

          <div>
            <label for="id_indikator">Indikator:</label>
            <select name="id_indikator" id="id_indikator" class="form-control select2" required>
              <?php
              $idClusterArray = array();
              if ($filterProgram != "allProgram") {
                $idSubStr = $filterProgram;
              } else if ($filterCluster != "allCluster") {
                $idSubStr = $filterCluster;
                // $id_cluster = $_GET['id_cluster'];
              } else {
                // $id_cluster = "allCluster";
                // $idClusterArray = idListTable("tb_cluster");
                $idSubStr = "";
              }
              if ($filterIndikator != "allIndikator") {
                echo "<option value='allIndikator'>Semua Indikator</option>";
              } else {
                echo "<option value='allIndikator' selected>Semua Indikator</option>";
              }

              $sqlIndikator = "SELECT * FROM tb_indikator WHERE flag_active=1 AND id LIKE '%" . $idSubStr . "%'";
              $resultIndikator = $conn->query($sqlIndikator);
              if ($resultIndikator->num_rows > 0) {
                while ($rowIndikator = $resultIndikator->fetch_assoc()) {
                  $id_indikator = $rowIndikator['id'];
                  $indikator = $rowIndikator['indikator'];
                  if ($filterIndikator == $id_indikator) {
                    echo "<option value='$id_indikator' selected>$indikator</option>";
                  } else {
                    echo "<option value='$id_indikator'>$indikator</option>";
                  }

                }
              }

              ?>

            </select>
            <script>
                            // Initialize Select2 with options
                            // $('#id_cluster').select2({
                            //     width: '200px',
                            //     placeholder: 'Select an option',
                            //     allowClear: true
                            // });
            </script>
          </div>

          <div>
            <label for="instansi_terkait">Instansi:</label>
            <select id='instansi_terkait' name='instansi_terkait[]' class='selectpicker' multiple
              aria-label='Pilih Instansi' data-live-search='true' title="Semua Instansi">
              <option value='allInstansi'>Semua Instansi</option>
              <?php
              $otherInstansiBool = 0;
              if (isset($_GET['instansi_terkait'])) {
                $arrayInstansi = $_GET['instansi_terkait'];
                if ($arrayInstansi[0] == "allInstansi") {
                  $otherInstansiBool = 1;
                }
              }
              $arrayPIC = idListTable("tb_master_kementrian");
              foreach ($arrayPIC as $idPIC) {
                $picInfo = parentFromId($idPIC, "tb_master_kementrian");
                if (isset($_GET['instansi_terkait']) && $otherInstansiBool == 0) {
                  $arrayInstansi = $_GET['instansi_terkait'];
                  $posInstansi = array_search($idPIC, $arrayInstansi);
                  if ($posInstansi > 0) {
                    echo "<option value='" . $idPIC . "' selected>" . $picInfo['instansi'] . "</option>";
                  } else if ($posInstansi == 0 && $arrayInstansi[0] == $idPIC) {
                    echo "<option value='" . $idPIC . "' selected>" . $picInfo['instansi'] . "</option>";
                  } else {
                    echo "<option value='" . $idPIC . "'>" . $picInfo['instansi'] . "</option>";
                  }

                } else {
                  echo "<option value='" . $idPIC . "'>" . $picInfo['instansi'] . "</option>";
                }
              }
              ?>
            </select>
          </div>
          <button type="submit" style="background-color: #FA8072; display: inline-block;">Filter</button>
        </form>

        <form id="changeFilter">

          <input type="hidden" id="valueOnChange" name="valueOnChange" value="">
        </form>
        <script>
          function filterData(type) {
            if (type == "cluster") {
              filterValue = document.getElementById("id_cluster").value;
              urlFilter = `kegiatanObserverCMMAI.php?id_cluster=${filterValue}`;
            } else if (type == "program") {
              filterValue1 = document.getElementById("id_cluster").value;
              filterValue2 = document.getElementById("id_program").value;
              urlFilter = `kegiatanObserverCMMAI.php?id_cluster=${filterValue1}&id_program=${filterValue2}`;
            } else {
              urlFilter = "";
            }

            //var selectedOption = document.getElementById("id_cluster").value;
            // document.getElementById("kegiatanFilter").submit();

            if (urlFilter !== "") {
              window.location.href = urlFilter;
            }
          }
        </script>

        <div class="container-fluid mt-3">
          <div class='grid-1'>
            <h4><b>Daftar Kegiatan</b></h4>
            <?php
            $indexCluster = 0;
            foreach ($clusterDashboard as $id_cluster) {
              $clusterInfo = parentFromId($id_cluster, "tb_cluster");
              if (!isset($clusterInfo['cluster'])) {
                continue;
              }
              $cluster = $clusterInfo['cluster'];
              echo "  <h4 class='text-black'>Cluster: " .
                $cluster .
                "</h4>";

              $sqlColName = "SELECT colName1 FROM tb_colname_program WHERE id='$id_cluster'";
              $resultColName = $conn->query($sqlColName);

              if ($resultColName->num_rows > 0) {
                $arrayColTb = $resultColName->fetch_assoc();
              }

              $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
              $arrayColName = explode(", ", $arrayColName);

              $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
              $id_programList = array();
              $programList = array();

              if ($filterProgram != "allProgram") {
                $sqlProgram = "SELECT id,$arrayColName[2] FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id ='$filterProgram'";
              } else {
                $sqlProgram = "SELECT id,$arrayColName[2] FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id_cluster ='$id_cluster'";
              }

              $arrayInstansi = array();
              $otherInstansiBool = 0;
              if (isset($_GET['instansi_terkait'])) {
                $arrayInstansi = $_GET['instansi_terkait'];
                if ($arrayInstansi[0] == "allInstansi") {
                  $otherInstansiBool = 1;
                }
              } else {
                $arrayInstansi[] = "allInstansi";
                $otherInstansiBool = 1;
              }
              if ($arrayInstansi[0] != "allInstansi") {
                $indexInstansi = 0;
                foreach ($arrayInstansi as $id_instansi) {
                  if ($indexInstansi == 0) {
                    $sqlProgram = $sqlProgram . " AND (instansi_terkait LIKE '%" . $id_instansi . "%'";
                  } else {
                    $sqlProgram = $sqlProgram . " OR instansi_terkait LIKE '%" . $id_instansi . "%'";
                  }
                  $indexInstansi++;
                }
                $sqlProgram = $sqlProgram . ")";
              }

              $resultProgram = $conn->query($sqlProgram);
              if ($resultProgram->num_rows > 0) {
                while ($rowProgram = $resultProgram->fetch_assoc()) {
                  array_push($programList, $rowProgram[$arrayColName[2]]);
                  array_push($id_programList, $rowProgram['id']);
                }
              }

              $indexProgram = 0;
              foreach ($id_programList as $id_program) {
                echo "<h4 class='text-black'>Program: "
                  . $programList[$indexProgram] .
                  "</h4>";

                $id_indikatorList = array();
                if ($filterIndikator != "allIndikator") {
                  array_push($id_indikatorList, $filterIndikator);
                } else {
                  $parameterFilterIndikator = array("id_program" => $id_program);
                  $id_indikatorList = idListTable("tb_indikator", $parameterFilterIndikator);
                }

                $indexIndikator = 0;
                foreach ($id_indikatorList as $id_indikator) {
                  $indikatorInfo = parentFromId($id_indikator, "tb_indikator");
                  echo "<h4 class='text-black'>Indikator: "
                    . $indikatorInfo['indikator'] .
                    "</h4>";

                  $sqlKegiatan = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id_indikator = '$id_indikator'";
                  $resultSqlKegiatan = $conn->query($sqlKegiatan);
                  echo "<div style='width:100%; overflow-x:auto;'>";
                  if ($resultSqlKegiatan->num_rows > 0) {
                    echo "<table class='example' class='display' style='width:100%'>";
                    echo "<thead>";

                    $indexLoopKegiatan = 0;
                    while ($kegiatanInfo = $resultSqlKegiatan->fetch_assoc()) {
                      if ($indexLoopKegiatan == 0) {
                        echo "<tr>";
                        echo "  <th>Detail</th>";
                        $child = 0;
                        foreach ($kegiatanInfo as $colName => $kegiatanValue) {
                          if ($colName == "id_indikator" || $colName == "flag_active") {
                            continue;
                          } else if ($colName == "penanggung_jawab_info") {
                            echo "<th>PENANGGUNG JAWAB NAMA</th>";
                            echo "<th>PENANGGUNG JAWAB POSISI</th>";
                            echo "<th>PENANGGUNG JAWAB HP</th>";
                            echo "<th>PENANGGUNG JAWAB EMAIL</th>";
                          } else {
                            echo "<th>$colName</th>";
                          }
                        }
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                      }

                      $id_kegiatan = $kegiatanInfo['id'];

                      $currentDate = date('Y-m-d H:i:s'); // format: yyyy-mm-dd hh:mm:ss
                      $status = $kegiatanInfo['status'];
                      $boolLate = 0;
                      if ($kegiatanInfo['tanggal_berakhir'] < $currentDate) {
                        if ($status != "Selesai") {
                          echo "<tr style='background-color: rgb(245, 206, 203);'>";
                          $boolLate = 1;
                        } else {
                          echo "<tr>";
                        }
                      } else {
                        echo "<tr>";
                      }

                      $problemArray = array();
                      $sqlProblem = "SELECT * FROM tb_kegiatanproblem WHERE flag_active=1 AND id_kegiatan='$id_kegiatan'";
                      $resultProblem = $conn->query($sqlProblem);
                      if ($resultProblem->num_rows > 0) {
                        while ($rowProblem = $resultProblem->fetch_assoc()) {
                          array_push($problemArray, $rowProblem['problem']);
                        }
                      }

                      //$sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE id_indikator=\"$id_indikator\"";
                      //$kegiatanCount = countNum($sqlCountKegiatan);
            
                      //echo "  <td onClick=\"location.href='indikatorTabelSuperadmin.php?id_program=$id_program'\">";
            
                      if ($boolLate == 1) {
                        echo "    <td onClick=\"location.href='kegiatanDetail.php?id_kegiatan=$id_kegiatan'\"
                                            style='cursor: pointer;'
                                            onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                                            onmouseout=\"this.style.backgroundColor='rgb(245, 206, 203)'; \"
                                            ><u> more</u></td>";
                      } else {
                        echo "    <td onClick=\"location.href='kegiatanDetail.php?id_kegiatan=$id_kegiatan'\"
                                            style='cursor: pointer;'
                                            onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                                            onmouseout=\"this.style.backgroundColor='white'; \"
                                            ><u> more</u></td>";
                      }
                      //echo "  </tr>";
            
                      $child = 0;
                      foreach ($kegiatanInfo as $colName => $kegiatanValue) {
                        if ($colName == "id_indikator" || $colName == "flag_active") {
                          continue;
                        } else if ($colName == "penanggung_jawab_info") {
                          $penanggungArray = array();
                          $sqlPenanggung = "SELECT * FROM tb_master_penanggung_jawab WHERE flag_active=1 AND id_div = '$id_kegiatan'";
                          $resultPenanggung = $conn->query($sqlPenanggung);
                          if ($resultPenanggung->num_rows > 0) {
                            while ($rowPenanggung = $resultPenanggung->fetch_assoc()) {
                              array_push($penanggungArray, $rowPenanggung['id']);
                            }
                          }
                          penanggungJawab($penanggungArray);

                          // $child=3;
                          // echo "<td>";
                          // echo "<div>";
                        } else if ($colName == "problem") {
                          echo "<td>";
                          problem($problemArray);
                          echo "</td>";
                        } else if ($colName == "tanggal_berakhir" || $colName == "tanggal_mulai") {
                          $dateText = dateToText($kegiatanValue);
                          echo "<td>$dateText</td>";
                        } else {
                          echo "<td>$kegiatanValue</td>";
                        }
                      }
                      echo "</tr>";
                      $indexLoopKegiatan++;

                    }
                    echo "</tbody>";

                    echo "</table>";
                  } else {
                    echo "0 data";
                  }
                  echo "</div>";
                  echo "<hr style='border-top: 2px dotted #5A5A5A;'>";
                  $indexIndikator++;
                }
                if ($indexIndikator == 0) {
                  echo "0 data";
                  echo "<div class='searchTable'>";
                  // echo "  <button style='background-color: green; order-color: rgb(68, 151, 68); color: white; 
                  //           border-radius:3px' onclick=\"window.location.href='addIndikator.php?id_program=$id_program'\">
                  //           + Add Indikator
                  //         </button>";
                  echo "</div>";
                }
                $indexProgram++;
                echo "<hr style='border-top: 3px dashed #5A5A5A;'>";
              }
              if ($indexProgram == 0) {
                echo "<p>0 data</p>";
              }
              echo "<hr style='border-top: 4px solid #5A5A5A;'>";
              $indexCluster++;
            }
            if ($indexCluster == 0) {
              echo "<p>0 data</p>";
            }
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
    </div>
</body>

</html>