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
            
                $role = mysqli_real_escape_string($conn, $_POST['role']);
                $id_instansi = mysqli_real_escape_string($conn, $_POST['instansi_terkait']);
                if ($role == "SP") {
                    $roleName = "Superadmin";
                } else if ($role == "OPC") {
                    $roleName = "Operator CMMAI";
                } else if ($role == "OPR") {
                    $roleName = "Operator Ministry";
                } else if ($role == "OBC") {
                    $roleName = "Observer CMMAI";
                } else if ($role == "OBR") {
                    $roleName = "Observer Ministry";
                }



                $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
                $hp = filter_var($_POST['hp'], FILTER_SANITIZE_NUMBER_INT);
                $hp = preg_replace("/[^0-9]/", "", $hp); // remove all non-numeric characters
                if (!preg_match("/^\d{10}$/", $hp)) { // check if the input matches the expected format
                    // handle invalid input
                }

                $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

                $created_by = $_SESSION['name'];

                $picRole = "SELECT * FROM tb_master_pic where role='$role' AND id_kementrian='$id_instansi'";
                # note that it is not ==, but '=' (assign value to result and check the value of result)
                if ($result = $conn->query($picRole)) {
                    // Return the number of rows in result set
                    $picRoleCount = mysqli_num_rows($result) + 1;
                }
                $id_pic = $id_instansi . "_" . $role . "-" . $picRoleCount;

                $sql = "INSERT INTO tb_master_pic (id, id_kementrian, nama_pic, hp_pic, email, password, role, created_by)
                VALUES ('$id_pic', '$id_instansi', '$name', '$hp', '$email', '$password', '$roleName', '$created_by')";

                if ($conn->multi_query($sql) === TRUE) {
                    echo "New records created successfully";
                    header("Location:manageUserSuperadmin.php");
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
            ?>
        </div>
        <?php include "headerNavigation.php"; ?>
        <div id="main">
            <?php menu();?>

            <div id="right">
                <h2>Add User</h2>
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
                    <form action="./addUserSuperadmin.php" method="post">
                        <div class="row2">
                            <label for="role">Role</label>
                            <select id="role" name="role" required>
                                <option value="" selected disabled hidden>Pilih Role</option>
                                <option value="SP">Superadmin</option>
                                <option value="OPC">Operator CMMAI</option>
                                <option value="OPR">Operator Ministry</option>
                                <option value="OBC">Observer CMMAI</option>
                                <option value="OBR">Observer Ministry</option>
                            </select>
                        </div>
                        <div class="row2">
                            <label for="instansi_terkait">Instansi</label>
                            <select id="instansi_terkait" name="instansi_terkait" required>
                                <option value="" selected disabled hidden>Pilih Instansi</option>
                                <?php
                                $sqlInstansi = "SELECT * FROM tb_master_kementrian WHERE flag_active=1";
                                $resultInstansi = $conn->query($sqlInstansi);
                                if ($resultInstansi->num_rows > 0) {
                                    while ($rowInstansi = $resultInstansi->fetch_assoc()) {
                                        $instansi = $rowInstansi['instansi'];
                                        $id_instansi = $rowInstansi['id'];
                                        echo "<option value='$id_instansi'>$instansi</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row2">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" maxlength="100" placeholder="nama" required>
                        </div>

                        <div class="row2">
                            <label for="hp">No. Telp</label>
                            <input type="tel" id="hp" name="hp" pattern="[0-9]{1,20}" required>
                        </div>

                        <div class="row2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="row2">
                            <label for="password">Password</label>
                            <input type="text" id="password" name="password" required>
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