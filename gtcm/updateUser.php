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
                // $ministry_role = filter_var($_POST['role'], FILTER_SANITIZE_STRING);
                // $ministry_role = explode("-", $ministry_role);
                // $id_kementrian = $ministry_role[1];
                // if ($ministry_role[0] == "SP") {
                //     $role = "Superadmin";
                // } else if ($ministry_role[0] == "OP" && $ministry_role[1] == "CMMAI") {
                //     $role = "Operator CMMAI";
                // } else if ($ministry_role[0] == "OP") {
                //     $role = "Operator Ministry";
                // } else if ($ministry_role[0] == "OB" && $ministry_role[1] == "CMMAI") {
                //     $role = "Observer CMMAI";
                // } else if ($ministry_role[0] == "OB") {
                //     $role = "Observer Ministry";
                // }
            
                $id_pic = mysqli_real_escape_string($conn, $_POST['id_pic']);

                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $hp = filter_var($_POST['hp'], FILTER_SANITIZE_NUMBER_INT);
                $hp = preg_replace("/[^0-9]/", "", $hp); // remove all non-numeric characters
                if (!preg_match("/^\d{10}$/", $hp)) { // check if the input matches the expected format
                    // handle invalid input
                }

                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

                $updated_by = mysqli_real_escape_string($conn, $_SESSION['name']);

                $sql = "UPDATE tb_master_pic  SET nama_pic='$name', hp_pic='$hp', email='$email', updated_by='$updated_by' WHERE id='$id_pic'";

                if ($conn->multi_query($sql) === TRUE) {
                    echo "New records updated successfully";
                    header("Location:manageUserSuperadmin.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else if (isset($_GET['id_pic'])) {
                $id_pic = mysqli_real_escape_string($conn, $_GET['id_pic']);
                $sqlPIC = "SELECT * FROM tb_master_pic WHERE id='$id_pic'";
                $resultPIC = $conn->query($sqlPIC);
                if($resultPIC->num_rows >0){
                    while($rowPIC = $resultPIC->fetch_assoc()){
                        $id_instansi = $rowPIC['id_kementrian'];
                        $idRole = explode("_", $rowPIC['id'])[1];
                        $role = explode("-", $idRole)[0];
                        $nama = $rowPIC['nama_pic'];
                        $hp = $rowPIC['hp_pic'];
                        $email = $rowPIC['email'];
                    }
                }
            }
            ?>
        </div>
        <?php include "headerNavigation.php"; ?>
        <div id="main">
            <?php menu();?>
            <div id="right">
                <h2>Update User</h2>
                <button type="button" class="btn btn-dark" onclick="backUserPage()">Back</button>
                <form id="backUserPage" method="get" action="">
                    <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
                </form>
                <script>
                    function backUserPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backUserPage").action = "manageUserSuperadmin.php"; }

                        // document.getElementById("myIdProgramPage").value = "<?php //echo $_SESSION['id_program']; ?>";

                        document.getElementById("backUserPage").submit();
                    }
                </script>

                <div class="container">
                    <?php 
                    echo "<p>Role: $role</p>";
                    $instansiInfo = parentFromId($id_instansi, "tb_master_kementrian");
                    $instansi = $instansiInfo['instansi'];
                    echo "<p>Instansi: $instansi</p>";
                    ?>
                    
                    <form action="./updateUser.php" method="post">
                        <input type="hidden" id="id_pic" name="id_pic" value="<?php echo $id_pic; ?>" required>
                        <div class="row2">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" maxlength="100" placeholder="nama" value="<?php echo $nama;?>" required>
                        </div>

                        <div class="row2">
                            <label for="hp">No. Telp</label>
                            <input type="tel" id="hp" name="hp" pattern="[0-9]{1,20}" value="<?php echo $hp; ?>" required>
                        </div>

                        <div class="row2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $email;?>" required>
                        </div>

                        <div class="row2">
                            <input type="submit" name="submit" value="Submit">
                        </div>

                    </form>
                </div>
            </div>

            <?php $conn->close(); ?>
        </div>
    </div>
</body>

</html>