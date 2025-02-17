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
            } else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI' && $_SESSION['role'] != 'Operator Ministry') {
                header("Location: accessDenied.php");
            }
            include "connection.php";
            include "function/myFunc.php";
            ?>
        </div>
        <div>
            <?php
            // $program = $_SESSION['program'];
            // $id_program = $_SESSION['id_program'];
            // $id_cluster = $_SESSION['id_cluster'];
            if (isset($_GET['id_indikator'])) {
                $id_indikator = $_GET['id_indikator'];
            }
            ?>
            <?php
            if (isset($_POST['submit'])) {
                $id_kegiatan = $_POST['id_kegiatan'];
                $kegiatan = $_POST['kegiatan'];
                $lokasi = $_POST['lokasi'];
                $dateStarted = $_POST['dateStarted'];
                $dateEnd = $_POST['dateEnd'];
                $status = $_POST['status'];

                $id_indikator = $_SESSION['id_indikator'];

                $updated_by = $_SESSION['name'];

                $sql = "UPDATE tb_kegiatan SET 
                kegiatan     = '$kegiatan',
                lokasi         = '$lokasi',
                tanggal_mulai = '$dateStarted', 
                tanggal_berakhir      = '$dateEnd',
                status      = '$status',
                updated_by = '$updated_by'

                WHERE id='$id_kegiatan'";


                if ($conn->query($sql) === TRUE) {
                    echo "New records created successfully";

                    // update status indikator
                    $selesai = "SELECT * FROM tb_kegiatan WHERE id_indikator='$id_indikator' AND status='Selesai'";
                    # note that it is not ==, but '=' (assign value to result and check the value of result)
                    if ($result = $conn->query($selesai)) {
                        // Return the number of rows in result set
                        $selesaiCount = mysqli_num_rows($result);
                    }

                    $all = "SELECT * FROM tb_kegiatan WHERE id_indikator='$id_indikator'";
                    # note that it is not ==, but '=' (assign value to result and check the value of result)
                    if ($result = $conn->query($all)) {
                        // Return the number of rows in result set
                        $allCount = mysqli_num_rows($result);
                    }
                    $status_capaian = $selesaiCount * 100.0 / $allCount;

                    $sql = "UPDATE tb_indikator SET 
                        status_capaian = '$status_capaian'
                        WHERE id = '$id_indikator'";

                    if ($conn->query($sql) === TRUE) {
                        if ($_SESSION['role'] == "Superadmin") {
                            header('location:kegiatanTabelSuperadmin.php');
                        } else if ($_SESSION['role'] == "Operator CMMAI") {
                            header('location:kegiatanTabelOperatorCMMAI.php');
                        } else if ($_SESSION['role'] == "Operator Ministry") {
                            header('location:kegiatanTabelOperatorMinistry.php');
                        }
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $id_kegiatan = $_GET['id_kegiatan'];
                $sql = "SELECT * FROM tb_kegiatan WHERE id='$id_kegiatan'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    if ($row = $result->fetch_assoc()) {
                        $id_indikator = $row['id_indikator'];
                        $_SESSION['id_indikator'] = $id_indikator;
                        $kegiatan = $row['kegiatan'];
                        $lokasi = $row['lokasi'];
                        $dateStarted = $row['tanggal_mulai'];
                        $dateEnd = $row['tanggal_berakhir'];
                        $status = $row['status'];

                    }
                }

            }
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
            <button type="button" class="btn btn-dark" onclick="backKegiatanPage()">Back</button>
                <form id="backKegiatanPage" method="get" action="">
                    <!-- <input id="myIdIndikatorPage" type="hidden" name="id_indikator" value=""> -->
                </form>
                <script>
                    function backKegiatanPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backKegiatanPage").action = "kegiatanTabelSuperadmin.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backKegiatanPage").action = "kegiatanTabelOperatorCMMAI.php"; }
                        else if (role == "Operator Ministry") { document.getElementById("backKegiatanPage").action = "kegiatanTabelOperatorMinistry.php"; }

                        // document.getElementById("myIdIndikatorPage").value = "<?php //echo $_SESSION['id_indikator']; ?>";

                        document.getElementById("backKegiatanPage").submit();
                    }
                </script>
                <h2>Update Kegiatan</h2>

                <div class="container">
                    <form action="./updateKegiatan.php" method="post" enctype="multipart/form-data">
                        <input type='hidden' id='id_indikator' name='id_indikator' value="<?php echo $id_indikator; ?>"
                            required>

                        <div class="row2">
                            <label for="id_kegiatan">ID Kegiatan:</label>
                            <input type="text" class="form-control" id="id_kegiatan" value="<?php echo $id_kegiatan; ?>"
                                name="id_kegiatan" readonly>
                        </div>
                        <div class="row2">
                            <label for="kegiatan">Kegiatan</label>
                            <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                            <textarea id="kegiatan" name="kegiatan" rows="4" cols="50" placeholder="Add Kegiatan"
                                required><?php echo $kegiatan; ?></textarea>
                        </div>

                        <div class="row2">
                            <label for="lokasi">Lokasi</label>
                            <input id="lokasi" type="text" name="lokasi" placeholder="lokasi"
                                value="<?php echo $lokasi; ?>">
                        </div>

                        <div class="row2">
                            <label for="dateStarted">Tanggal Mulai</label>
                            <input type="date" id="dateStarted" name="dateStarted" min="2019-01-01" max="2024-12-31"
                                value="<?php echo $dateStarted; ?>">
                        </div>
                        <div class="row2">
                            <label for="dateEnd">Tanggal Berakhir</label>
                            <input type="date" id="dateEnd" name="dateEnd" min="2019-01-01" max="2024-12-31"
                                value="<?php echo $dateEnd; ?>">
                        </div>


                        <div class="row2">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <?php
                                $idStatusList = idListTable("tb_statuskegiatan");
                                foreach ($idStatusList as $id_status) {
                                    $statusInfo = parentFromId($id_status, "tb_statuskegiatan");
                                    $id_status = $statusInfo['id'];
                                    $status = $statusInfo['status'];
                                    echo "<option value='$status'>$status</option>";
                                }

                                ?>
                            </select>
                            <script>
                                var x = document.getElementById("status");
                                var status = "<?php echo $status; ?>";
                                for (var i = 0; i < x.options.length; i++) {
                                    if (x.options[i].value === status) {
                                        x.options[i].selected = true;
                                        break;
                                    }
                                }
                            </script>
                        </div>

                        <div class="row">
                            <input type="submit" name="submit" value="Submit">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <?php $conn->close(); ?>
</body>

</html>