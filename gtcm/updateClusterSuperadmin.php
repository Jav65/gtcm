<?php

session_start();
ob_start();

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
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
</head>

<body>
    <div>
        <?php include "connection.php"; ?>
        <?php
        if (isset($_POST["submit"])) {
            $id = $_POST["id_cluster"];
            $cluster = $_POST["cluster"];
            $deskripsi = $_POST["deskripsi"];
            $dateStarted = $_POST['dateStarted'];
            $dateEnd = $_POST['dateEnd'];
            $updated_by = $_SESSION['name'];

            $sql = "UPDATE tb_cluster SET 
                cluster     = '$cluster',
                deskripsi   = '$deskripsi',
                date_started = '$dateStarted', 
                date_end      = '$dateEnd',
                updated_by = '$updated_by'
                WHERE id='$id'";

            if ($conn->query($sql) === TRUE) {
                if($_SESSION['role'] == "Superadmin"){
                    header('location:master_clusterSuperadmin.php');
                  }
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            $id = $_GET["id_cluster"];
            $sql = "SELECT * FROM tb_cluster WHERE id='$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                if ($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $cluster = $row["cluster"];
                    $deskripsi = $row["deskripsi"];
                    $dateStarted = $row['date_started'];
                    $dateEnd = $row['date_end'];
                }
            }
        }
        ?>

    </div>

    <?php include "headerNavigation.php"; ?>

    <div id="main" class="text-black">
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
                        if(role == "Superadmin"){document.getElementById("myFormClusterPage").action = "master_clusterSuperadmin.php";}
                        document.getElementById("myFormClusterPage").submit();
                    }
                </script>
            </div>

        </div>

        <div id="right">
            <h2>Update Cluster</h2>

                <div class="container">
                    <form action="./updateClusterSuperadmin.php" method="post">
                        <div class="row">
                            <label for="id_cluster">ID Cluster:</label>
                            <input type="text" class="form-control" id="id_cluster" value="<?php echo $id; ?>"
                                name="id_cluster" readonly>
                        </div>

                        <div class="row">
                            <label for="=cluster">Cluster:</label>
                            <input type="text" class="form-control" id="cluster" value="<?php echo $cluster; ?>"
                                name="cluster">
                        </div>

                        <div class="row">
                            <label for="deskripsi">Deskripsi</label>
                            <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                            <textarea id="deskripsi" name="deskripsi" rows="4" cols="50" required><?php echo $deskripsi; ?></textarea>
                        </div>

                        <div class="row">
                            <label for="dateStarted">Tanggal Mulai</label>
                            <input type="date" id="dateStarted" name="dateStarted" min="2019-01-01" max="2024-12-31"
                                value="<?php echo $dateStarted; ?>">
                        </div>
                        <div class="row">
                            <label for="dateEnd">Tanggal Berakhir</label>
                            <input type="date" id="dateEnd" name="dateEnd" min="2019-01-01" max="2024-12-31"
                                value="<?php echo $dateEnd; ?>">
                        </div>

                        <div class="row">
                            <input type="submit" name="submit" value="Submit">
                        </div>

                    </form>
                </div>
        </div>

        <?php $conn->close(); ?>
</body>

</html>