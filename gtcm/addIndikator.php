<?php
session_start();
ob_start();
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
            <!-- Read current program -->
            <?php
            // $program = $_SESSION['program'];
            // $id_program = $_SESSION['id_program'];
            // $id_cluster = $_SESSION['id_cluster'];
            ?>

            <!-- insert into database -->
            <?php
            if (isset($_POST['submit'])) {
                $id_program = mysqli_real_escape_string($conn, $_POST['id_program']);
                $indikator = mysqli_real_escape_string($conn, $_POST['indikator']);

                $programIndikator = "SELECT * FROM tb_indikator where id_program='$id_program'";
                # note that it is not ==, but '=' (assign value to result and check the value of result)
                if ($result = $conn->query($programIndikator)) {
                    // Return the number of rows in result set
                    $programIndikatorCount = mysqli_num_rows($result) + 1;
                }
                $id_indikator = mysqli_real_escape_string($conn, $id_program . "_IK-" . $programIndikatorCount);
                $baseline = mysqli_real_escape_string($conn, $_POST['baseline']);
                $target = mysqli_real_escape_string($conn, $_POST['target']);
                $capaian = mysqli_real_escape_string($conn, $_POST['capaian']);

                $penanggung_jawab_info = "0";

                $created_by = mysqli_real_escape_string($conn, $_SESSION['name']);
                $updated_by = mysqli_real_escape_string($conn, $_SESSION['name']);
                $status_capaian = 0;
                $sql = "INSERT INTO tb_indikator (id_program, id, indikator, baseline, target, capaian, status_capaian, created_by, updated_by, penanggung_jawab_info)
                VALUES ('$id_program', '$id_indikator', '$indikator', '$baseline', '$target', '$capaian', '$status_capaian', '$created_by', '$updated_by', '$penanggung_jawab_info')";

                if ($conn->multi_query($sql) === TRUE) {
                    $link = "location:addPenanggungJawabIndikator.php?id_div=$id_indikator";
                    header($link);
                    //echo "New records created successfully";
                    // $_SESSION['id_program'] = $id_program;
            
                    // if ($_SESSION['role'] == "Superadmin") {
                    //     header('location:indikatorTabelSuperadmin.php');
                    // } else if ($_SESSION['role'] == "Operator CMMAI") {
                    //     header('location:indikatorTabelOperatorCMMAI.php');
                    // } else if ($_SESSION['role'] == "Operator Ministry") {
                    //     header('location:indikatorTabelOperatorMinistry.php');
                    // }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else if ($_GET['id_program']) {
                $id_program = $_GET['id_program'];
            }
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button type="button" class="btn btn-dark" onclick="backIndikatorPage()">Back</button>
                <form id="backIndikatorPage" method="get" action="">
                    <!-- <input id="myIdIndikatorPage" type="hidden" name="id_indikator" value=""> -->
                </form>
                <script>
                    function backIndikatorPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backIndikatorPage").action = "indikatorTabelSuperadmin.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backIndikatorPage").action = "indikatorTabelOperatorCMMAI.php"; }
                        else if (role == "Operator Ministry") { document.getElementById("backIndikatorPage").action = "indikatorTabelOperatorMinistry.php"; }

                        // document.getElementById("myIdIndikatorPage").value = "<?php //echo $_SESSION['id_indikator']; ?>";

                        document.getElementById("backIndikatorPage").submit();
                    }
                </script>

                <h3>Add Indikator</h3>
                <div>
                    <h4 style="display: inline-block; ">Cluster:
                        <?php
                        $id_cluster = explode("_", $id_program)[0];
                        $clusterInfo = parentFromId($id_cluster, "tb_cluster");
                        echo $clusterInfo['cluster'];
                        ?>
                    </h4>
                    <br>
                    <h4 style="display: inline-block; ">Program:
                        <?php
                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                        $sqlProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
                        $resultProgram = $conn->query($sqlProgram);
                        if ($resultProgram->num_rows > 0) {
                            $rowProgram = $resultProgram->fetch_assoc();
                            $indexProgram = 0;
                            foreach ($rowProgram as $key => $keyValue) {
                                if ($indexProgram == 2) {
                                    $program = $rowProgram[$key];
                                }
                                $indexProgram++;
                            }

                        }
                        echo $program; ?>
                    </h4>
                    <br>
                </div>

                <div class="container">
                    <form action="./addIndikator.php" method="post">
                        <input type='hidden' id='id_program' name='id_program' value="<?php echo $id_program; ?>"
                            required>
                        <div class="row">
                            <label for="indikator">INDIKATOR</label>
                            <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                            <textarea id="indikator" name="indikator" rows="4" cols="50" placeholder="Add Indikator"
                                required></textarea>
                        </div>

                        <div class="row">
                            <label for="baseline">BASELINE</label>
                            <input type="text" id="baseline" name="baseline" required>
                        </div>

                        <div class="row">
                            <label for="target">TARGET</label>
                            <input type="text" id="target" name="target" required>
                        </div>

                        <div class="row">
                            <label for="capaian">CAPAIAN</label>
                            <input type="text" id="capaian" name="capaian" value="0" required>
                        </div>

                        <!-- <div class='row2'>
                                <label for="penanggung_jawab_info">PENANGGUNG JAWAB INFO</label>
                                <div class='rowChild'>
                                    <label for='nama'>NAMA</label>
                                    <input type='text' id='nama' name='nama'
                                        placeholder='Nama' required>
                                </div>
                                
                                <div class='rowChild'>
                                    <label for='posisi'>Posisi</label>
                                    <input type='text' id='posisi' name='posisi'
                                        placeholder='Posisi' required>
                                </div>

                                <div class='rowChild'>
                                    <label for='hp'>No. Telp</label>
                                    <input type="tel" id="hp" name="hp" value="" placeholder="No. hp">
                                </div>

                                <div class="rowChild">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="email">
                                </div>
                            </div> -->

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