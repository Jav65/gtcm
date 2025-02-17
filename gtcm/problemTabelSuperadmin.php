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
            //include('security.php');
            
            if (!isset($_SESSION['role'])) {
                header('location:login.html');
            } else if ($_SESSION['role'] != 'Superadmin') {
                header("Location: accessDenied.php");
            }
            include "connection.php";
            include "function/myFunc.php";

            if (isset($_GET['id_program'])) {
                $_SESSION['id_program'] = $_GET['id_program'];
            }

            //$id_program = $_SESSION['id_program'];
            
            ?>
            <?php
            //$program = $_SESSION['program'];
            //$id_program = $_SESSION['id_program'];
            //$id_cluster = $_SESSION['id_cluster'];      
            if (isset($_GET['id_indikator']) && $_GET['id_indikator'] != "allIndikator") {
                $id_indikator = $_GET['id_indikator'];
                $id_cluster = explode("_", $id_indikator)[0];
                $id_program = explode("_", $id_indikator)[0] . "_" . explode("_", $id_indikator)[1];
                $id_programSubStr = $id_program;
                $accessFrom = "indikator";
            } else if (isset($_GET['id_program']) && $_GET['id_program'] != "allProgram") {
                $id_programSubStr = $_GET['id_program'];
                $id_cluster = explode("_", $_GET['id_program'])[0];
                $accessFrom = "program";
                $id_indikator = "";

            } else if (isset($_GET['id_cluster']) && $_GET['id_cluster'] != "allCluster") {
                $id_cluster = $_GET['id_cluster'];
                $id_programSubStr = $id_cluster;
                $accessFrom = "cluster";

                $id_program = "";
                $id_indikator = "";
            } else {
                $id_programSubStr = "";
                $id_cluster = "allCluster";
                $accessFrom = "dashboard";
                $id_program = "";
                $id_indikator = "";
            }

            $clusterDashboard = array();
            if ($id_cluster == "allCluster") {
                $clusterDashboard = idListTable("tb_cluster");
            } else {
                array_push($clusterDashboard, $id_cluster);
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
                <?php menu("problem"); ?>
                <form action="problemTabelSuperadmin.php" id="programFilter" style="display: inline-block;"
                    method="get">
                    <div>
                        <label for="id_cluster">Cluster:</label>
                        <select id='id_cluster' name='id_cluster' class='selectpicker' aria-label='Pilih Cluster'
                            data-live-search='true' data-max-options="1" title="Semua Cluster">
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

                        <!-- <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
            <script
              src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script> -->
                    </div>
                    <button type="submit" style="background-color: #FA8072; display: inline-block;">Filter</button>
                </form>

                <div class="container-fluid mt-3">
                    <div class='grid-1'>
                        <?php
                        if (isset($_GET['id_cluster'])) {
                            $id_cluster = $_GET['id_cluster'];
                        } else {
                            $id_cluster = "allCluster";
                        }

                        $arrayInstansi = array();
                        if (isset($_GET['instansi_terkait']) && $otherInstansiBool == 0) {
                            $arrayInstansiMasing = $_GET['instansi_terkait'];
                        } else {
                            $arrayInstansiMasing = idListTable("tb_master_kementrian");
                        }
                        // $LateInstansiArray = array();
                        $kegiatanLateInstansiArray = array();
                        $instansiNameArrayLate = array();

                        $instansiSize = sizeof($arrayInstansiMasing);
                        $kegiatanLateArray = array();
                        for ($indexInstansi = 0; $indexInstansi < $instansiSize; $indexInstansi++) {
                            $id_instansi = $arrayInstansiMasing[$indexInstansi];

                            $arrayInstansi = array($id_instansi);
                            $idProgramFilter_array = programFilterClusterInstansi($id_cluster, $arrayInstansi);

                            $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");

                            foreach ($idProgramFilter_array as $id_program) {
                                $currentDate = date('Y-m-d H:i:s'); // format: yyyy-mm-dd hh:mm:ss
                                $sqlCountLate = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND status !='Selesai' AND problem > 0";
                                $resultCountLate = $conn->query($sqlCountLate);
                                if ($resultCountLate->num_rows > 0) {
                                    while ($rowCountLate = $resultCountLate->fetch_assoc()) {
                                        if (array_search($rowCountLate['id'], $kegiatanLateArray) === false) {
                                            $kegiatanLateArray[] = $rowCountLate['id'];
                                        }
                                    }
                                }
                                // $problemCount += countNum($sqlCountProblem);
                        
                                // $sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND problem > 0";
                                // $kegiatanCount += countNum($sqlCountKegiatan);
                            }
                        }

                        $indexLoopKegiatan = 0;
                        echo "<div style='width:100%; overflow-x:auto;'>";
                        echo "<table  class='example display' style='width:100%'>";
                        foreach ($kegiatanLateArray as $id_kegiatan) {
                            $kegiatanInfo = parentFromId($id_kegiatan, "tb_kegiatan");

                            if ($indexLoopKegiatan == 0) {
                                echo "<thead>";
                                echo "<tr>";
                                echo "  <th>Aksi</th>";
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
                                        echo "<th>Instansi Terkait</th>";
                                    } else {
                                        echo "<th>$colName</th>";
                                    }
                                }
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                            }

                            $status = $kegiatanInfo['status'];

                            echo "<tr>";

                            //$sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE id_indikator=\"$id_indikator\"";
                            //$kegiatanCount = countNum($sqlCountKegiatan);
                        
                            echo "<td>";
                            echo "  <button type='button' onclick=\"window.location.href='updateKegiatan.php?id_kegiatan=$id_kegiatan'\"
                            class='btn btn-primary' style='margin: 5px 0 3px 0'>Update</button>";
                            echo "  <button type='button' onclick=\"window.location.href='delete_kegiatan.php?id_kegiatan=$id_kegiatan'\"
                            class='btn btn-danger' style='margin: 3px 0 5px 0'>Delete</i></button>";
                            $linkPenanggungJawab = "window.location.href='addPenanggungJawabKegiatan.php?id_div=$id_kegiatan'";
                            echo "  <button type='button' onclick=\"$linkPenanggungJawab\"
                            class='btn btn-info' style='margin: 3px 0 5px 0'>Add Penanggung Jawab</i></button>";

                            $linkProbEvi = "window.location.href='add_problem_evidence_page.php?id_kegiatan=$id_kegiatan'";
                            echo "  <button type='button' onclick=\"$linkProbEvi\"
                            class='btn btn-warning' style='margin: 3px 0 5px 0'>Add Problem & Evidence</i></button>";

                            echo "</td>";
                            //echo "  <td onClick=\"location.href='indikatorTabelSuperadmin.php?id_program=$id_program'\">";
                        
                            echo "    <td onClick=\"location.href='kegiatanDetail.php?id_kegiatan=$id_kegiatan'\"
                                        style='cursor: pointer;'
                                        onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                                        onmouseout=\"this.style.backgroundColor='white'; \"
                                        ><u> more</u></td>";

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


                                    $id_cluster = explode("_", $id_kegiatan)[0];
                                    $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                                    $id_program = explode("_", $id_kegiatan)[0] . "_" . explode("_", $id_kegiatan)[1];
                                    $sqlProgramProblem = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
                                    $resultProgramProblem = $conn->query($sqlProgramProblem);
                                    if ($resultProgramProblem->num_rows > 0) {
                                        while ($rowProgramProblem = $resultProgramProblem->fetch_assoc()) {
                                            $instansiProgramProblem = $rowProgramProblem['instansi_terkait'];
                                            $instansiValueArray = explode(",", $instansiProgramProblem);
                                            //$sizeColValue = sizeof($colValueArray);
                                            $indexPIC = 0;
                                            echo "<td>";
                                            echo "<div>";
                                            $sizePic = sizeof($instansiValueArray);
                                            $indexProgramPic = 0;
                                            foreach ($instansiValueArray as $instansiValue) {
                                                if ($indexProgramPic == $sizePic - 1) {
                                                    break;
                                                }
                                                $arrayPIC = parentFromId($instansiValue, "tb_master_kementrian");
                                                echo "<p>" . $arrayPIC['instansi'] . "</p>";
                                                $indexProgramPic++;
                                            }
                                            echo "</div>";
                                            echo "</td>";
                                        }

                                        // $arrayPIC = parentFromId($colName, "tb_master_kementrian");
                                        // $colName = $arrayPIC['instansi'];
                                    }
                                } else if ($colName == "problem") {
                                    $problemArray = array();
                                    $sqlProblem = "SELECT * FROM tb_kegiatanproblem WHERE flag_active=1 AND id_kegiatan='$id_kegiatan'";
                                    $resultProblem = $conn->query($sqlProblem);
                                    if ($resultProblem->num_rows > 0) {
                                        while ($rowProblem = $resultProblem->fetch_assoc()) {
                                            array_push($problemArray, $rowProblem['problem']);
                                        }
                                    }
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
                        if ($indexLoopKegiatan > 0) {
                            echo "</tbody>";
                        }
                        echo "</table>";
                        echo "</div>";


                        if ($indexLoopKegiatan == 0) {
                            echo "0 data";
                        }
                        ?>
                    </div>
                </div>

            </div>
            <!-- isi disini -->


            <div id="preloader"></div>

            <!-- Vendor JS Files -->
            <!-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
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