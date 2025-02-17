<?php session_start(); ?>
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
            } else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI') {
                header("Location: accessDenied.php");
            }
            include "connection.php";
            include "function/idListTable.php";
            ?>
        </div>
        <div>
            <?php
            if (isset($_POST['submit'])) {
                $id_cluster = $_POST['id_cluster'];
                $program = $_POST['program'];

                $duk_maritim = $_POST['duk_maritim'];
                $status = $_POST['status'];
                $deskripsi_lain = $_POST['des_lain'];
                if ($deskripsi_lain == "") {
                    $deskripsi_lain = "-";
                }
                $tahun_selesai = $_POST['tahun_selesai'];
                $created_by = $_SESSION['name'];

                // $sql = "INSERT INTO tb_program (id_cluster, id_program, program, pic, duk_maritim, status, deskripsi_lain, tahun_selesai, created_by)
                //         VALUES ('$id_cluster', '$id_program', '$program', '$pic', '$duk_maritim', '$status', '$deskripsi_lain', '$tahun_selesai', '$created_by')";
            
                // if ($conn->multi_query($sql) === TRUE) {
                //   echo "New records created successfully";
                //   $_SESSION['id_cluster'] = $id_cluster;
                //   if ($_SESSION['role'] == "Superadmin") {
                //     header('location:programTabelSuperadmin.php');
                //   } else if ($_SESSION['role'] == "Operator CMMAI") {
                //     header('location:programTabelOperatorCMMAI.php');
                //   }
                // } else {
                //   echo "Error: " . $sql . "<br>" . $conn->error;
                // }
            }

            $clusterDashboard = idListTable("tb_cluster");
            $arrayIdKementrian = idListTable("tb_master_kementrian");

            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <div id="left2" style="background-color:white; ">
                <div class="item1">
                    <div style="display: inline-block; justify-content: center; margin-bottom: 0.5rem;">
                        <button class="button2" onclick="submitFormClusterPage()">Daftar Cluster </button>
                        <button class="button2" onclick="submitFormProgramPage()">Daftar Program </button>
                    </div>

                    <!-- for returning to clusterTabelSuperadmin -->
                    <form id="myFormClusterPage" method="get" action="">
                    </form>

                    <script>
                        function submitFormClusterPage() {
                            role = "<?php echo $_SESSION['role']; ?>";
                            if (role == "Superadmin") { document.getElementById("myFormClusterPage").action = "superadminMainCMMAI.php"; }
                            else if (role == "Operator CMMAI") { document.getElementById("myFormClusterPage").action = "operatorMainCMMAI.php"; }
                            document.getElementById("myFormClusterPage").submit();
                        }
                    </script>

                    <!-- for returning to programTabelSuperadmin -->
                    <form id="myFormProgramPage" method="get" action="">
                        <input id="myIdClusterPage" type="hidden" name="id_cluster" value="">
                        <input id="myPICPage" type="hidden" name="pic" value="">
                        <input id="myStatusPage" type="hidden" name="status" value="">

                        <input id="myTahunSelesaiPage" type="hidden" name="tahun_selesai" value="">
                    </form>

                    <script>
                        function submitFormProgramPage() {
                            role = "<?php echo $_SESSION['role']; ?>";
                            if (role == "Superadmin") { document.getElementById("myFormProgramPage").action = "programTabelSuperadmin.php"; }
                            else if (role == "Operator CMMAI") { document.getElementById("myFormProgramPage").action = "programTabelOperatorCMMAI.php"; }

                            document.getElementById("myIdClusterPage").value = "<?php echo $_SESSION['id_cluster']; ?>";
                            document.getElementById("myPICPage").value = "<?php echo $_SESSION['pic']; ?>";
                            document.getElementById("myStatusPage").value = "<?php echo $_SESSION['status']; ?>";

                            document.getElementById("myTahunSelesaiPage").value = "<?php echo $_SESSION['tahun_selesai']; ?>";
                            document.getElementById("myFormProgramPage").submit();
                        }
                    </script>
                </div>

            </div>

            <div id="right" class="text-black">
                <h2>Add Program</h1>

                    <div class="container">
                        <form action="./selectName.php" method="post">
                            <div class="row">
                                <label for="pic">PIC</label>
                                <select id="pic" name="pic" required>
                                    <optgroup label="Superadmin Kemenkomarves">
                                        <option value="MI-1_SP-">Kemenko Bidang Kemaritiman dan Investasi</option>
                                    </optgroup>
                                    <optgroup label="Operator Kemenkomarves">
                                        <option value="MI-1_OP-">Kemenko Bidang Kemaritiman dan Investasi</option>
                                    </optgroup>
                                    <optgroup label="Operator Kementrian di bawah Kemenkomarves">
                                        <?php
                                        foreach ($arrayIdKementrian as $id_kementrian) {
                                            if ($id_kementrian == "MI-1") {
                                                continue;
                                            }
                                            $sqlKementrian = "SELECT kementrian FROM tb_master_kementrian WHERE id='$id_kementrian'";
                                            $result = $conn->query($sqlKementrian);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $kementrian = $row['kementrian'];
                                                    echo '<option value="' . $id_kementrian . '_OB-">' . $kementrian . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </optgroup>

                                    <optgroup label="Observer Kemenkomarves">
                                        <option value="MI-1_OB-">Kemenko Bidang Kemaritiman dan Investasi</option>
                                    </optgroup>
                                    <optgroup label="Observer Kementrian di bawah Kemenkomarves">
                                        <?php
                                        foreach ($arrayIdKementrian as $id_kementrian) {
                                            if ($id_kementrian == "MI-1") {
                                                continue;
                                            }
                                            $sqlKementrian = "SELECT kementrian FROM tb_master_kementrian WHERE id='$id_kementrian'";
                                            $result = $conn->query($sqlKementrian);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    $kementrian = $row['kementrian'];
                                                    echo '<option value="' . $id_kementrian . '_OB-">' . $kementrian . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="row">
                                <input type="submit" name="submit" value="Submit">
                            </div>
                            <br>
                            
                            <fieldset>
                                <legend>Summary:</legend>
                                <div class="row">
                                    <label for="id_cluster">Cluster</label>
                                    <select id="id_cluster" name="id_cluster" required>
                                        <option value="" selected disabled hidden>Pilih Cluster</option>
                                        <?php
                                        foreach ($clusterDashboard as $id_cluster) {
                                            $sqlCluster = "SELECT cluster FROM tb_cluster WHERE id='$id_cluster'";
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
                                    <script>
                                        document.getElementById("id_cluster").value = "<?php echo $id_cluster; ?>";
                                    </script>
                                </div>

                                <div class="row">
                                    <label for="program">PROGRAM</label>
                                    <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                                    <textarea id="program" name="program" rows="4" cols="50" placeholder="Add Program"
                                        required><?php echo $program; ?></textarea>
                                </div>

                                <div class="row">
                                    <label for="duk_maritim">Dukungan Maritim</label>
                                    <select id="duk_maritim" name="duk_maritim" required>
                                        <option value="" selected disabled hidden>Ya/Tidak</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    <script>
                                        document.getElementById("duk_maritim").value = "<?php echo $duk_maritim; ?>";
                                    </script>
                                </div>

                                <div class="row">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" required>
                                        <option value="" selected disabled hidden>Pilih Status</option>
                                        <option value="Belum Dimulai">Belum Dimulai</option>
                                        <option value="Sedang Berjalan">Sedang Berjalan</option>
                                        <option value="Selesai">Selesai</option>
                                        <option value="Suspend">Suspend</option>
                                    </select>
                                    <script>
                                        document.getElementById("status").value = "<?php echo $status; ?>";
                                    </script>
                                </div>

                                <div class="row">
                                    <label for="tahun_selesai">Tahun Selesai</label>
                                    <input type="month" id="tahun_selesai" name="tahun_selesai" min="2019-01"
                                        max="2024-12">

                                    <script>
                                        document.getElementById("tahun_selesai").value = "<?php echo $tahun_selesai; ?>";
                                    </script>
                                </div>

                                <div class="row">
                                    <label for="des_lain">Deskripsi Lainnya</label>
                                    <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                                    <textarea id="des_lain" name="des_lain" rows="4" cols="50"
                                        placeholder="Deskripsi lain"><?php echo $deskripsi_lain; ?></textarea>
                                </div>
                            </fieldset>
                        </form>
                    </div>
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>