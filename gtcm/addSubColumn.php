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
                $id_cluster = $_POST['id_cluster'];
                $colName = $_POST['colName'];
                $subColName = $_POST['subColName'];
                $subColName = preg_replace('/\s+/', ' ', $subColName); // replace repeated spaces with a single space
                $subColName = str_replace(" ", "_", $subColName);
                $subColName = str_replace(",", "__", $subColName);
                $subColName = strtolower($subColName);

                $subColType = $_POST['subColType'];
                if ($subColType == "text") {
                    $dataType = "TEXT";
                    $dataTypeShort = "text";
                } else if ($subColType == "number") {
                    $dataType = "INT";
                    $dataTypeShort = "int";
                } else if ($subColType == "float") {
                    $dataType = "FLOAT(8,2)";
                    $dataTypeShort = "float";
                } else if ($subColType == "date") {
                    $dataType = "DATE";
                    $dataTypeShort = "date";
                } else if ($subColType == "pic") {
                    $dataType = "text";
                    $dataTypeShort = "pic";
                }
                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

                $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                $resultColName = $conn->query($sqlColName);
                if ($resultColName->num_rows > 0) {
                    $rowColName = $resultColName->fetch_assoc();
                }
                // not yet
            
                $colNameNew = $rowColName['colName1'];
                $colTypeNew = $rowColName['type1'];
                // $arrayColName = explode(", ", $colNameNew);
                // $arrayColType = explode(", ", $colTypeNew);
            

                $arrayColName = explode(", ", $colNameNew);
                $arrayColType = explode(", ", $colTypeNew);
                //$arrayColType
                $posArrBeforeFlag = array_search("flag_active", $arrayColName) - 1;
                $colNameBefore = $arrayColName[$posArrBeforeFlag];

                $posStrFlag = strpos($rowColName['colName1'], "flag_active");

                if (!in_array($subColName, $arrayColName)) {
                    $colNameNew = substr_replace($rowColName['colName1'], "$subColName, ", $posStrFlag, 0);
                    //  = $rowColName['colName1'] . ", $colName";
                    $totalCharType = strlen($rowColName['type1']);
                    // $totalCharEnd = total chars from flag_active to end
                    $totalCharEnd = 47;
                    $colTypeNew = substr_replace($rowColName['type1'], "$dataTypeShort, ", $totalCharType - $totalCharEnd, 0);

                    $arrayColName = explode(", ", $colNameNew);
                    $arrayColType = explode(", ", $colTypeNew);
                    $colPos = array_search("$colName", $arrayColName);
                    $flagPos = array_search("flag_active", $arrayColName);

                    $arrayColSize = sizeof($arrayColName);
                    $child = $flagPos - $colPos - 1;
                    $arrayColType[$colPos] = "parent($child)";

                    $colNameNew = "";
                    $colTypeNew = "";
                    for ($indexCol = 0; $indexCol < $arrayColSize; $indexCol++) {
                        $colNameNew = $colNameNew . $arrayColName[$indexCol];
                        $colTypeNew = $colTypeNew . $arrayColType[$indexCol];
                        if ($indexCol < $arrayColSize - 1) {
                            $colNameNew = $colNameNew . ", ";
                            $colTypeNew = $colTypeNew . ", ";
                        }
                    }
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
                        ADD `$subColName` $dataType AFTER `$colNameBefore`";

                        if ($conn->query($sqlAddColumn) === TRUE) {
                            echo "succeed";
                        } else {
                            echo "Error colName: " . $conn->error;
                        }
                    } else {
                        echo "Error add colNameType: " . $conn->error;
                    }
                } else {
                    echo "subkolom sudah ada";
                }

            } else if (isset($_POST['backColumn'])) {
                $colName = $_POST['colName'];
                $id_cluster = $_POST['id_cluster2'];

                $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

                $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                $resultColName = $conn->query($sqlColName);
                if ($resultColName->num_rows > 0) {
                    $rowColName = $resultColName->fetch_assoc();
                }
                // not yet
                $colNameNew = $rowColName['colName1'];
                $colTypeNew = $rowColName['type1'];

                $arrayColName = explode(", ", $colNameNew);
                $arrayColType = explode(", ", $colTypeNew);
                $colPos = array_search("$colName", $arrayColName);
                $arrayColSize = sizeof($arrayColName);
                $flagPos = array_search("flag_active", $arrayColName);
                $child = $flagPos - $colPos - 1;
                if ($child == 0) {
                    $boolDel = 1;
                    if ($boolDel == 1) {
                        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                        $resultColName = $conn->query($sqlColName);
                        if ($resultColName->num_rows > 0) {
                            $rowColName = $resultColName->fetch_assoc();
                        }
                        // not yet
                        $colNameNew = str_replace(", $colName", "", $rowColName['colName1']);

                        $colTypeNew = $rowColName['type1'];
                        $needle = ", parent(0)";
                        $lastPos = strrpos($colTypeNew, $needle);

                        if ($lastPos !== false) {
                            $colTypeNew = substr_replace($colTypeNew, "", $lastPos, strlen($needle));
                        } else {
                            // echo "Needle not found in string";
                        }

                        $sqlColNameNew = "UPDATE tb_colname_program SET colName1 = \"$colNameNew\", type1=\"$colTypeNew\" WHERE id='$id_cluster'";

                        if ($conn->query($sqlColNameNew) === TRUE) {
                            $sqlDropCol = "ALTER TABLE tb_program_$id_clusterEdited
                            DROP COLUMN `$colName`";

                            if ($conn->query($sqlDropCol) === TRUE) {
                                // echo "succedd";
                                echo "<form action='addColumnTable.php' method='post' id='backColumnPage'>";
                                echo "<input type='hidden' name='id_cluster' id='id_cluster' value=''>";
                                echo "</form>";

                                echo "<script>";
                                echo "document.getElementById('id_cluster').value = '$id_cluster';";
                                echo "document.getElementById('backColumnPage').submit();";
                                echo "</script>";
                            } else {
                                // echo "Error colName: " . $conn->error;
                            }
                        } else {
                            // echo "Error add colNameType: " . $conn->error;
                        }
                    }
                } else {
                    echo "<form action='addColumnTable.php' method='post' id='backColumnPage'>";
                    echo "<input type='hidden' name='id_cluster' id='id_cluster' value=''>";
                    echo "</form>";

                    echo "<script>";
                    echo "document.getElementById('id_cluster').value = '$id_cluster';";
                    echo "document.getElementById('backColumnPage').submit();";
                    echo "</script>";
                }

            } else if (isset($_GET['subColumn'])) {
                $colName = $_GET['subColumn'];
                $id_cluster = $_GET['id_cluster'];
            } else {
                //$id_cluster = "CL-3";
            }

            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button onclick='returnToAddCol()' type="button" class="btn btn-dark">Back</button>
                <form action='addSubColumn.php' method='post' id='addSubColumnPage'>
                    <input type='hidden' name='id_cluster2' id='id_cluster2' value="">
                    <input type='hidden' name='colName' id='colName' value="">
                    <input type='hidden' name='backColumn' id='backColumn' value="">
                </form>
                <script>
                    function returnToAddCol() {
                        document.getElementById("id_cluster2").value = "<?php echo $id_cluster; ?>";
                        document.getElementById("colName").value = "<?php echo $colName; ?>";
                        document.getElementById("backColumn").value = "1";
                        document.getElementById("addSubColumnPage").submit();
                    }
                </script>
                <?php
                $rowCluster = parentFromId($id_cluster, "tb_cluster");
                echo "<h4>" . $rowCluster['cluster'] . "</h4>";
                ?>
                <h2>Add SubColumn</h1>

                    <div class="container">
                        <?php
                        // SQL query to read data from the table
                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                        //$sqlColName = "SELECT column_name, data_type FROM information_schema.columns WHERE table_name = \"tb_program_$id_clusterEdited\"";
                        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                        $resultColName = $conn->query($sqlColName);
                        if ($resultColName->num_rows > 0) {
                            $arrayColTb = $resultColName->fetch_assoc();
                        }

                        $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
                        $arrayColName = explode(", ", $arrayColName);
                        $arrayColType = str_replace("'", "", $arrayColTb['type1']);
                        $arrayColType = explode(", ", $arrayColType);

                        $subColumnPos = array_search($colName, $arrayColName) + 1;

                        $cetakColName = convertSqlColName($colName);
                        echo "<p>Nama Kolom: $cetakColName</p>";

                        if (isset($arrayColName[$subColumnPos])) {
                            if (strpos($arrayColType[$subColumnPos-1], "arent") != false) {
                                preg_match_all('!\d+!', $arrayColType[$subColumnPos-1], $matches);
                                $numbers = $matches[0];
                                if (isset($numbers[0])) {
                                    $childLoop = $numbers[0];
                                }
                                else{$childLoop = 0;}
                            }
                            else{$childLoop = 0;}

                            //$indexSubCol = 0;
                            // $sizeCol = sizeof($arrayColName);
                            echo "<ul>";
                            $endLoop = $subColumnPos +$childLoop;
                            while ($subColumnPos < $endLoop) {
                                $cetakSubColName = convertSqlColName($arrayColName[$subColumnPos]);
                                echo "<li><b>$cetakSubColName</b> ($arrayColType[$subColumnPos])</li>";
                                $subColumnPos++;
                            }
                            echo "</ul>";
                        }

                        ?>
                        <form id="addSubColumnTable" action="./addSubColumn.php" method="post">
                            <input type="hidden" name="id_cluster" value="<?php echo $id_cluster; ?>"></input>
                            <input type="hidden" name="colName" value="<?php echo $colName; ?>"></input>
                            <div class="row2">
                                <label for="subColName">Nama subkolom</label>
                                <input type="text" id="subColName" name="subColName" placeholder="nama sub kolom"
                                    required></input>

                                <label for="subColType" style="margin-left:5px;">Tipe</label>
                                <select id="subColType" name="subColType" required style="width:auto">
                                    <option value="" selected disabled hidden>Pilih tipe</option>
                                    <option value="text">Text</option>
                                    <option value="number">Angka</option>
                                    <option value="float">Desimal</option>
                                    <option value="date">Tanggal</option>
                                    <option value="pic">Instansi Terkait</option>

                                </select>
                            </div>
                            <input type="submit" name="submit">
                        </form>
                        <script>
                            function addColumn() {
                                document.getElementById("addColumnTable").submit();
                            }
                        </script>
                    </div>
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>