<?php
session_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI') {
    header("Location: accessDenied.php");
}
include "connection.php";
include "function/myFunc.php";
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
    <link href="assetsOperatorTabel/css/main.css" rel="stylesheet">
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <?php
        if (isset($_GET['submit'])) {
            // sql to delete a record
            $id = $_GET["id_cluster"];
            $sql = "UPDATE tb_cluster SET 
				flag_active     = 0
				WHERE id_cluster='$id'";
            if ($conn->query($sql) === TRUE) {
                $sqlProgram = "SELECT * FROM tb_program WHERE id_cluster='$id'";
                $resultProgram = $conn->query($sqlProgram);

                if ($resultProgram->num_rows > 0) {
                    $sqlProgramUpdate = "UPDATE tb_program SET 
			                            flag_active     = 0
			                            WHERE id_cluster='$id'";
                    if ($conn->query($sqlProgramUpdate) === TRUE) {
                        while ($rowProgram = $resultProgram->fetch_assoc()) {
                            $id_program = $rowProgram['id_program'];

                            $sqlIndikator = "SELECT * FROM tb_indikator WHERE id_program='$id_program'";
                            $resultIndikator = $conn->query($sqlIndikator);

                            if ($resultIndikator->num_rows > 0) {
                                $sqlIndikatorUpdate = "UPDATE tb_indikator SET 
			                                            flag_active     = 0
			                                            WHERE id_program='$id_program'";
                                if ($conn->query($sqlIndikatorUpdate) === TRUE) {
                                    // $sqlIndikator = "SELECT * FROM tb_indikator WHERE id_program='$id'";
                                    // $resultIndikator = $conn->query($sqlIndikator);
        
                                    //if ($resultIndikator->num_rows > 0) {
                                    while ($rowIndikator = $resultIndikator->fetch_assoc()) {
                                        $id_indikator = $rowIndikator['id_indikator'];

                                        $sqlKegiatan = "UPDATE tb_kegiatan SET 
                                                        flag_active     = 0
                                                        WHERE id_indikator='$id_indikator'";

                                        $conn->query($sqlKegiatan);
                                    }

                                }

                            }
                        }
                    }
                }
            }
            if ($_SESSION['role'] == "Superadmin") {
                header('location:superadminMainCMMAI.php');
            }
        }

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

            <div id="right" class="text-black">
                <div class="container">
                    <form action="./delete_clusterSuperadmin.php" method="get">
                        <div class="row">
                            <label for="id_cluster">Cluster</label>
                            <select id="id_cluster" name="id_cluster" required>
                                <option value="" selected disabled hidden>Pilih Cluster</option>
                                <?php
                                $clusterDashboard = array();
                                $sqlCluster = "SELECT id_cluster FROM tb_cluster";
                                $result = $conn->query($sqlCluster);
                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        array_push($clusterDashboard, $row['id_cluster']);
                                        echo "1";
                                    }
                                }

                                foreach ($clusterDashboard as $id_cluster) {
                                    $sqlCluster = "SELECT cluster FROM tb_cluster WHERE id_cluster='$id_cluster'";
                                    $result = $conn->query($sqlCluster);
                                    if ($result->num_rows > 0) {
                                        // output data of each row
                                        while ($row = $result->fetch_assoc()) {
                                            $cluster = $row['cluster'];
                                            echo '<option value="' . $id_cluster . '">' . $cluster . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>