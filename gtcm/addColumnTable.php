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
                $id_cluster = mysqli_real_escape_string($conn, $_POST['id_cluster']);
                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                $colName = mysqli_real_escape_string($conn, $_POST['colName']);


                if (preg_match('/^[a-zA-Z0-9_ ]+$/', $colName)) {
                    // Input is valid
                    $colName = trim($colName); // remove white spaces from both sides
                    $colName = preg_replace('/\s+/', ' ', $colName); // replace repeated spaces with a single space
                    $colName = str_replace(" ", "_", $colName);
                    $colName = str_replace(",", "__", $colName);
                    $colName = strtolower($colName);

                    $colType = mysqli_real_escape_string($conn, $_POST['colType']);
                    if ($colType == "subColumn") {
                        $dataType = "text";
                        $dataTypeShort = "parent(0)";

                        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                        $resultColName = $conn->query($sqlColName);
                        if ($resultColName->num_rows > 0) {
                            $rowColName = $resultColName->fetch_assoc();
                        }
                        // echo $rowColName['colName1'] . "<br>";
                        // echo $rowColName['type1'] . "++<br><br>";
                        $arrayColName = explode(", ", $rowColName['colName1']);
                        //$arrayColType
                        $posArrBeforeFlag = array_search("flag_active", $arrayColName) - 1;
                        $colNameBefore = $arrayColName[$posArrBeforeFlag];
                        
                        $posStrFlag = strpos($rowColName['colName1'], "flag_active");

                        if (!in_array($colName, $arrayColName)) {
                            $colNameNew = substr_replace($rowColName['colName1'], "$colName, ", $posStrFlag, 0);
                            //  = $rowColName['colName1'] . ", $colName";
                            $totalCharType = strlen($rowColName['type1']);
                            // $totalCharEnd = total chars from flag_active to end
                            $totalCharEnd = 47;
                            $colTypeNew = substr_replace($rowColName['type1'], "$dataTypeShort, ", $totalCharType - $totalCharEnd, 0);

                            // $colTypeNew = $rowColName['type1'] . ", $dataTypeShort";
            
                            // echo $colNameNew . "<br>";
                            // echo $colTypeNew . "--<br><br>";
                            $sqlColNameNew = "UPDATE tb_colname_program SET colName1 = \"$colNameNew\", type1=\"$colTypeNew\" WHERE id='$id_cluster'";

                            if ($conn->query($sqlColNameNew) === true) {
                                $sqlAddColumn = "ALTER TABLE tb_program_$id_clusterEdited
                            ADD `$colName` $dataType AFTER `$colNameBefore`";
                                if ($conn->query($sqlAddColumn) === TRUE) {
                                    echo "succeed";

                                    echo "<form id='addSubColumnPage' method='get' action='addSubColumn.php'>";
                                    echo "  <input id='id_cluster' type='hidden' name='id_cluster' value=''>";
                                    echo "  <input id='subColumn' type='hidden' name='subColumn' value=''>";
                                    echo "</form>";

                                    echo "<script>";
                                    echo "        document.getElementById('id_cluster').value = \"$id_cluster\";";
                                    echo "        document.getElementById('subColumn').value = \"$colName\";";
                                    echo "        document.getElementById('addSubColumnPage').submit();";
                                    echo "</script>";
                                } else {
                                    echo "Error colName: " . $conn->error;
                                }
                            }
                        } else {
                            echo "Kolom yang diinput sudah ada";
                        }
                    } else {
                        if ($colType == "text") {
                            $dataType = "TEXT";
                            $dataTypeShort = "text";
                        } else if ($colType == "number") {
                            $dataType = "INT";
                            $dataTypeShort = "int";
                        } else if ($colType == "float") {
                            $dataType = "FLOAT(8,2)";
                            $dataTypeShort = "float";
                        } else if ($colType == "date") {
                            $dataType = "DATE";
                            $dataTypeShort = "date";
                        } else if ($colType == "pic") {
                            $dataType = "text";
                            $dataTypeShort = "pic";
                        }
                        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                        $resultColName = $conn->query($sqlColName);
                        if ($resultColName->num_rows > 0) {
                            $rowColName = $resultColName->fetch_assoc();
                        }

                        $arrayColName = explode(", ", $rowColName['colName1']);
                        //$arrayColType
                        $posArrBeforeFlag = array_search("flag_active", $arrayColName) - 1;
                        $colNameBefore = $arrayColName[$posArrBeforeFlag];
                        
                        $posStrFlag = strpos($rowColName['colName1'], "flag_active");

                        if (!in_array($colName, $arrayColName)) {
                            $colNameNew = substr_replace($rowColName['colName1'], "$colName, ", $posStrFlag, 0);
                            //  = $rowColName['colName1'] . ", $colName";
                            $totalCharType = strlen($rowColName['type1']);
                            // $totalCharEnd = total chars from flag_active to end
                            $totalCharEnd = 47;
                            $colTypeNew = substr_replace($rowColName['type1'], "$dataTypeShort, ", $totalCharType - $totalCharEnd, 0);

                            $sqlColNameNew = "UPDATE tb_colname_program SET colName1 = \"$colNameNew\", type1=\"$colTypeNew\" WHERE id='$id_cluster'";

                            // $sqlNumCol = "SELECT column_name FROM information_schema.columns WHERE table_name = \"tb_program_$id_clusterEdited\"";
                            // $numCol = countNum($sqlNumCol);
                            // $colNameRecord = "colName" . $numCol;
                            // $colTypeRecord = "type" . $numCol;
            
                            // $sqlRecordCol = "UPDATE tb_colname_program SET
                            //     $colNameRecord = '$colName', 
                            //     $colTypeRecord = '$dataType' 
                            //     WHERE id_cluster = '$id_cluster'";
            
                            // echo $sqlRecordCol . "<br>";
            
                            if ($conn->query($sqlColNameNew) === TRUE) {
                                $sqlAddColumn = "ALTER TABLE tb_program_$id_clusterEdited
                                    ADD `$colName` $dataType AFTER `$colNameBefore`";

                                echo $sqlAddColumn . "<br>";
                                if ($conn->query($sqlAddColumn) === TRUE) {
                                    echo "succeed";
                                } else {
                                    echo "Error colName: " . $conn->error;
                                }
                            } else {
                                echo "Error add colNameType: " . $conn->error;
                            }
                        } else {
                            echo "Kolom yang diinput sudah ada";
                        }

                    }
                } else {
                    // Input is invalid
                    echo "Invalid column name";
                }


            } else if (isset($_POST['id_cluster'])) {
                $id_cluster = mysqli_real_escape_string($conn, $_POST['id_cluster']);
            } else if (isset($_GET['id_cluster'])) {
                $id_cluster = mysqli_real_escape_string($conn, $_GET['id_cluster']);
            }

            // $colName = array();
            // if (isset($_POST['numCol'])) {
            //     echo "*";
            //     $numCol = $_POST['numCol'];
            //     for ($indexCol = 0; $indexCol < $numCol; $indexCol++) {
            //         $key = "column" . $indexCol;
            
            //         array_push($colName, $_POST[$key]);
            //     }
            //     $numCol = $_POST['numCol'] + 1;
            // } else {
            //     $numCol = 1;
            // }
            // array_push($colName, "");
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button onclick='returnProgram()' type="button" class="btn btn-dark">Back</button>
                <form action='programTabelSuperadmin.php' method='post' id='returnProgramTabelPage'>
                    <!-- <input type='hidden' name='id_cluster' id='id_cluster' value=""> -->
                </form>
                <script>
                    function returnProgram() {
                        //document.getElementById("id_cluster").value = "<?php //echo $id_cluster; ?>";
                        document.getElementById("returnProgramTabelPage").submit();
                    }
                </script>

                <?php
                $rowCluster = parentFromId($id_cluster, "tb_cluster");
                echo "<h4>" . $rowCluster['cluster'] . "</h4>";
                ?>
                <h2>Add Column</h1>

                    <div class="container">
                        <?php
                        // SQL query to read data from the table
                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                        //$sqlColName = "SELECT column_name, data_type FROM information_schema.columns WHERE table_name = \"tb_program_$id_clusterEdited\"";
                        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                        //$sqlColName = "SHOW COLUMNS FROM tb_program_$id_clusterEdited";
                        
                        // Execute query
                        $resultColName = $conn->query($sqlColName);

                        // Check if any rows were returned
                        if ($resultColName->num_rows > 0) {
                            $colArray = array(
                                "colName" =>
                                array("id", "id_cluster", "nama_ro", "penanggung_jawab_info", "instansi_terkait", "percent_capaian", "b04", "b06", "b09", "b12", "flag_active", "created_by", "created_at", "updated_by", "updated_at"),
                            );

                            $arrayColTb = $resultColName->fetch_assoc();

                            // $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
                            $arrayColName = explode(", ", $arrayColTb['colName1']);
                            // $arrayColType = str_replace("'", "", $arrayColTb['type1']);
                            $arrayColType = explode(", ", $arrayColTb['type1']);
                            // Output data of each row
                            echo "<p>Nama Kolom yang sudah ada:</p>";
                            echo "<ol>";
                            $colSize = sizeof($arrayColName);
                            $child = 0;
                            for ($indexCol = 0; $indexCol < $colSize; $indexCol++) {
                                $colName2 = $arrayColName[$indexCol];
                                if ($arrayColName[$indexCol] == "flag_active") {
                                    continue;
                                } else if (strpos($arrayColType[$indexCol], "arent") != false) {
                                    preg_match_all('!\d+!', $arrayColType[$indexCol], $matches);
                                    $numbers = $matches[0];
                                    if (isset($numbers[0])) {
                                        $child = $numbers[0];
                                    }

                                    $cetakColName = convertSqlColName($arrayColName[$indexCol]);
                                    echo "<li><b>$cetakColName</b> ";
                                    $posCol = array_search($arrayColName[$indexCol], $colArray['colName']);
                                    if ($posCol == 0 && $colName2 != $colArray['colName'][0] && $indexCol > 4) {
                                        echo "<button onclick=\"deleteCol('$colName2')\">Hapus</button>";
                                    }
                                    echo "</li>";
                                    if ($child > 0) {
                                        echo "<ul>";
                                    }
                                } else if ($child > 0) {
                                    $cetakColName = convertSqlColName($arrayColName[$indexCol]);
                                    echo "<li><b>$cetakColName</b> ($arrayColType[$indexCol])</li>";
                                    if ($child == 1) {
                                        echo "</ul>";
                                    }
                                    $child--;
                                } else {
                                    $cetakColName = convertSqlColName($arrayColName[$indexCol]);
                                    echo "<li><b>$cetakColName</b> ($arrayColType[$indexCol]) ";
                                    $posCol = array_search($arrayColName[$indexCol], $colArray['colName']);
                                    if ($posCol == 0 && $colName2 != $colArray['colName'][0] && $indexCol > 4) {
                                        echo "<button onclick=\"deleteCol('$colName2')\">Hapus</button>";
                                    }
                                    echo "</li>";
                                }

                                echo "<form id='deleteCol' action='delete_columnTable.php' method='post'>";
                                echo "  <input type='hidden' id='id_cluster' name='id_cluster' value='$id_cluster'>";
                                echo "  <input type='hidden' id='colName' name='colName' value=''>";
                                echo "</form>";
                                echo "<script>";
                                echo "function deleteCol(colName){
                                    document.getElementById('colName').value = colName;
                                    document.getElementById('deleteCol').submit();
                                }";
                                echo "</script>";
                            }
                            echo "</ol>";

                        } else {
                            echo "No results found";
                        }
                        ?>
                        <form id="addColumnTable" action="./addColumnTable.php" method="post">
                            <input type="hidden" name="id_cluster" value="<?php echo $id_cluster; ?>"></input>
                            <div class="row2">
                                <label for="colName">Nama Kolom</label>
                                <input type="text" id="colName" name="colName" placeholder="nama kolom"
                                    required></input>

                                <label for="colType" style="margin-left:5px;">Tipe</label>
                                <select id="colType" name="colType" required style="width:auto">
                                    <option value="" selected disabled hidden>Pilih tipe</option>
                                    <option value="text">Text</option>
                                    <option value="number">Angka</option>
                                    <option value="float">Desimal</option>
                                    <option value="date">Tanggal</option>
                                    <option value="pic">Instansi Terkait</option>
                                    <option value="subColumn">Subcolumn</option>
                                </select>
                            </div>
                            <input type="submit" name="submit">
                        </form>

                    </div>
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>