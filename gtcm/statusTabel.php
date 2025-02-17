<?php session_start();
if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin') {
    header("Location: accessDenied.php");
}

include "connection.php";
include "function/myFunc.php";

?>

<html>

<head>
    <?php include "head.html"; ?>
    <!-- Template Main CSS Tabel -->
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">

    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    </style>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('.example').DataTable();
        });

        $('td:nth-child(2)').hover(
            function () {
                $(this).parent('tr').children('td').addClass('hover');
            },
            function () {
                $(this).parent('tr').children('td').removeClass('hover');
            }
        );
    </script>
    <style>
        table {
            border: 1px solid black;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <?php include "headerNavigation.php"; ?>

        <!-- isi disini -->
        <div class="grid-container">
            <div class="item2">
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

                            <a href="statusTabel.php" style="font-size: 20px; color: #ffff00;">Master Status Kegiatan</a>
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
                <div class="container-fluid mt-3">
                    <div class='grid-1'>
                        <h3>Master Status Kegiatan</h3>

                        <div class="searchTable">
                            <button style="background-color: green; order-color: rgb(68, 151, 68); color: white; 
                                border-radius:3px" onclick="window.location.href='addStatus.php'">
                                + add
                            </button>
                        </div>

                        <?php
                        $sqlStatus = "SELECT * FROM tb_statuskegiatan WHERE flag_active=1";
                        $resultStatus = $conn->query($sqlStatus);
                        echo "<div style='width:100%; overflow-x:auto;'>";
                        if ($resultStatus->num_rows > 0) {
                            $indexStatus = 0;
                            echo "<table class='example' class='display' style='width:100%'>";
                            while ($rowStatus = $resultStatus->fetch_assoc()) {
                                if ($indexStatus == 0) {
                                    echo "<thead>";
                                    echo "<tr>";
                                    echo "<th>Aksi</th>";
                                    foreach ($rowStatus as $key => $statusValue) {
                                        if ($key == "flag_active") {
                                            continue;
                                        }
                                        echo "<th>$key</th>";
                                    }
                                    echo "</tr>";
                                    echo "</thead>";
                                    echo "  <tbody>";
                                }

                                echo "<tr>";
                                echo "<td>";
                                $id = $rowStatus['id'];
                                echo "  <button type='button' onclick=\"window.location.href='updateStatus.php?id=$id'\"
                                        class='btn btn-primary' style='margin: 5px 0 3px 0'>Update</button>";
                                echo "  <button type='button' onclick=\"window.location.href='delete_status.php?id=$id'\"
                                        class='btn btn-success' style='margin: 3px 0 5px 0'>Delete</i></button>";
                                //echo "  <button type='button' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>";
                                echo "</td>";
                                foreach ($rowStatus as $key => $statusValue) {
                                    if ($key == "flag_active") {
                                        continue;
                                    }
                                    echo "<td>$statusValue</td>";
                                }
                                echo "</tr>";
                                $indexStatus++;
                            }
                            echo "  </tbody>";
                            echo "</table>";
                        }
                        echo "</div>";
                        ?>

                    </div>
                </div>
            </div>
            <!-- isi disini -->

            <div id="preloader"></div>

            <!-- Vendor JS Files -->
            <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/vendor/aos/aos.js"></script>
            <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
            <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
            <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
            <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
            <script src="assets/vendor/php-email-form/validate.js"></script>

            <!-- Template Main JS File -->
            <script src="assets/js/main.js"></script>
        </div>

</body>

</html>