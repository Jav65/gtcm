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

    <script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>
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

        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>
            <div id="right" class="text-black">
                <button type="button" class="btn btn-dark" onclick="returnKegiatan()">Back</button>
                <form action='' method='get' id='returnKegiatanPage'>
                    <input type='hidden' id='id_kegiatan' name='id_kegiatan' value=''>
                </form>
                <script>
                    function returnKegiatan() {
                        <?php

                        if (!isset($_GET['id_kegiatan'])) {
                            $id_kegiatan = "";
                            if ($_SESSION['role'] == "Superadmin") {
                                $linkKegiatan = "kegiatanTabelSuperadmin.php";
                            } else if ($_SESSION['role'] == "Operator CMMAI") {
                                $linkKegiatan = "kegiatanTabelOperatorCMMAI.php";
                            } else if ($_SESSION['role'] == "Operator Ministry") {
                                $linkKegiatan = "kegiatanTabelOperatorMinistry.php";
                            }
                        } else {
                            $id_kegiatan = $_GET['id_kegiatan'];

                            $linkKegiatan = "kegiatanDetail.php";


                        }
                        ?>
                        document.getElementById("id_kegiatan").value = "<?php echo $id_kegiatan; ?>"
                        document.getElementById("returnKegiatanPage").action = "<?php echo $linkKegiatan; ?>";
                        document.getElementById("returnKegiatanPage").submit();
                    }
                </script>


                <?php
                if (isset($_GET['id_kegiatan']) && $_GET['id_kegiatan'] != "") {
                    $id_kegiatan = $_GET['id_kegiatan'];
                    $idArray = explode("_", $id_kegiatan);
                    $divName = "kegiatan";
                    ?>
                    <div class="container">
                        <div class="row hidden-md-up">
                            <div class="col-md-6">
                                <div class="card" style='height:100%'>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 class="card-title">Add Problem</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://cdn-icons-png.flaticon.com/512/1935/1935827.png"
                                                    width="100%" height="100%" style="max-width: 150px; max-height: 150px;">
                                            </div>
                                        </div>
                                        <?php
                                        if ($divName == "kegiatan") {
                                            $linkProblem = "window.location.href='addProblem.php?id_kegiatan=$id_kegiatan'";
                                        }
                                        echo "<button type='button' class='btn btn-primary' onclick=\"$linkProblem\">Add</button>";
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card" style='height:100%'>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 class="card-title">Add Evidence</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <img src="https://cdn-icons-png.flaticon.com/512/124/124837.png"
                                                    width="100%" height="100%" style="max-width: 150px; max-height: 150px;">
                                            </div>

                                        </div>
                                        <?php
                                        if ($divName == "kegiatan") {
                                            $linkEvidence = "window.location.href='addEvidence.php?id_kegiatan=$id_kegiatan'";
                                        }
                                        echo "<button type='button' class='btn btn-primary' onclick=\"$linkEvidence\">Add</button>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "<p>ID tidak valid</p>";
                    // if ($_SESSION['role'] == "Superadmin") {
                    //     header("location:superadminMainCMMAI.php");
                    // } else if ($_SESSION['role'] == "Operator CMMAI") {
                    //     header("location:operatorMainCMMAI.php");
                    // } else if ($_SESSION['role'] == "Operator Ministry") {
                    //     header("location:operator_ministryMain.php");
                    // } else if ($_SESSION['role'] == "Observer CMMAI") {
                    //     header("location:dashboardMainCMMAI.php");
                    // } else if ($_SESSION['role'] == "Observer Ministry") {
                    //     header("location:dashboardMainMinistry.php");
                    // }
                }
                ?>


            </div>
        </div>

        <?php $conn->close(); ?>
    </div>
</body>

</html>