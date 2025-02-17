<!-- https://stackoverflow.com/questions/923885/capture-html-canvas-as-gif-jpg-png-pdf -->
<!-- testing dashboard -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
    <?php
    include "head.html";
    ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Material Design for Bootstrap</title>

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
    <div style="max-width: 1980px; height: 100%; margin: auto; background-color: rgb(194, 187, 187);">
        <div>
            <?php
            if (!isset($_SESSION['role'])) {
                header('location:login.html');
            } else if ($_SESSION['role'] != 'Operator Ministry') {
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


            if (isset($_GET['id_program']) && $_GET['id_program'] != "allProgram") {
                $id_programSubStr = $_GET['id_program'];
                $filterProgram = $_GET['id_program'];

                $id_cluster = explode("_", $id_programSubStr)[0];
                $filterCluster = $id_cluster;
                $accessFrom = "program";
            } else if (isset($_GET['id_cluster']) && $_GET['id_cluster'] != "allCluster") {
                $id_cluster = $_GET['id_cluster'];
                $filterCluster = $id_cluster;
                $filterProgram = "allProgram";
                $accessFrom = "cluster";
            } else {
                $filterCluster = "allCluster";
                $filterProgram = "allProgram";
                $id_programSubStr = "";
                $id_cluster = "allCluster";
                $accessFrom = "dashboard";
            }



            $clusterDashboard = array();
            if ($id_cluster == "allCluster") {
                $clusterDashboard = idListTable("tb_cluster");
            } else {
                array_push($clusterDashboard, $id_cluster);
            }
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <!-- isi disini -->
        <div class="grid-container">
            <div class="item2">
                <?php menu("daftar_indikator"); ?>

                <form action="indikatorTabelOperatorMinistry.php" id="indikatorFilter" style="display: inline-block;"
                    method="get">
                    <div>
                        <label for="id_cluster">Cluster:</label>
                        <select name="id_cluster" id="id_cluster" class="form-control select2"
                            onchange="filterData('cluster')">
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
                        <select name="id_program" id="id_program" class="form-control select2" required>
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

                    <button type="submit" style="background-color: #FA8072; display: inline-block;">Filter</button>
                </form>

                <form id="changeFilter">

                    <input type="hidden" id="valueOnChange" name="valueOnChange" value="">
                </form>

                <script>
                    function filterData(type) {
                        if (type == "cluster") {
                            filterValue = document.getElementById("id_cluster").value;
                            urlFilter = `indikatorTabelOperatorMinistry.php?id_cluster=${filterValue}`;
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
                        <h4><b>Daftar Indikator</b></h4>
                        <?php
                        foreach ($clusterDashboard as $id_cluster) {
                            $clusterInfo = parentFromId($id_cluster, "tb_cluster");
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

                            if ($accessFrom != "program") {
                                $sqlProgram = "SELECT id,$arrayColName[2] FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id_cluster ='$id_cluster'";
                            } else {
                                $sqlProgram = "SELECT id,$arrayColName[2] FROM tb_program_$id_clusterEdited WHERE flag_active=1 AND id ='$id_programSubStr'";
                            }

                            $arrayInstansi = array();
                            $arrayInstansi[] = $userMinistry;
                            $otherInstansiBool = 0;
                            // if (isset($_GET['instansi_terkait'])) {
                            //     $arrayInstansi = $_GET['instansi_terkait'];
                            //     if ($arrayInstansi[0] == "allInstansi") {
                            //         $otherInstansiBool = 1;
                            //     }
                            // } else {
                            //     $arrayInstansi[] = "allInstansi";
                            // }
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

                                echo "<div class='searchTable'>";
                                echo " <button style='background-color: green; order-color: rgb(68, 151, 68); color: white; 
                                            border-radius:3px' onclick=\"window.location.href='addIndikator.php?id_program=$id_program'\">
                                            + add
                                          </button>";
                                echo "</div>";

                                echo "<div style='width:100%; overflow-x:auto;'>";
                                //$sqlIndikator = "SELECT * FROM tb_indikator WHERE flag_active=1 AND id LIKE '%" . $id_program . "%'";
                                $sqlIndikator = "SELECT * FROM tb_indikator WHERE flag_active=1 AND id_program = '$id_program'";
                                $resultSqlIndikator = $conn->query($sqlIndikator);
                                if ($resultSqlIndikator->num_rows > 0) {
                                    echo "<table class='example display' style='width:100%'>";
                                    $indexLoop = 0;
                                    while ($indikatorInfo = $resultSqlIndikator->fetch_assoc()) {
                                        if ($indexLoop == 0) {
                                            echo "<thead>";
                                            echo "<tr>";
                                            echo "  <th>Aksi</th>";

                                            $child = 0;
                                            $indexIndikator = 0;
                                            foreach ($indikatorInfo as $colName => $indikatorValue) {
                                                if ($indexIndikator == 2) {
                                                    echo "  <th>Kegiatan</th>";
                                                }
                                                if ($colName == "id_program" || $colName == "flag_active") {
                                                    continue;
                                                } else if ($colName == "penanggung_jawab_info") {
                                                    echo "<th>PENANGGUNG JAWAB NAMA</th>";
                                                    echo "<th>PENANGGUNG JAWAB POSISI</th>";
                                                    echo "<th>PENANGGUNG JAWAB HP</th>";
                                                    echo "<th>PENANGGUNG JAWAB EMAIL</th>";
                                                } else {
                                                    echo "<th>$colName</th>";
                                                }
                                                $indexIndikator++;
                                            }
                                            echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";
                                        }

                                        echo "<tr>";
                                        $id_indikator = $indikatorInfo['id'];
                                        $sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE id_indikator=\"$id_indikator\" AND flag_active=1";
                                        $kegiatanCount = countNum($sqlCountKegiatan);

                                        echo "<td>";
                                        echo "  <button type='button' onclick=\"window.location.href='updateIndikator.php?id_indikator=$id_indikator'\"
                                            class='btn btn-primary' style='margin: 5px 0 3px 0'>Update</button>";
                                        echo "  <button type='button' onclick=\"window.location.href='delete_indikator.php?id_indikator=$id_indikator'\"
                                            class='btn btn-danger' style='margin: 3px 0 5px 0'>Delete</i></button>";
                                        $linkPenanggungJawab = "window.location.href='addPenanggungJawabIndikator.php?id_div=$id_indikator'";
                                        echo "  <button type='button' onclick=\"$linkPenanggungJawab\"
                                                class='btn btn-info' style='margin: 3px 0 5px 0'>Add Penanggung Jawab</i></button>";
                                        echo "</td>";

                                        //echo "  <td onClick=\"location.href='indikatorTabelSuperadmin.php?id_program=$id_program'\">";
                        
                                        //echo "  </tr>";
                        
                                        $child = 0;
                                        $indexIndikator = 0;
                                        foreach ($indikatorInfo as $colName => $indikatorValue) {
                                            if ($indexIndikator == 2) {
                                                echo "    <td onClick=\"location.href='kegiatanTabelOperatorMinistry.php?id_indikator=$id_indikator'\"
                                                style='cursor: pointer;'
                                                onmouseover=\"this.style.backgroundColor='#90EE90'; \"
                                                onmouseout=\"this.style.backgroundColor='white'; \"
                                                ><u><b>Kegiatan: </b> $kegiatanCount</u></td>";
                                            }
                                            if ($colName == "id_program" || $colName == "flag_active") {
                                                continue;
                                            } else if ($colName == "penanggung_jawab_info") {
                                                $penanggungArray = array();
                                                $sqlPenanggung = "SELECT * FROM tb_master_penanggung_jawab WHERE flag_active=1 AND id_div = '$id_indikator'";
                                                $resultPenanggung = $conn->query($sqlPenanggung);
                                                if ($resultPenanggung->num_rows > 0) {
                                                    while ($rowPenanggung = $resultPenanggung->fetch_assoc()) {
                                                        array_push($penanggungArray, $rowPenanggung['id']);
                                                    }
                                                }
                                                penanggungJawab($penanggungArray);
                                            } else if ($child > 0) {
                                                if ($child > 1) {
                                                    echo "<p style='border-bottom: 1px solid black;'>$indikatorValue</p>";
                                                } else {
                                                    echo "<p>$indikatorValue</p>";
                                                    echo "</div>";
                                                    echo "</td>";
                                                }
                                                $child--;
                                            } else {
                                                echo "<td>$indikatorValue</td>";
                                            }
                                            $indexIndikator++;
                                        }
                                        echo "</tr>";
                                        $indexLoop++;
                                    }
                                    echo "</tbody>";


                                    echo "</table>";
                                } else {
                                    echo "0 data";
                                }
                                echo "</div>";
                                $indexProgram++;
                                echo "<hr style='border-top: 3px dashed #5A5A5A;'>";
                            }
                            if ($indexProgram == 0) {
                                if ($otherInstansiBool == 0) {
                                    echo "0 data";
                                }
                            }
                            echo "<hr style='border-top: 4px solid #5A5A5A;'>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>