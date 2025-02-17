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

            if (isset($_POST['submit'])) {
                $id_div = $_POST['id_div'];

                $nama = mysqli_real_escape_string($conn, $_POST['nama']);
                $posisi = mysqli_real_escape_string($conn, $_POST['posisi']);
                $hp = mysqli_real_escape_string($conn, $_POST['hp']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);

                $sqlSelectPenanggungJawab = "SELECT * FROM tb_master_penanggung_jawab WHERE id_div='$id_div'";
                $penanggungJawabNum = countNum($sqlSelectPenanggungJawab) + 1;

                $id = $id_div . "_PJ-" . $penanggungJawabNum;
                $sqlAddPenanggungJawab = "INSERT INTO tb_master_penanggung_jawab (id, id_div, nama, posisi, no_hp, email) VALUES ('$id', '$id_div', '$nama', '$posisi', '$hp', '$email')";
                if ($conn->multi_query($sqlAddPenanggungJawab) === TRUE) {
                    // please edit
                    echo "succeed";
                    $kegiatanInfo = parentFromId($id_div, "tb_kegiatan");
                    $penanggung_jawab_info = $kegiatanInfo['penanggung_jawab_info'];
                    if ($penanggung_jawab_info == "-") {
                        $penanggung_jawab_info = $id;
                    } else {
                        $penanggung_jawab_info = $penanggung_jawab_info . ", " . $id;
                    }

                    $sqlUpdateKegiatan = "UPDATE tb_kegiatan SET penanggung_jawab_info = '$penanggung_jawab_info' WHERE id='$id_div'";
                    if ($conn->query($sqlUpdateKegiatan) === TRUE) {
                        $link = "location:addPenanggungJawabKegiatan.php?id_div=$id_div";
                        header($link);
                    }
                }

            } else if (isset($_POST['id_div'])) {
                $id_div = $_POST['id_div'];
            } else if (isset($_GET['id_div'])) {
                $id_div = $_GET['id_div'];
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
                <?php $linkPenanggungJawab = "window.location.href='addPenanggungJawabKegiatan.php'"; ?>
                <button type="button" class="btn btn-dark" onclick="returnKegiatanTabel()">Back</button>
                <form action='' method='post' id='returnKegiatanTabelPage'>
                </form>
                <script>
                    function returnKegiatanTabel() {
                        <?php
                        if ($_SESSION['role'] == "Superadmin") {
                            $linkKegiatan = "kegiatanTabelSuperadmin.php";
                        } else if ($_SESSION['role'] == "Operator CMMAI") {
                            $linkKegiatan = "kegiatanTabelOperatorCMMAI.php";
                        } else if ($_SESSION['role'] == "Operator Ministry") {
                            $linkKegiatan = "kegiatanTabelOperatorMinistry.php";
                        }
                        ?>
                        document.getElementById("returnKegiatanTabelPage").action = "<?php echo $linkKegiatan; ?>";
                        document.getElementById("returnKegiatanTabelPage").submit();
                    }
                </script>

                <h3>Add Penanggung Jawab</h3>
                <?php
                $kegiatanInfo = parentFromId($id_div, "tb_kegiatan");
                $kegiatan = $kegiatanInfo['kegiatan'];

                echo "<h4>Kegiatan: $kegiatan</h4>";
                ?>


                <div class="container">
                    <?php
                    // $id_div = "";
                    $divName = "Kegiatan";
                    if ($divName == "Kegiatan") {
                        $sqlPenanggungJawab = "SELECT * FROM tb_master_penanggung_jawab WHERE id_div='$id_div' AND flag_active=1";
                    }

                    $resultPenanggungJawab = $conn->query($sqlPenanggungJawab);
                    if ($resultPenanggungJawab->num_rows > 0) {
                        echo "<ul>";
                        $indexPenanggungJawab = 1;
                        while ($rowPenanggungJawab = $resultPenanggungJawab->fetch_assoc()) {
                            $id_penanggung = $rowPenanggungJawab['id'];
                            $nama = $rowPenanggungJawab['nama'];
                            $posisi = $rowPenanggungJawab['posisi'];
                            $hp = $rowPenanggungJawab['no_hp'];
                            $email = $rowPenanggungJawab['email'];
                            echo "<li>Penanggung Jawab $indexPenanggungJawab <button onclick=\"deletePenanggung('$id_penanggung')\">Hapus</button></li>";
                            echo "  <ul style='list-style-type: none;'><b>Nama:</b> $nama</ul>";
                            echo "  <ul style='list-style-type: none;'><b>Posisi:</b> $posisi</ul>";
                            echo "  <ul style='list-style-type: none;'><b>No. HP:</b> $hp</ul>";
                            echo "  <ul style='list-style-type: none;'><b>Email:</b> $email</ul>";
                            $indexPenanggungJawab++;
                        }
                        echo "</ul>";

                        echo "<form id='deletePenanggung' action='delete_penanggung.php' method='post'>";
                        echo "  <input type='hidden' id='id_penanggung' name='id_penanggung' value=''>";
                        echo "  <input type='hidden' id='divName' name='divName' value='kegiatan'>";
                        echo "</form>";
                        echo "<script>";
                        echo "function deletePenanggung(id_penanggung){
                                    document.getElementById('id_penanggung').value = id_penanggung;
                                    document.getElementById('deletePenanggung').submit();
                                }";
                        echo "</script>";
                    }

                    ?>
                    <form id="addPenannggungJawab" action="./addPenanggungJawabKegiatan.php" method="post">
                        <input type="hidden" name="id_div" value="<?php echo $id_div; ?>"></input>
                        <div class="row2">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" placeholder="nama" required></input>
                        </div>
                        <div class="row2">
                            <label for="posisi">Posisi</label>
                            <input type="text" id="posisi" name="posisi" placeholder="posisi" required></input>
                        </div>
                        <div class="row2">
                            <label for="hp">No. Telp</label>
                            <input type="tel" id="hp" name="hp" value="" placeholder="No. hp">
                        </div>
                        <div class="row2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="email" required></input>
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