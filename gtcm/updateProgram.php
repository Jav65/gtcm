<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
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
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
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
            if (isset($_GET['id_program'])) {
                $error = 0;
                $id_program = $_GET['id_program'];
            }
            // else if(isset($_POST['id_cluster'])){$id_cluster = $_POST['id_cluster'];}
            

            if (isset($_POST['submit'])) {
                $id_program = $_POST['id_program'];
                $error = 0;
                $id_cluster = explode("_", $id_program)[0];
                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                // $sqlAddNewProgram = "INSERT INTO tb_program_$id_clusterEdited (id_cluster, id) VALUES ('$id_cluster', '$id_program')";
            
                // $conn->query($sqlAddNewProgram);
            
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

                $child = 0;
                $maxChild = 0;
                for ($indexCol = 0; $indexCol < sizeof($arrayColName); $indexCol++) {
                    $colName = $arrayColName[$indexCol];
                    $colType = $arrayColType[$indexCol];

                    $colNameEdited = convertSqlColName($colName);

                    // arent supaya index bukan di 0
                    if ($colName == "id_cluster" || $colName == "id" || $colName == "flag_active" || $colName == "created_at" || $colName == "updated_at" || $colName == "created_by") {
                        continue;
                    } else if (strpos($colType, "arent") != false) {
                        // $sqlUpdateNewProgram = "UPDATE tb_program_$id_clusterEdited SET
                        //     $colName = '$colType' WHERE id='$id_program'";
                        // $conn->query($sqlUpdateNewProgram);
                        // continue;
                        $valueUpdate = $colType;
                    } else if ($colType == "pic") {
                        $arrayValue = $_POST['instansi_terkait'];
                        $indexInstansi = 0;
                        $valueUpdate = "";
                        foreach ($arrayValue as $id_instansi) {

                            $valueUpdate = mysqli_real_escape_string($conn, $valueUpdate . $id_instansi . ",");

                            $indexInstansi++;
                        }
                    } else if ($colName == "updated_by") {
                        $valueUpdate = $_SESSION['name'];
                    } else {
                        $valueUpdate = $_POST["$colName"];
                    }
                    $sqlUpdateNewProgram = "UPDATE tb_program_$id_clusterEdited SET
                        $colName = '$valueUpdate' WHERE id='$id_program'";


                    if (!($conn->query($sqlUpdateNewProgram) === TRUE)) {
                        echo "error when updating $colName";
                        $error = 1;
                    }
                }
                if ($error == 0) {
                    if ($_SESSION['role'] == "Superadmin") {
                        $link = "Location: programTabelSuperadmin.php";
                    } else if ($_SESSION['role'] == "Operator CMMAI") {
                        $link = "Location: programTabelOperatorCMMAI.php";
                    }
                    header($link);
                }
            }
            $clusterDashboard = idListTable("tb_cluster");
            //$arrayIdKementrian = idListTable("tb_master_kementrian");
            
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button type="button" class="btn btn-dark" onclick="backProgramPage()">Back</button>
                <form id="backProgramPage" method="get" action="">
                    <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
                </form>
                <script>
                    function backProgramPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backProgramPage").action = "programTabelSuperadmin.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backProgramPage").action = "programTabelOperatorCMMAI.php"; }

                        // document.getElementById("myIdProgramPage").value = "<?php //echo $_SESSION['id_program']; ?>";

                        document.getElementById("backProgramPage").submit();
                    }
                </script>
                <h2>Add Program</h2>
                <div class="container">
                    <form action="./updateProgram.php" method="post">
                        <?php
                        echo "<input type='hidden' name='id_program' value='$id_program'>";
                        $id_cluster = explode("_", $id_program)[0];
                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

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

                        $child = 0;
                        $maxChild = 0;

                        $sqlProgramInfo = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
                        $resultProgramInfo = $conn->query($sqlProgramInfo);
                        if ($resultProgramInfo->num_rows > 0) {
                            $rowProgramInfo = $resultProgramInfo->fetch_assoc();
                        }

                        for ($indexCol = 0; $indexCol < sizeof($arrayColName); $indexCol++) {
                            $colName = $arrayColName[$indexCol];
                            $colNameEdited = strtoupper($colName);
                            $colNameEdited = str_replace("_", " ", $colNameEdited);

                            if ($colName == "id" || $colName == "flag_active" || $colName == "created_at" || $colName == "created_by" || $colName == "updated_at" || $colName == "updated_by" || $colName == "penanggung_jawab_info") {
                                continue;
                            } else if ($child > 0) {
                                $child--;
                                continue;
                            } else if ($colName == "id_cluster") {
                                echo "<input type='hidden' name='id_cluster' value='$id_cluster'>";
                            } else if (strpos($arrayColType[$indexCol], "arent") != false) {
                                preg_match_all('!\d+!', $arrayColType[$indexCol], $matches);
                                $numbers = $matches[0];
                                if (isset($numbers[0])) {
                                    $child = $numbers[0];
                                    $maxChild = max($maxChild, $numbers[0]);
                                    echo "<div class='row2'>";
                                    echo "<label for='" . $colName . "'>$colNameEdited</label>";
                                    for ($indexChild = 1; $indexChild <= $child; $indexChild++) {
                                        $colName = $arrayColName[$indexCol + $indexChild];
                                        $colNameEdited = str_replace("_", " ", $colName);
                                        echo "<div class='rowChild'>";
                                        echo "<label for='" . $colName . "'>$colNameEdited</label>";

                                        if ($arrayColType[$indexCol + $indexChild] == "varchar") {
                                            echo "<input type='text' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                        } else if ($arrayColType[$indexCol + $indexChild] == "text") {
                                            echo "<textarea id='" . $colName . "' name='" . $colName . "' rows='4' cols='50' placeholder='' required>$rowProgramInfo[$colName]</textarea>";
                                        } else if ($arrayColType[$indexCol + $indexChild] == "pic") {
                                            $instansiArray = $rowProgramInfo[$colName];
                                            $instansiArray = explode(",", $instansiArray);
                                            $jsInstansi_array = json_encode($instansiArray);
                                            echo "<select id='instansi_terkait' name='instansi_terkait[]' class='selectpicker' multiple aria-label='Pilih Instansi' data-live-search='true'>";
                                            $arrayPIC = idListTable("tb_master_kementrian");
                                            foreach ($arrayPIC as $idPIC) {
                                                $picInfo = parentFromId($idPIC, "tb_master_kementrian");
                                                echo "<option value='" . $idPIC . "'>" . $picInfo['instansi'] . "</option>";
                                            }
                                            echo "</select>";


                                            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
                                            echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>";
                                            echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>";
                                            ?>
                                                                <script>
                                                                    var instansiArray = JSON.parse('<?php echo $jsInstansi_array ?>');
                                                                    console.log(instansiArray);
                                                                    $(document).ready(function () {
                                                                        // Preselect options with values '2' and '4'
                                                                        $('#instansi_terkait').val(instansiArray);
                                                                        // Refresh the Bootstrap Select dropdown to reflect the changes
                                                                        $('#instansi_terkait').selectpicker('refresh');
                                                                    });
                                                                </script>
                                            <?php

                                            // echo "<script>";
                                            // echo "  var x = document.getElementById('instansi_terkait');";
                                            // echo "  var instansi_terkait = '$idPIC';";
                                            // echo "  for (var i = 0; i < x.options.length; i++) {
                                            //     if (x.options[i].value === instansi_terkait) {
                                            //         x.options[i].selected = true;
                                            //         break;
                                            //     }
                                            // }";
                                            // echo "</script>";
                                        } else if ($arrayColType[$indexCol + $indexChild] == "number") {
                                            echo "<input type='number' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                        } else if ($arrayColType[$indexCol + $indexChild] == "float") {
                                            echo "<input type='number' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' step='0.01' required>";
                                        } else if ($arrayColType[$indexCol + $indexChild] == "date") {
                                            echo "<input type='date' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                            //echo "<input type='text'>";
                                        }
                                        echo "</div>";

                                    }

                                    //echo "<input id='". $colName ."' class='".$colName ."' type=".">";
                                    echo "</div>";
                                }
                                //$indexCol += $child;
                            } else {
                                echo "<div class='row2'>";
                                echo "<label for='" . $colName . "'>$colNameEdited</label>";

                                if ($arrayColType[$indexCol] == "varchar") {
                                    echo "<input type='text' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                    //echo "<input type='text'>";
                                } else if ($arrayColType[$indexCol] == "text") {
                                    echo "<textarea id='" . $colName . "' name='" . $colName . "' rows='4' cols='50' placeholder='' required>$rowProgramInfo[$colName]</textarea>";
                                    //echo "<input type='text'>";
                                } else if ($arrayColType[$indexCol] == "pic") {
                                    $instansiArray = $rowProgramInfo[$colName];
                                    $instansiArray = explode(",", $instansiArray);
                                    $jsInstansi_array = json_encode($instansiArray);
                                    echo "<select id='instansi_terkait' name='instansi_terkait[]' class='selectpicker' multiple aria-label='Pilih Instansi' data-live-search='true'>";
                                    $arrayPIC = idListTable("tb_master_kementrian");
                                    foreach ($arrayPIC as $idPIC) {
                                        $picInfo = parentFromId($idPIC, "tb_master_kementrian");
                                        echo "<option value='" . $idPIC . "'>" . $picInfo['instansi'] . "</option>";
                                    }
                                    echo "</select>";


                                    echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
                                    echo "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'></script>";
                                    echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>";
                                    ?>
                                                        <script>
                                                            var instansiArray = JSON.parse('<?php echo $jsInstansi_array ?>');
                                                            console.log(instansiArray);
                                                            $(document).ready(function () {
                                                                // Preselect options with values '2' and '4'
                                                                $('#instansi_terkait').val(instansiArray);
                                                                // Refresh the Bootstrap Select dropdown to reflect the changes
                                                                $('#instansi_terkait').selectpicker('refresh');
                                                            });
                                                        </script>
                                    <?php
                                    // echo "<select id='instansi_terkait' name='instansi_terkait' required>";
                                    // echo "  <option value='' selected disabled hidden>Pilih Role</option>";
                                    // $arrayPIC = idListTable("tb_master_kementrian");
                                    // foreach ($arrayPIC as $idPIC) {
                                    //     $picInfo = parentFromId($idPIC, "tb_master_kementrian");
                                    //     echo "<option value='" . $idPIC . "'>" . $picInfo['kementrian'] . "</option>";
                                    // }
                                    // echo "</select>";
                                    // echo "<script>";
                                    // echo "  var x = document.getElementById('instansi_terkait');";
                                    // echo "  var instansi_terkait = '$idPIC';";
                                    // echo "  for (var i = 0; i < x.options.length; i++) {
                                    //             if (x.options[i].value === instansi_terkait) {
                                    //                 x.options[i].selected = true;
                                    //                 break;
                                    //             }
                                    //         }";
                                    // echo "</script>";
                                    //echo "<input type='text'>";
                                } else if ($arrayColType[$indexCol] == "number") {
                                    echo "<input type='number' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                    //echo "<input type='text'>";
                                } else if ($arrayColType[$indexCol] == "float") {
                                    echo "<input type='number' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]'  step='0.01' required>";
                                    //echo "<input type='text'>";
                                } else if ($arrayColType[$indexCol] == "date") {
                                    echo "<input type='date' id='" . $colName . "' name='" . $colName . "' value='$rowProgramInfo[$colName]' required>";
                                    //echo "<input type='text'>";
                                }
                                echo "</div>";
                            }
                            // $colNameEdited = strtoupper($colName);
                            // $colNameEdited = str_replace("_", " ", $colNameEdited);
                            // echo "<td>$colNameEdited</td>";
                        }
                        ?>

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