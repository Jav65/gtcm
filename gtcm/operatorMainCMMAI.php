<!-- https://stackoverflow.com/questions/923885/capture-html-canvas-as-gif-jpg-png-pdf -->
<!-- testing dashboard -->
<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php
    include "head.html";
    ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
    <link href="dash.css" rel="stylesheet">

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
    </style>

    <!-- dropdown -->
    <style>
        .select2-selection__arrow {
            right: 5px;
            top: 10px;
        }

        .form-group {
            display: inline-block;
        }
    </style>
</head>

<body>

    <?php
    if (!isset($_SESSION['role'])) {
        header('location:login.html');
    } else if ($_SESSION['role'] != 'Operator CMMAI') {
        header("Location: accessDenied.php");
    }
    include "connection.php";
    include "function/myFunc.php";

    ?>
    <div style="max-width: 1980px; margin: auto; ">
        <?php include "headerNavigation.php"; ?>
        <div style="padding:20px;">
            <?php menu("dashboard"); ?>

            <form action="operatorMainCMMAI.php" id="dashboardFilter" style="display: inline-block;" method="get">
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
                        $('#id_cluster').select2({
                            width: '200px',
                            placeholder: 'Select an option',
                            allowClear: true
                        });
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
                    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
                    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>
                    <script
                        src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>
                </div>
                <input type="hidden" name="page" id="page" value="1">
                <input type="hidden" name="pageProblem" id="pageProblem" value="1">
                <input type="hidden" name="pageLate" id="pageLate" value="1">
                <button type="submit" style="background-color: #FA8072; display: inline-block;">Filter</button>
            </form>
            <script>
                <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }

                if (isset($_GET['pageProblem'])) {
                    $pageProblem = $_GET['pageProblem'];
                } else {
                    $pageProblem = 1;
                }

                if (isset($_GET['pageLate'])) {
                    $pageLate = $_GET['pageLate'];
                } else {
                    $pageLate = 1;
                }
                ?>
                document.getElementById("page").value = "<?php echo $page; ?>";
                document.getElementById("pageProblem").value = "<?php echo $pageProblem; ?>";
                document.getElementById("pageLate").value = "<?php echo $pageLate; ?>";
            </script>

            <div class="grid" style="overflow-x:auto">
                <div>
                    <div class='card' onclick="submitFormMainPage('')" style='cursor:pointer; padding:15px;'
                        class='h-100 divIKU'>

                        <div class="row">
                            <div class="col-md-6 float-left">
                                <h5>Progress</h5>
                            </div>
                            <div class="col-md-6 float-right">
                                <a href="programTabelOperatorCMMAI.php"><u>View Detail</u></a>
                            </div>
                        </div>

                        <?php
                        $results_per_page = 3;
                        if (isset($_GET['id_cluster']) && $_GET['id_cluster'] != "allCluster") {
                            $id_cluster = $_GET['id_cluster'];
                            $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

                            if (isset($_GET['instansi_terkait']) && $otherInstansiBool == 0) {
                                $arrayInstansi = $_GET['instansi_terkait'];

                                $indexInstansi = 0;
                                $sqlProgramProgress = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
                                foreach ($arrayInstansi as $id_instansi) {
                                    if ($indexInstansi == 0) {
                                        $sqlProgramProgress = $sqlProgramProgress . " AND (instansi_terkait LIKE '%" . $id_instansi . "%'";
                                    } else {
                                        $sqlProgramProgress = $sqlProgramProgress . " OR instansi_terkait LIKE '%" . $id_instansi . "%'";
                                    }
                                    $indexInstansi++;
                                }
                                $sqlProgramProgress = $sqlProgramProgress . ")";

                            } else {
                                $sqlProgramProgress = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
                            }
                            $result = $conn->query($sqlProgramProgress);
                            $number_of_results = mysqli_num_rows($result);
                            $number_of_pages = ceil($number_of_results / $results_per_page);

                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }

                            $this_page_first_result = ($page - 1) * $results_per_page;
                            $sqlProgramProgressLimit = $sqlProgramProgress . " LIMIT " . $this_page_first_result . ',' . $results_per_page;
                            $resultProgramProgress = $conn->query($sqlProgramProgressLimit);
                            if ($resultProgramProgress->num_rows > 0) {

                                $programName = array();
                                $capaian_b04 = array();
                                $capaian_b06 = array();
                                $capaian_b09 = array();
                                $capaian_b12 = array();
                                while ($rowProgramProgress = $resultProgramProgress->fetch_assoc()) {
                                    $indexProgram = 0;
                                    foreach ($rowProgramProgress as $colName => $value) {
                                        if ($indexProgram == 2) {
                                            if (strlen($value) > 20) {
                                                $truncated = substr($value, 0, 20);
                                                $value = $truncated . '...';
                                            }
                                            array_push($programName, $value);
                                        } else if ($colName == "b04") {
                                            array_push($capaian_b04, $value);
                                        } else if ($colName == "b06") {
                                            array_push($capaian_b06, $value);
                                        } else if ($colName == "b09") {
                                            array_push($capaian_b09, $value);
                                        } else if ($colName == "b12") {
                                            array_push($capaian_b12, $value);
                                        }
                                        $indexProgram++;
                                    }
                                }
                                $jsProgramName_array = json_encode($programName);
                                $jsCapaianB04_array = json_encode($capaian_b04);
                                $jsCapaianB06_array = json_encode($capaian_b06);
                                $jsCapaianB09_array = json_encode($capaian_b09);
                                $jsCapaianB12_array = json_encode($capaian_b12);

                            } else {
                                echo "<p>Tidak ada data</p>";
                            }
                            ?>

                            <!-- <div id="card_groupBar"> -->
                            <div id="container" class="w-100">
                                <canvas id="canvasProgress" style="width: 100%; height: 100%;"></canvas>
                            </div>
                            <!-- </div> -->

                            <script>
                                var programName = JSON.parse('<?php echo $jsProgramName_array; ?>');
                                console.log(programName);
                                var capaianB04 = JSON.parse('<?php echo $jsCapaianB04_array; ?>');
                                console.log(capaianB04);
                                var capaianB06 = JSON.parse('<?php echo $jsCapaianB06_array; ?>');
                                var capaianB09 = JSON.parse('<?php echo $jsCapaianB09_array; ?>');
                                var capaianB12 = JSON.parse('<?php echo $jsCapaianB12_array; ?>');
                                var barChartData = {
                                    labels: programName,
                                    datasets: [
                                        {
                                            label: "Capaian B04",
                                            backgroundColor: "pink",
                                            borderColor: "red",
                                            borderWidth: 1,
                                            data: capaianB04
                                        },
                                        {
                                            label: "Capaian B06",
                                            backgroundColor: "lightblue",
                                            borderColor: "blue",
                                            borderWidth: 1,
                                            data: capaianB06
                                        },
                                        {
                                            label: "Capaian B09",
                                            backgroundColor: "lightgreen",
                                            borderColor: "green",
                                            borderWidth: 1,
                                            data: capaianB09
                                        },
                                        {
                                            label: "Capaian B12",
                                            backgroundColor: "yellow",
                                            borderColor: "orange",
                                            borderWidth: 1,
                                            data: capaianB12
                                        }
                                    ]
                                };

                                var chartOptions = {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    legend: {
                                        position: "top"
                                    },
                                    title: {
                                        display: true,
                                        text: "Chart.js Bar Chart"
                                    },
                                    scales: {
                                        xAxes: [{
                                            type: 'category',
                                            labels: ['Absence of OB', 'Closeness', 'Credibility', 'Heritage'],
                                            ticks: {
                                                autoSkip: false,
                                                maxRotation: 90,
                                                minRotation: 90,
                                                fontSize: 10,
                                                padding: 5

                                            }
                                        }],
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true

                                            }
                                        }]
                                    }
                                }
                                document.getElementById("canvasProgress").parentNode.style.height = '300px';
                                document.getElementById("canvasProgress").parentNode.style.width = '500px';

                                // window.onload = function () {
                                var ctx = document.getElementById("canvasProgress").getContext("2d");
                                Chart.defaults.font.size = 12;
                                window.myBar = new Chart(ctx, {
                                    type: "bar",
                                    data: barChartData,
                                    options: chartOptions
                                });
                                                                                                                                        // };

                            </script>
                        <?php } else {
                            echo "<p>Pilih salah satu cluster</p>";
                        }
                        ?>
                    </div>

                    <div class="row" style="margin-right: 0.5rem">
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (!isset($number_of_pages)) {
                                        $number_of_pages = 1;
                                    }
                                    // echo "ina = 0";
                                    for ($page = 1; $page <= $number_of_pages; $page++) {
                                        echo '<li class="page-item" onclick="pageProgress(' . $page . ')" onmouseover="this.style.cursor = \'pointer\'" onmouseout="this.style.cursor = \'default\'"><p class="page-link">' . $page . '</p></li>';
                                    }
                                    ?>
                                    <script>
                                        function pageProgress(value) {
                                            document.getElementById("page").value = value;
                                            document.getElementById("dashboardFilter").submit();
                                        }
                                    </script>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card" style="overflow-y:auto;">
                        <div>
                            <ul class="nav tabs-admin" role="tablist" style="margin-bottom:5px;">
                                <li role="presentation" class="nav-item"><a class="nav-link active" href="kegiatanTabelOperatorCMMAI.php"
                                        aria-controls="t1" role="tab" data-toggle="tab">Activities</a></li>
                            </ul>

                            <?php
                            if (isset($_GET['id_cluster'])) {
                                $id_cluster = $_GET['id_cluster'];
                            } else {
                                $id_cluster = "allCluster";
                            }

                            $arrayInstansi = array();
                            if (isset($_GET['instansi_terkait']) && $otherInstansiBool == 0) {
                                $arrayInstansi = $_GET['instansi_terkait'];
                            } else {
                                $arrayInstansi[] = "allInstansi";
                            }
                            $idProgramFilter_array = programFilterClusterInstansi($id_cluster, $arrayInstansi);


                            // $statusKegiatan = "allStatus";
                            // $picFilter = "allMinistry";
                            // if (isset($_POST['statusKegiatan'])) {
                            //     $statusKegiatan = $_POST["statusKegiatan"] ?? "allStatus";
                            //     $picFilter = $_POST['pic'] ?? "allMinistry";
                            //     echo "<script>";
                            //     echo "document.getElementById('statusKegiatan').value = '$statusKegiatan';";
                            //     echo "document.getElementById('pic').value = '$picFilter';";
                            //     echo "</script>";
                            //     // Use the selected option in your PHP code here
                            // }
                            
                            $where = "SELECT * FROM tb_kegiatan WHERE flag_active=1";
                            if (sizeof($idProgramFilter_array) > 0) {
                                $indexKegiatanFilter = 0;
                                foreach ($idProgramFilter_array as $id_program) {
                                    if ($indexKegiatanFilter == 0) {
                                        $where = $where . " AND (id LIKE '%" . $id_program . "%'";
                                    } else {
                                        $where = $where . "  OR id LIKE '%" . $id_program . "%'";
                                    }
                                    $indexKegiatanFilter++;
                                }
                                $where = $where . ")";

                                $sqlRecent = $where . " ORDER BY updated_at DESC";
                                $resultRecent = $conn->query($sqlRecent);

                                if ($resultRecent->num_rows > 0) {
                                    echo "<div style='padding:0 10px 0 10px'>";
                                    while ($rowRecent = $resultRecent->fetch_assoc()) {
                                        $kegiatan = $rowRecent["kegiatan"];
                                        $id_kegiatan = $rowRecent["id"];
                                        $id_indikator = $rowRecent["id_indikator"];
                                        $status = $rowRecent["status"];

                                        $updateAt = explode(" ", $rowRecent['updated_at']);

                                        //dateToText($updateAt[0]);
                                        $updatedDate = dateToText($updateAt[0]);


                                        /*royce*/
                                        $id_explode_array = explode("_", $id_kegiatan);
                                        $id_program = $id_explode_array[0] . "_" . $id_explode_array[1];
                                        $id_cluster = explode("_", $id_program)[0];
                                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

                                        $sqlProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
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
                                                $indexProgram = 0;

                                                $sqlColName = "SELECT * FROM tb_colname_program WHERE id='$id_cluster'";
                                                $resultColName = $conn->query($sqlColName);
                                                if ($resultColName->num_rows > 0) {
                                                    $rowColName = $resultColName->fetch_assoc();

                                                    $arrayColName = str_replace("'", "", $rowColName['colName1']);
                                                    $arrayColName = explode(", ", $arrayColName);

                                                    $program = $rowProgram[$arrayColName[2]];
                                                }


                                                //$program = $rowProgram["program"];
                                                $instansiArray = $rowProgram["instansi_terkait"];
                                                $instansiArray = explode(",", $instansiArray);
                                                $indexInstansi = 0;
                                                $sizeInstansi = sizeof($instansiArray);
                                                foreach ($instansiArray as $id_instansi) {
                                                    if($indexInstansi == $sizeInstansi-1){break;}
                                                    $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");
                                                    if ($indexInstansi == 0) {
                                                        $stringInstansi = $instansiInfo['instansi'];
                                                    } else {
                                                        $stringInstansi = $stringInstansi . ", " . $instansiInfo['instansi'];
                                                    }
                                                    $indexInstansi++;
                                                }

                                                // if ($picFilter != "allMinistry" && $pic != $picFilter) {
                                                //     continue;
                                                // }
                            
                                                $sqlCluster = "SELECT * FROM tb_cluster WHERE id='$id_cluster'";
                                                $resultCluster = $conn->query($sqlCluster);
                                                if ($resultCluster->num_rows > 0) {
                                                    while ($rowCluster = $resultCluster->fetch_assoc()) {
                                                        $cluster = $rowCluster["cluster"];

                                                        echo '<div class="activity-column">';
                                                        echo '  <div class="activity-time">' . $updatedDate . '</div>';
                                                        //echo '  <div class="activity-row">';
                                                        echo '    <div class="activity-name">';

                                                        if (strlen($kegiatan) > 200) {
                                                            $truncated = substr($kegiatan, 0, 200);
                                                            echo $truncated . '... <a href="kegiatanDetail.php?id_kegiatan=' . $id_kegiatan . '">more</a>';
                                                        } else {
                                                            echo $kegiatan . ' <a href="kegiatanDetail.php?id_kegiatan=' . $id_kegiatan . '">more</a>';
                                                        }
                                                        echo '    </div>';
                                                        echo '    <div class="activity-status"><u>' . $status . '</u></div>';
                                                        //echo '  </div>';
                                                        echo '  <div class="activity-des"><b>Instansi:</b> ' . $stringInstansi . '; <b>Program:</b> ' . $program . '; <b>Cluster:</b> ' . $cluster . '</div>';
                                                        echo '</div>';
                                                        echo "<hr style='border-top: 1px solid black; margin:5px 0 5px 0;'>";
                                                    }

                                                }

                                            }

                                        }
                                    }
                                    echo "</div>";
                                } else {
                                    echo "0 data";
                                }
                            } else {
                                echo "0 data";
                            }
                            // if ($statusKegiatan != "allStatus") {
                            //     $where = $where . " AND status='$statusKegiatan'";
                            // }
                            // if($pic != "allMinistry"){
                            //   $where = $where ." AND pic='$statusKegiatan'";
                            // }
                            ?>
                        </div>
                    </div>
                </div>

                <div>
                    <div class='card' onclick="submitFormMainPage('')" style='cursor:pointer; padding:15px;'
                        class='h-100 divIKU'>

                        <div class="row">
                            <div class="col-md-6 float-left">
                                <h5>Problem</h5>
                            </div>
                            <div class="col-md-6 float-right">
                                <a href="problemTabelOperatorCMMAI.php"><u>View Detail</u></a>
                            </div>
                        </div>
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
                        $jsproblemInstansiArray = array();
                        // $problemInstansiArray = array();
                        $kegiatanProblemInstansiArray = array();
                        $instansiNameArray = array();

                        $instansiSize = sizeof($arrayInstansiMasing);
                        for ($indexInstansi = 0; $indexInstansi < $instansiSize; $indexInstansi++) {
                            $id_instansi = $arrayInstansiMasing[$indexInstansi];

                            $arrayInstansi = array($id_instansi);
                            $idProgramFilter_array = programFilterClusterInstansi($id_cluster, $arrayInstansi);

                            $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");

                            $problemCount = 0;
                            $kegiatanCount = 0;
                            foreach ($idProgramFilter_array as $id_program) {
                                $sqlCountProblem = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND status !='Selesai' AND problem >0";
                                $resultCountProblem = $conn->query($sqlCountProblem);
                                if ($resultCountProblem->num_rows > 0) {
                                    $kegiatanCount++;
                                    while ($rowCountProblem = $resultCountProblem->fetch_assoc()) {
                                        $problemCount += $rowCountProblem['problem'];
                                    }

                                }
                                // $problemCount += countNum($sqlCountProblem);
                        
                                // $sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND problem > 0";
                                // $kegiatanCount += countNum($sqlCountKegiatan);
                            }
                            if ($problemCount > 0) {
                                array_push($instansiNameArray, $instansiInfo['instansi']);
                                $jsproblemInstansiArray[] = $problemCount;
                                // $problemInstansiArray["$id_instansi"] = $problemCount;
                                $kegiatanProblemInstansiArray[] = $kegiatanCount;
                            }
                        }
                        $results_per_pageProblem = 5;
                        $problemInstansiSize = sizeof($jsproblemInstansiArray);

                        $number_of_pagesProblem = ceil($problemInstansiSize / $results_per_pageProblem);

                        if (!isset($_GET['pageProblem'])) {
                            $pageProblem = 1;
                        } else {
                            $pageProblem = $_GET['pageProblem'];
                        }

                        $this_page_first_resultProblem = ($pageProblem - 1) * $results_per_pageProblem;
                        $endIndexProblem = $this_page_first_resultProblem + $results_per_pageProblem;
                        if ($endIndexProblem > $problemInstansiSize) {
                            $endIndexProblem = $problemInstansiSize;
                        }
                        $jsPageProblemInstansiArray = array();
                        $pageInstansiNameArray = array();
                        $pageKegiatanProblemInstansiArray = array();
                        for ($indexInstansi = $this_page_first_resultProblem; $indexInstansi < $endIndexProblem; $indexInstansi++) {
                            array_push($jsPageProblemInstansiArray, $jsproblemInstansiArray[$indexInstansi]);
                            array_push($pageInstansiNameArray, $instansiNameArray[$indexInstansi]);
                            array_push($pageKegiatanProblemInstansiArray, $kegiatanProblemInstansiArray[$indexInstansi]);
                        }
                        echo "<div class='row'>";
                        echo "    <div class='col-md-6 float-left'>";
                        echo "        <p>Kegiatan: " . array_sum($pageKegiatanProblemInstansiArray) . "</p>";
                        echo "    </div>";
                        echo "    <div class='col-md-6 float-right'>";
                        echo "        <p>Problem: " . array_sum($jsPageProblemInstansiArray) . "</p>";
                        echo "    </div>";
                        echo "</div>";

                        $jsInstansiName_array = json_encode($pageInstansiNameArray);
                        $jsProblemInstansi_array = json_encode($jsPageProblemInstansiArray);
                        ?>
                        <div>
                            <canvas id="myChartDashboardGTCM" style="width:100%; height:100%;"></canvas>
                        </div>
                    </div>


                    <script type="text/javascript"
                        src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
                    <script>
                        var instansiNameArray = JSON.parse('<?php echo $jsInstansiName_array; ?>');
                        console.log(instansiNameArray);
                        var problemInstansiArray = JSON.parse('<?php echo $jsProblemInstansi_array; ?>');
                        console.log(problemInstansiArray);

                        // setup 
                        const data = {
                            labels: instansiNameArray,
                            datasets: [{
                                label: 'Problem',
                                data: problemInstansiArray,
                                backgroundColor: [
                                    '#7489f0',
                                    '#8f75f7',
                                    '#b56af6',
                                    '#f070c6',
                                    '#f784ae',
                                    '#fca797'
                                ],

                                borderWidth: 0
                            }]
                        };
                        // config 

                        // Chart.defaults.color = "white";
                        const config = {
                            type: 'bar',
                            data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                legend: {
                                    display: false
                                }
                            }
                        };

                        // render init block
                        document.getElementById("myChartDashboardGTCM").parentNode.style.height = '300px';
                        // document.getElementById("myChartDashboardGTCM").parentNode.style.width = '500px';
                        const myChart = new Chart(
                            document.getElementById('myChartDashboardGTCM'),
                            config
                        );

                    </script>
                    <div class="row" style="margin-right: 0.5rem">
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (!isset($number_of_pagesProblem)) {
                                        $number_of_pagesProblem = 1;
                                    }
                                    for ($page = 1; $page <= $number_of_pagesProblem; $page++) {
                                        echo '<li class="page-item" onclick="pageProblem(' . $page . ')" onmouseover="this.style.cursor = \'pointer\'" onmouseout="this.style.cursor = \'default\'"><p class="page-link">' . $page . '</p></li>';
                                    }
                                    ?>
                                    <script>
                                        function pageProblem(value) {
                                            document.getElementById("pageProblem").value = value;
                                            document.getElementById("dashboardFilter").submit();
                                        }
                                    </script>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="card" style="padding: 15px;">
                        <div class="row">
                            <div class="col-md-6 float-left">
                                <h5>Lewat Deadline</h5>
                            </div>
                            <div class="col-md-6 float-right">
                                <a href="lateTabelOperatorCMMAI.php"><u>View Detail</u></a>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around w-100 h-70">
                            <div class="mt-2 ml-2 w-50">
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
                                for ($indexInstansi = 0; $indexInstansi < $instansiSize; $indexInstansi++) {
                                    $id_instansi = $arrayInstansiMasing[$indexInstansi];

                                    $arrayInstansi = array($id_instansi);
                                    $idProgramFilter_array = programFilterClusterInstansi($id_cluster, $arrayInstansi);

                                    $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");

                                    $kegiatanCount = 0;
                                    foreach ($idProgramFilter_array as $id_program) {
                                        $currentDate = date('Y-m-d H:i:s'); // format: yyyy-mm-dd hh:mm:ss
                                        $sqlCountLate = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND status !='Selesai' AND tanggal_berakhir<'$currentDate'";
                                        $resultCountLate = $conn->query($sqlCountLate);
                                        if ($resultCountLate->num_rows > 0) {
                                            while ($rowCountLate = $resultCountLate->fetch_assoc()) {
                                                $kegiatanCount++;
                                            }
                                        }
                                        // $problemCount += countNum($sqlCountProblem);
                                
                                        // $sqlCountKegiatan = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id LIKE '%" . $id_program . "%' AND problem > 0";
                                        // $kegiatanCount += countNum($sqlCountKegiatan);
                                    }
                                    if ($kegiatanCount > 0) {
                                        array_push($instansiNameArrayLate, $instansiInfo['instansi']);
                                        $kegiatanLateInstansiArray[] = $kegiatanCount;
                                    }
                                }
                                $results_per_pageLate = 5;
                                $lateInstansiSize = sizeof($kegiatanLateInstansiArray);

                                $number_of_pagesLate = ceil($lateInstansiSize / $results_per_pageLate);

                                if (!isset($_GET['pageLate'])) {
                                    $pageLate = 1;
                                } else {
                                    $pageLate = $_GET['pageLate'];
                                }

                                $this_page_first_resultLate = ($pageLate - 1) * $results_per_pageLate;
                                $endIndexLate = $this_page_first_resultLate + $results_per_pageLate;
                                if ($endIndexLate > $lateInstansiSize) {
                                    $endIndexLate = $lateInstansiSize;
                                }

                                $pageInstansiNameArrayLate = array();
                                $pageKegiatanLateInstansiArray = array();
                                $ministryLateColor = array();
                                $colorLibrary = array("#2ec82e", "#000936", "#FF0000", "#D205D5", "#FFB800");
                                echo "<ul class='fa-ul'>";
                                $indexLoop = 0;
                                for ($indexInstansi = $this_page_first_resultLate; $indexInstansi < $endIndexLate; $indexInstansi++) {
                                    $color = $colorLibrary[$indexLoop];
                                    echo "<li><span class='fa-li'><i class='fa-solid fa-circle' style='color: $color;'></i></span>" . $instansiNameArrayLate[$indexInstansi] . " " . $kegiatanLateInstansiArray[$indexInstansi] . "</li>";

                                    array_push($pageInstansiNameArrayLate, $instansiNameArrayLate[$indexInstansi]);
                                    array_push($pageKegiatanLateInstansiArray, $kegiatanLateInstansiArray[$indexInstansi]);
                                    array_push($ministryLateColor, $color);
                                    $indexLoop++;
                                }
                                echo "</ul>";
                                if ($indexLoop == 0) {
                                    echo "<p>Tidak ada kegiatan yang melewati deadline</p>";
                                }

                                $jsministryLate_array = json_encode($pageInstansiNameArrayLate);
                                $jsministryLateNum_array = json_encode($pageKegiatanLateInstansiArray);
                                $jsministryLateColor_array = json_encode($ministryLateColor);

                                ?>

                            </div>
                            <div class="w-50">
                                <canvas id="pieChartLate" style="width: 100%; height: 100%;"></canvas>
                            </div>
                        </div>
                        <script>
                            var ministryLate = JSON.parse('<?php echo $jsministryLate_array; ?>');
                            console.log(ministryLate);
                            var ministryLateNum = JSON.parse('<?php echo $jsministryLateNum_array; ?>');
                            console.log(ministryLateNum);
                            var ministryLateColor = JSON.parse('<?php echo $jsministryLateColor_array; ?>');
                            console.log(ministryLateColor);
                            lateMinistrySize = ministryLate.length;
                            for (indexPie = 0; indexPie < lateMinistrySize; indexPie++) {
                                ministryLateNum[indexPie] = parseInt(ministryLateNum[indexPie]);
                            }

                            const ctxPie = document.getElementById('pieChartLate');
                            var pieColors = ministryLateColor;

                            window.onload = function () {
                                new Chart(ctxPie, {
                                    type: 'pie',
                                    data: {
                                        labels: ministryLate,
                                        datasets: [{
                                            backgroundColor: pieColors,
                                            data: ministryLateNum,
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        legend: {
                                            display: false
                                        },
                                        tooltips: {
                                            enabled: false
                                        },
                                        title: {
                                            display: false
                                        }
                                    }
                                });
                            }
                            document.getElementById("pieChartLate").parentNode.style.height = '300px';
                            document.getElementById("pieChartLate").parentNode.style.width = '500px';
                        </script>
                    </div>
                    <div class="row" style="margin-right: 0.5rem">
                        <div class="col-md-12">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (!isset($number_of_pagesLate)) {
                                        $number_of_pagesLate = 1;
                                    }
                                    for ($page = 1; $page <= $number_of_pagesLate; $page++) {
                                        echo '<li class="page-item" onclick="pageLate(' . $page . ')" onmouseover="this.style.cursor = \'pointer\'" onmouseout="this.style.cursor = \'default\'"><p class="page-link">' . $page . '</p></li>';
                                    }
                                    ?>
                                    <script>
                                        function pageLate(value) {
                                            document.getElementById("pageLate").value = value;
                                            document.getElementById("dashboardFilter").submit();
                                        }
                                    </script>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

            </div>
            <!-- <div class='card' onclick="submitFormMainPage('')" style='cursor:pointer' class='h-100 divIKU'>
            <h2>Problem</h2>
            <canvas id="problem"></canvas>



        </div> -->
        </div>
    </div>
    <!-- <div class="w-100 mother">
            <div class="d-flex justify-content-center">
                <div class="wrapper">
                    <div class="dashboard">

                        <div class="contentb3 w-100 h-100">
                            <div class="m-3" style="color:black;font-size:20px"><strong>DASHBOARD</strong></div>

                            <div id="card_groupBar">
                                <div id="container" style="">
                                    <canvas id="canvas"></canvas>
                                </div>
                            </div>
                            <script>
                                // var clusterNameArray = JSON.parse('<?php echo $jsclusterName_array; ?>');
                                // var countB04Array = JSON.parse('<?php echo $jsCountB04_array; ?>');
                                // countB04Array = countB04Array.map(str => parseInt(str));
                                // var countB06Array = JSON.parse('<?php echo $jsCountB06_array; ?>');
                                // countB06Array = countB06Array.map(str => parseInt(str));
                                // var countB09Array = JSON.parse('<?php echo $jsCountB09_array; ?>');
                                // countB09Array = countB09Array.map(str => parseInt(str));
                                // var countB12Array = JSON.parse('<?php echo $jsCountB12_array; ?>');
                                // countB12Array = countB12Array.map(str => parseInt(str));
                                // console.log(countB12Array[0]);

                                // var countCluster = clusterNameArray.length;
                                // for (indexCluster = 0; indexCluster < countCluster; indexCluster++) {
                                //     countB04Array[indexCluster] = parseInt(countB04Array[indexCluster]);
                                //     countB06Array[indexCluster] = parseInt(countB06Array[indexCluster]);
                                //     countB09Array[indexCluster] = parseInt(countB09Array[indexCluster]);
                                //     countB12Array[indexCluster] = parseInt(countB12Array[indexCluster]);
                                // }

                                // console.log(clusterNameArray);
                                // // var countB04Array = JSON.parse("");

                                // var barChartData = {
                                //     labels: clusterNameArray,
                                //     datasets: [
                                //         {
                                //             label: "Capaian B04",
                                //             backgroundColor: "pink",
                                //             borderColor: "red",
                                //             borderWidth: 1,
                                //             data: countB04Array
                                //         },
                                //         {
                                //             label: "Capaian B06",
                                //             backgroundColor: "lightblue",
                                //             borderColor: "blue",
                                //             borderWidth: 1,
                                //             data: countB06Array
                                //         },
                                //         {
                                //             label: "Capaian B09",
                                //             backgroundColor: "lightgreen",
                                //             borderColor: "green",
                                //             borderWidth: 1,
                                //             data: countB09Array
                                //         },
                                //         {
                                //             label: "Capaian B12",
                                //             backgroundColor: "yellow",
                                //             borderColor: "orange",
                                //             borderWidth: 1,
                                //             data: countB12Array
                                //         }
                                //     ]
                                // };

                                // var chartOptions = {
                                //     responsive: true,
                                //     maintainAspectRatio: false,
                                //     legend: {
                                //         position: "top"
                                //     },
                                //     title: {
                                //         display: true,
                                //         text: "Chart.js Bar Chart"
                                //     },
                                //     scales: {
                                //         xAxes: [{
                                //             ticks: {
                                //                 autoSkip: false,
                                //                 maxRotation: 90,
                                //                 minRotation: 90,
                                //                 fontSize: 10,
                                //                 padding: 5
                                //             }
                                //         }],
                                //         yAxes: [{
                                //             ticks: {
                                //                 beginAtZero: true
                                //             }
                                //         }]
                                //     }
                                // };
                                // document.getElementById("canvas").parentNode.style.height = '300px';
                                // document.getElementById("canvas").parentNode.style.width = '500px';

                                // window.onload = function () {
                                //     var ctx = document.getElementById("canvas").getContext("2d");
                                //     window.myBar = new Chart(ctx, {
                                //         type: "bar",
                                //         data: barChartData,
                                //         options: chartOptions
                                //     });
                                // };
                            </script>

                        </div>
                    </div>
                    <div class="problem">

                        <div class="contentb1 w-100 h-100">
                            <div class="m-3" style="color:black;font-size:20px"><strong>PROBLEM</strong></div>


                        </div>
                    </div>

                    <div class="recent">

                        <div class="contentb2 w-100 h-100">
                            <div class="m-3" style="color:black;font-size:20px"><strong>RECENT</strong></div>

                        </div>
                    </div>


                    <div class="late">

                        <div class="contentb4 w-100 h-100">
                            <div class="m-3" style="color:black;font-size:20px"><strong>LATE</strong></div>

                        </div>
                    </div>
                </div>
            </div>


        </div> -->

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-stacked100@1.0.0"></script>

    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <!-- Filter -->
    <!-- <script src="filterDashboardMain.js"></script> -->
    <!-- Vendor JS Files -->
    <!-- <script src="assetsFilter/vendor/aos/aos.js"></script>
    <script src="assetsFilter/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assetsFilter/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assetsFilter/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assetsFilter/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assetsFilter/vendor/php-email-form/validate.js"></script> -->

    <!-- Template Main JS File -->
    <!-- <script src="assetsFilter/js/main.js"></script> -->

    <?php $conn->close(); ?>
</body>

</html>