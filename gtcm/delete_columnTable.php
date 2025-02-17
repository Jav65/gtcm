<?php
session_start();
ob_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI' && $_SESSION['role'] != 'Operator Ministry') {
    header("Location: accessDenied.php");
}
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
    <!-- Template Main CSS Tabel -->
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <?php
        // $program = $_SESSION['program'];
        // $id_program = $_SESSION['id_program'];
        // $id_cluster = $_SESSION['id_cluster'];
        ?>
        <?php
        // sql to delete a record
        $colName = mysqli_real_escape_string($conn, $_POST["colName"]);
        $id_cluster = mysqli_real_escape_string($conn, $_POST['id_cluster']);
        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));

        $sqlColName = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
        $resultColName = $conn->query($sqlColName);
        if ($resultColName->num_rows > 0) {
            $arrayColTb = $resultColName->fetch_assoc();

            // $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
            $arrayColName = explode(", ", $arrayColTb['colName1']);
            // $arrayColType = str_replace("'", "", $arrayColTb['type1']);
            $arrayColType = explode(", ", $arrayColTb['type1']);

            $posCol = array_search($colName, $arrayColName);
            echo "Position: $posCol<br>";
            echo "Col: $colName";
            if ($posCol > 0 || $colName == $arrayColName[0]) {
                if (strpos($arrayColType[$posCol], "arent") != false) {
                    preg_match_all('!\d+!', $arrayColType[$posCol], $matches);
                    $numbers = $matches[0];
                    if (isset($numbers[0])) {
                        $child = $numbers[0];
                    } else {
                        $child = 0;
                    }
                    for ($indexDel = 0; $indexDel < $child; $indexDel++) {
                        $colNameChild = $arrayColName[$posCol + $indexDel + 1];
                        unset($arrayColName[$posCol + $indexDel + 1]);
                        $arrayColName = array_values($arrayColName);

                        unset($arrayColType[$posCol + $indexDel + 1]);
                        $arrayColType = array_values($arrayColType);

                        $sqlRemoveColumn = "ALTER TABLE tb_program_$id_clusterEdited DROP COLUMN $colNameChild";
                        if ($conn->query($sqlRemoveColumn) === TRUE) {
                        }
                    }
                }
                unset($arrayColName[$posCol]);
                $arrayColName = array_values($arrayColName);

                unset($arrayColType[$posCol]);
                $arrayColType = array_values($arrayColType);
            }

            $indexCol = 0;
            $colNameListNew = "";
            $colTypeListNew = "";
            foreach ($arrayColName as $colNameNew) {
                if ($indexCol == 0) {
                    $colNameListNew = $colNameNew;
                    $colTypeListNew = $arrayColType[$indexCol];
                } else {
                    $colNameListNew = $colNameListNew . ", " . $colNameNew;
                    $colTypeListNew = $colTypeListNew . ", " . $arrayColType[$indexCol];
                }
                $indexCol++;
            }
            $colNameListNew = mysqli_real_escape_string($conn, $colNameListNew);
            $colTypeListNew = mysqli_real_escape_string($conn, $colTypeListNew);

            $sqlUpdateColName = "UPDATE tb_colname_program SET colName1 = '$colNameListNew', type1 = '$colTypeListNew' WHERE id='$id_cluster'";
            echo $sqlUpdateColName . "<br>";
            if ($conn->query($sqlUpdateColName) === TRUE) {

                $sqlRemoveColumn = "ALTER TABLE tb_program_$id_clusterEdited DROP COLUMN $colName";
                echo $sqlRemoveColumn . "<br>";

                if ($conn->query($sqlRemoveColumn) === TRUE) {
                    echo "succeed";
                    $linkKolom = "location: addColumnTable.php?id_cluster=$id_cluster";
                    header($linkKolom);
                } else {
                    echo "Error colName: " . $conn->error;
                }
            }
        }

        $conn->close();
        ?>
        <?php include "headerNavigation.php"; ?>
        <div id="main">
            <div class="row">
                <span style="font-size:25px;cursor:pointer;margin:20px;" onclick="openNav()">&#9776; Menu</span>
                <div id="myNav" class="overlay" style="display: none">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <div class="overlay-content">
                        <a href="superadminMainCMMAI.php" style="font-size: 20px; ">Dashboard</a>
                        <hr style="border-top: 1px solid #cccccc; margin:0;">

                        <a href="master_clusterSuperadmin.php" style="font-size: 20px">Daftar Cluster</a>
                        <a href="programTabelSuperadmin.php" style="font-size: 20px" class="mx-2">Daftar Program</a>
                        <a href="indikatorTabelSuperadmin.php" style="font-size: 20px" class="mx-4">Daftar
                            Indikator</a>
                        <a href="kegiatanTabelSuperadmin.php" style="font-size: 20px" class="mx-5">Daftar
                            Kegiatan</a>
                        <hr style="border-top: 1px solid #cccccc; margin:0;">

                        <a href="problemTabelSuperadmin.php" style="font-size: 20px">Problem</a>
                        <hr style="border-top: 1px solid #cccccc; margin:0;">

                        <a href="lateTabelSuperadmin.php" style="font-size: 20px;">Lewat Deadline</a>
                        <hr style="border-top: 1px solid #cccccc; margin:0;">

                        <a href="master_instansi.php" style="font-size: 20px">Master Instansi</a>
                        <hr style="border-top: 1px solid #cccccc; margin:0;">

                        <a href="manageUserSuperadmin.php" style="font-size: 20px">Master User</a>
                        <hr style="border-top: 1px solid #cccccc;margin:0;">

                        <a href="statusTabel.php" style="font-size: 20px">Master Status Kegiatan</a>
                        <hr style="border-top: 1px solid #cccccc;margin:0;">
                    </div>
                </div>
                <script>
                    function openNav() {
                        // document.getElementById("myNav").style.width = "300px";
                        document.getElementById("myNav").style.display = "block";
                        // document.getElementById("main-grid").style.marginLeft="300px";

                    }
                    function closeNav() {
                        // document.getElementById("myNav").style.width = "0%";
                        document.getElementById("myNav").style.display = "none";
                        // document.getElementById("main-grid").style.marginLeft="0";
                    }
                </script>
            </div>

            <div id="right">
                <div class="container-fluid">

                </div>
            </div>
        </div>
    </div>
</body>

</html>