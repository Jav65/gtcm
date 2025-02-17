<?php session_start();
ob_start();
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
        td.hover {
            background-color: #f1f1f1;
        }

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
        <div class="grid-container">
            <div class="item2">
                <?php menu("master_instansi");?>

                <!-- isi disini -->


                <div class="container-fluid mt-3">
                    <div class='grid-1'>
                        <h3>Master Instansi</h3>

                        <div class="searchTable">
                            <button style="background-color: green; order-color: rgb(68, 151, 68); color: white; 
                                border-radius:3px" onclick="window.location.href='addMasterInstansi.php'">
                                + add
                            </button>
                        </div>

                        <?php
                        $sqlStatus = "SELECT * FROM tb_master_kementrian WHERE flag_active=1";
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
                                echo "  <button type='button' onclick=\"window.location.href='updateInstansi.php?id_instansi=$id'\"
                                        class='btn btn-primary' style='margin: 5px 0 3px 0'>Update</button>";
                                echo "  <button type='button' onclick=\"window.location.href='delete_instansi.php?id_instansi=$id'\"
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