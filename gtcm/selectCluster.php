<?php

session_start();

if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin') {
    header("Location: accessDenied.php");
}
include "connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
    <!-- Template Main CSS Tabel -->
    <link href="assetsOperatorTabel/css/main.css" rel="stylesheet">
</head>

<body>
    <?php include "headerNavigation.php"; ?>
    <?php
    $clusterDashboard = array();
    $sqlCluster = "SELECT id_cluster FROM tb_cluster";
    $result = $conn->query($sqlCluster);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($clusterDashboard, $row['id_cluster']);
        }
    }
    ?>

    <div id="main">
        <div id="left2" style="background-color:white; ">
            <div class="item1">
                <div style="display: inline-block; justify-content: center; margin-bottom: 0.5rem;">
                    <button class="button2" onclick="submitFormClusterPage()">Daftar Cluster </button>
                </div>

                <!-- for returning to clusterTabelSuperadmin -->
                <form id="myFormClusterPage" method="get" action="">
                </form>

                <script>
                    function submitFormClusterPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("myFormClusterPage").action = "superadminMainCMMAI.php"; }
                        document.getElementById("myFormClusterPage").submit();
                    }
                </script>
            </div>

        </div>

        <div id="right" class="text-black">
            <h2>Update Cluster</h2>

            <div class="container">
                <form action="./updateClusterSuperadmin.php" method="get">
                    <div class="row">
                        <label for="id_cluster">Cluster</label>
                        <select id="id_cluster" name="id_cluster" required>
                            <option value="" selected disabled hidden>Pilih Cluster</option>
                            <?php
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
</body>

</html>