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
            } else if ($_SESSION['role'] != 'Superadmin') {
                header("Location: accessDenied.php");
            }
            include "connection.php";
            include "function/myFunc.php";
            ?>
        </div>
        <div>
            <?php

            if (isset($_POST['submit'])) {
                $id_instansi = mysqli_real_escape_string($conn, $_POST['id_instansi']);
                $instansi_name = mysqli_real_escape_string($conn, $_POST['instansi_name']);
                
                $updated_by = mysqli_real_escape_string($conn, $_SESSION['name']);
                $sqlUpdateInstansi = "UPDATE tb_master_kementrian SET instansi = '$instansi_name', updated_by='$updated_by' WHERE id='$id_instansi'";
                if ($conn->multi_query($sqlUpdateInstansi) === TRUE) {
                    if ($_SESSION['role'] == "Superadmin") {
                        header('location:master_instansi.php');
                    }
                }

            } else if(isset($_GET['id_instansi'])){
                $id_instansi = $_GET['id_instansi'];
            }

            // $colName = array();
            // if (isset($_POST['numCol'])) {
            //     echo "*";
            //     $numCol = $_POST['numCol'];
            //     for ($indexCol = 0; $indexCol < $numCol; $indexCol++) {
            //         $key = "column" . $indexCol;
            
            //         array_push($colName, $_POST[$key]);
            //     }
            //     $numCol = $_POST['numCol'] + 1;
            // } else {
            //     $numCol = 1;
            // }
            // array_push($colName, "");
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button type="button" class="btn btn-dark" onclick="returnMasterInstansi()">Back</button>
                <form action='' method='post' id='returnMasterInstansiPage'>
                </form>
                <script>
                    function returnMasterInstansi() {
                        <?php
                        if ($_SESSION['role'] == "Superadmin") {
                            $linkKegiatan = "master_instansi.php";
                        } 
                        ?>
                        document.getElementById("returnMasterInstansiPage").action = "<?php echo $linkKegiatan; ?>";
                        document.getElementById("returnMasterInstansiPage").submit();
                    }
                </script>

                <h3>Update Instansi</h3>

                <?php 
                $sqlInstansi = "SELECT * FROM tb_master_kementrian WHERE id='$id_instansi'";
                $resultInstansi = $conn->query($sqlInstansi);
                if($resultInstansi->num_rows > 0){
                    while($rowInstansi = $resultInstansi->fetch_assoc()){
                        $instansi = $rowInstansi['instansi'];
                    }
                }
                ?>
                <div class="container">
                    <form id="updateMasterInstansi" action="./updateInstansi.php" method="post">
                        <input type="hidden" id="id_instansi" name="id_instansi" value="<?php echo $id_instansi; ?>" required>
                        <div class="row2">
                            <label for="instansi_name">Nama Instansi</label>
                            <input type="text" id="instansi_name" name="instansi_name" value="<?php echo $instansi; ?>" placeholder="nama instansi"
                                required>
                        </div>

                        <input type="submit" name="submit">
                    </form>

                </div>
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>