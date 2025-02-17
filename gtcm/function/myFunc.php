<?php
function menu($value = "")
{
    $role = $_SESSION['role'];
    // Superadmin, Operator CMMAI, Operator Ministry, Observer CMMAI, Observer Ministry
    if ($role == "Superadmin") {
        ?>
        <div class='row'>
            <span style='font-size:25px;cursor:pointer;margin:10px;' onclick='openNav()'>&#9776; Menu</span>
            <div id='myNav' class='overlay' style='display: none'>
                <a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
                <div class='overlay-content'>
                    <a id='dashboard' href='superadminMainCMMAI.php' style='font-size: 20px;'>Dashboard</a>
                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    <a id='daftar_cluster' href='master_clusterSuperadmin.php' style='font-size: 20px;'>Daftar Cluster</a>
                    <a id='daftar_program' href='programTabelSuperadmin.php' style='font-size: 20px;' class='mx-2'>Daftar
                        Program</a>
                    <a id='daftar_indikator' href='indikatorTabelSuperadmin.php' style='font-size: 20px' class='mx-4'>Daftar
                        Indikator</a>
                    <a id='daftar_kegiatan' href='kegiatanTabelSuperadmin.php' style='font-size: 20px' class='mx-5'>Daftar
                        Kegiatan</a>
                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    <a id='problem' href='problemTabelSuperadmin.php' style='font-size: 20px'>Problem</a>
                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    <a id='lewat_deadline' href='lateTabelSuperadmin.php' style='font-size: 20px'>Lewat Deadline</a>
                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    <a id='master_instansi' href='master_instansi.php' style='font-size: 20px'>Master Instansi</a>
                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    <a id='master_user' href='manageUserSuperadmin.php' style='font-size: 20px'>Master User</a>
                    <hr style='border-top: 1px solid #cccccc;margin:0;'>

                    <a id='master_status_kegiatan' href='statusTabel.php' style='font-size: 20px'>Master Status Kegiatan</a>
                    <hr style='border-top: 1px solid #cccccc;margin:0;'>
                </div>
            </div>
            <script>
                function openNav() {
                    // document.getElementById('myNav').style.width = '300px';
                    document.getElementById('myNav').style.display = 'block';
                    // document.getElementById('main-grid').style.marginLeft='300px';

                }
                function closeNav() {
                    // document.getElementById('myNav').style.width = '0%';
                    document.getElementById('myNav').style.display = 'none';
                    // document.getElementById('main-grid').style.marginLeft='0';
                }

                value = '<?php echo $value ?>';
                if (value != '') {
                    document.getElementById(value).style.color = "#ffff00";
                }
            </script>
        </div>
        <?php
    } else if ($role == "Observer CMMAI") {
        ?>
            <div class='row'>
                <span style='font-size:25px;cursor:pointer;margin:20px;' onclick='openNav()'>&#9776; Menu</span>
                <div id='myNav' class='overlay' style='display: none'>
                    <a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
                    <div class='overlay-content'>
                        <a id='dashboard' href='dashboardMainCMMAI.php' style='font-size: 20px;'>Dashboard</a>
                        <hr style='border-top: 1px solid #cccccc; margin:0;'>

                        <a id='daftar_cluster' href='master_clusterObserverCMMAI.php' style='font-size: 20px;'>Daftar Cluster</a>
                        <a id='daftar_program' href='programObserverCMMAI.php' style='font-size: 20px;' class='mx-2'>Daftar
                            Program</a>
                        <a id='daftar_indikator' href='indikatorObserverCMMAI.php' style='font-size: 20px' class='mx-4'>Daftar
                            Indikator</a>
                        <a id='daftar_kegiatan' href='kegiatanObserverCMMAI.php' style='font-size: 20px' class='mx-5'>Daftar
                            Kegiatan</a>
                        <hr style='border-top: 1px solid #cccccc; margin:0;'>

                        <a id='problem' href='problemObserverCMMAI.php' style='font-size: 20px'>Problem</a>
                        <hr style='border-top: 1px solid #cccccc; margin:0;'>

                        <a id='lewat_deadline' href='lateObserverCMMAI.php' style='font-size: 20px'>Lewat Deadline</a>
                        <hr style='border-top: 1px solid #cccccc; margin:0;'>

                    </div>
                </div>
                <script>
                    function openNav() {
                        // document.getElementById('myNav').style.width = '300px';
                        document.getElementById('myNav').style.display = 'block';
                        // document.getElementById('main-grid').style.marginLeft='300px';

                    }
                    function closeNav() {
                        // document.getElementById('myNav').style.width = '0%';
                        document.getElementById('myNav').style.display = 'none';
                        // document.getElementById('main-grid').style.marginLeft='0';
                    }

                    value = '<?php echo $value ?>';
                    if (value != '') {
                        document.getElementById(value).style.color = "#ffff00";
                    }
                </script>
            </div>
        <?php
    } else if ($role == "Operator CMMAI") {
        ?>
                <div class='row'>
                    <span style='font-size:25px;cursor:pointer;margin:20px;' onclick='openNav()'>&#9776; Menu</span>
                    <div id='myNav' class='overlay' style='display: none'>
                        <a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
                        <div class='overlay-content'>
                            <a id='dashboard' href='operatorMainCMMAI.php' style='font-size: 20px;'>Dashboard</a>
                            <hr style='border-top: 1px solid #cccccc; margin:0;'>

                            <a id='daftar_cluster' href='master_clusterOperatorCMMAI.php' style='font-size: 20px;'>Daftar Cluster</a>
                            <a id='daftar_program' href='programTabelOperatorCMMAI.php' style='font-size: 20px;' class='mx-2'>Daftar
                                Program</a>
                            <a id='daftar_indikator' href='indikatorTabelOperatorCMMAI.php' style='font-size: 20px' class='mx-4'>Daftar
                                Indikator</a>
                            <a id='daftar_kegiatan' href='kegiatanTabelOperatorCMMAI.php' style='font-size: 20px' class='mx-5'>Daftar
                                Kegiatan</a>
                            <hr style='border-top: 1px solid #cccccc; margin:0;'>

                            <a id='problem' href='problemTabelOperatorCMMAI.php' style='font-size: 20px'>Problem</a>
                            <hr style='border-top: 1px solid #cccccc; margin:0;'>

                            <a id='lewat_deadline' href='lateTabelOperatorCMMAI.php' style='font-size: 20px'>Lewat Deadline</a>
                            <hr style='border-top: 1px solid #cccccc; margin:0;'>

                        </div>
                    </div>
                    <script>
                        function openNav() {
                            // document.getElementById('myNav').style.width = '300px';
                            document.getElementById('myNav').style.display = 'block';
                            // document.getElementById('main-grid').style.marginLeft='300px';

                        }
                        function closeNav() {
                            // document.getElementById('myNav').style.width = '0%';
                            document.getElementById('myNav').style.display = 'none';
                            // document.getElementById('main-grid').style.marginLeft='0';
                        }

                        value = '<?php echo $value ?>';
                        if (value != '') {
                            document.getElementById(value).style.color = "#ffff00";
                        }
                    </script>
                </div>
        <?php
    } else if ($role == "Operator Ministry") {
        ?>
                    <div class='row'>
                        <span style='font-size:25px;cursor:pointer;margin:20px;' onclick='openNav()'>&#9776; Menu</span>
                        <div id='myNav' class='overlay' style='display: none'>
                            <a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
                            <div class='overlay-content'>
                                <a id='dashboard' href='operator_ministryMain.php' style='font-size: 20px;'>Dashboard</a>
                                <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                <a id='daftar_cluster' href='master_clusterOperatorMinistry.php' style='font-size: 20px;'>Daftar Cluster</a>
                                <a id='daftar_program' href='programTabelOperatorMinistry.php' style='font-size: 20px;' class='mx-2'>Daftar
                                    Program</a>
                                <a id='daftar_indikator' href='indikatorTabelOperatorMinistry.php' style='font-size: 20px'
                                    class='mx-4'>Daftar
                                    Indikator</a>
                                <a id='daftar_kegiatan' href='kegiatanTabelOperatorMinistry.php' style='font-size: 20px' class='mx-5'>Daftar
                                    Kegiatan</a>
                                <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                <a id='problem' href='problemTabelOperatorMinistry.php' style='font-size: 20px'>Problem</a>
                                <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                <a id='lewat_deadline' href='lateTabelOperatorMinistry.php' style='font-size: 20px'>Lewat Deadline</a>
                                <hr style='border-top: 1px solid #cccccc; margin:0;'>

                            </div>
                        </div>
                        <script>
                            function openNav() {
                                // document.getElementById('myNav').style.width = '300px';
                                document.getElementById('myNav').style.display = 'block';
                                // document.getElementById('main-grid').style.marginLeft='300px';

                            }
                            function closeNav() {
                                // document.getElementById('myNav').style.width = '0%';
                                document.getElementById('myNav').style.display = 'none';
                                // document.getElementById('main-grid').style.marginLeft='0';
                            }

                            value = '<?php echo $value ?>';
                            if (value != '') {
                                document.getElementById(value).style.color = "#ffff00";
                            }
                        </script>
                    </div>
        <?php
    } else if ($role == "Observer Ministry") {
        ?>
                        <div class='row'>
                            <span style='font-size:25px;cursor:pointer;margin:20px;' onclick='openNav()'>&#9776; Menu</span>
                            <div id='myNav' class='overlay' style='display: none'>
                                <a href='javascript:void(0)' class='closebtn' onclick='closeNav()'>&times;</a>
                                <div class='overlay-content'>
                                    <a id='dashboard' href='dashboardMainMinistry.php' style='font-size: 20px;'>Dashboard</a>
                                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                    <a id='daftar_cluster' href='master_clusterObserverMinistry.php' style='font-size: 20px;'>Daftar Cluster</a>
                                    <a id='daftar_program' href='programTabelObserverMinistry.php' style='font-size: 20px;' class='mx-2'>Daftar
                                        Program</a>
                                    <a id='daftar_indikator' href='indikatorTabelObserverMinistry.php' style='font-size: 20px'
                                        class='mx-4'>Daftar
                                        Indikator</a>
                                    <a id='daftar_kegiatan' href='kegiatanTabelObserverMinistry.php' style='font-size: 20px' class='mx-5'>Daftar
                                        Kegiatan</a>
                                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                    <a id='problem' href='problemTabelObserverMinistry.php' style='font-size: 20px'>Problem</a>
                                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                    <a id='lewat_deadline' href='lateTabelObserverMinistry.php' style='font-size: 20px'>Lewat Deadline</a>
                                    <hr style='border-top: 1px solid #cccccc; margin:0;'>

                                </div>
                            </div>
                            <script>
                                function openNav() {
                                    // document.getElementById('myNav').style.width = '300px';
                                    document.getElementById('myNav').style.display = 'block';
                                    // document.getElementById('main-grid').style.marginLeft='300px';

                                }
                                function closeNav() {
                                    // document.getElementById('myNav').style.width = '0%';
                                    document.getElementById('myNav').style.display = 'none';
                                    // document.getElementById('main-grid').style.marginLeft='0';
                                }

                                value = '<?php echo $value ?>';
                                if (value != '') {
                                    document.getElementById(value).style.color = "#ffff00";
                                }
                            </script>
                        </div>
        <?php
    }
}
function problem($problemArray)
{
    include "connection.php";
    if (sizeof($problemArray) > 0) {
        echo "<ol>";
        foreach ($problemArray as $problem) {
            echo "<li>$problem</li>";
        }
        echo "</ol>";
    } else {
        echo "0 problem";
    }
}
function penanggungJawab($idArrayPenanggungJawab)
{
    include "connection.php";
    if (sizeof($idArrayPenanggungJawab) > 0) {
        $countPenanggungJawab = sizeof($idArrayPenanggungJawab);

        $namaPenanggungArray = array();
        $posisiPenanggungArray = array();
        $hpPenanggungArray = array();
        $emailPenanggungArray = array();
        for ($indexPenanggung = 0; $indexPenanggung < $countPenanggungJawab; $indexPenanggung++) {
            $idPenanggung = $idArrayPenanggungJawab[$indexPenanggung];
            $sqlPenanggung = "SELECT * FROM tb_master_penanggung_jawab WHERE id='$idPenanggung'";
            $resultPenanggung = $conn->query($sqlPenanggung);
            if ($resultPenanggung->num_rows > 0) {
                $penanggungInfo = $resultPenanggung->fetch_assoc();

                array_push($namaPenanggungArray, $penanggungInfo['nama']);
                array_push($posisiPenanggungArray, $penanggungInfo['posisi']);
                array_push($hpPenanggungArray, $penanggungInfo['no_hp']);
                array_push($emailPenanggungArray, $penanggungInfo['email']);
            }

        }

        // nama
        echo "<td>";
        echo "<div>";
        for ($indexPenanggung = 0; $indexPenanggung < $countPenanggungJawab; $indexPenanggung++) {
            echo "<p style='border-bottom: 1px solid black;'>$namaPenanggungArray[$indexPenanggung]</p>";
        }
        echo "</div>";
        echo "</td>";

        // posisi
        echo "<td>";
        echo "<div>";
        for ($indexPenanggung = 0; $indexPenanggung < $countPenanggungJawab; $indexPenanggung++) {
            echo "<p style='border-bottom: 1px solid black;'>$posisiPenanggungArray[$indexPenanggung]</p>";
        }
        echo "</div>";
        echo "</td>";

        // hp
        echo "<td>";
        echo "<div>";
        for ($indexPenanggung = 0; $indexPenanggung < $countPenanggungJawab; $indexPenanggung++) {
            echo "<p style='border-bottom: 1px solid black;'>$hpPenanggungArray[$indexPenanggung]</p>";
        }
        echo "</div>";
        echo "</td>";

        // email
        echo "<td>";
        echo "<div>";
        for ($indexPenanggung = 0; $indexPenanggung < $countPenanggungJawab; $indexPenanggung++) {
            echo "<p style='border-bottom: 1px solid black;'>$emailPenanggungArray[$indexPenanggung]</p>";
        }
        echo "</div>";
        echo "</td>";
    } else {
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
        echo "<td>-</td>";
    }
}
function convertSqlColName($string)
{
    $cetakColName = str_replace("__", ",", $string);
    $cetakColName = str_replace("_", " ", $cetakColName);
    $cetakColName = strtoupper($cetakColName);
    return $cetakColName;
}
function countNum($sql)
{
    include('connection.php');
    # note that it is not ==, but '=' (assign value to result and check the value of result)
    if ($result = $conn->query($sql)) {
        // Return the number of rows in result set
        $sqlCount = mysqli_num_rows($result);
    }
    return $sqlCount;
}
function whereMaker($formType, array $filter, $tbName)
{
    include('connection.php');
    if ($formType == "search") {
    } else {
        $where = "SELECT * FROM $tbName WHERE flag_active=1";
        foreach ($filter as $type => $val) {
            if ($filter[$type] != "allCluster" && $filter[$type] != "allMinistry" && $filter[$type] != "allStatus" && $filter[$type] != "2019-2024") {
                if ($type == "tahun_selesai") {
                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                        if ($bulan == 1) {
                            $where = $where . " AND " . $type . " IN ('" . $val . "-01-01'";
                        } else if ($bulan < 10) {
                            $where = $where . ", '" . $val . "-0" . $bulan . "-01'";
                        } else {
                            $where = $where . ", '" . $val . "-" . $bulan . "-01'";
                        }
                    }
                    $where = $where . ") ";
                } else {
                    $where = $where . " AND " . $type . "= '" . $val . "'";

                }
            }
        }
    }

    return $where;
}
function idListTable($tableName, $parameter = "")
{
    include "connection.php";
    $idList = array();
    $sqlIdList = "SELECT id FROM $tableName WHERE flag_active=1";
    if ($parameter != "") {
        foreach ($parameter as $key => $value) {
            if ($key == "pic") {
                $key = "instansi_terkait";
            }
            $sqlIdList = $sqlIdList . " AND " . $key . "='" . $value . "'";
        }
    }
    $result = $conn->query($sqlIdList);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            array_push($idList, $row['id']);
        }
    }

    return $idList;
}
function parentFromId($id, $tableName)
{
    include('connection.php');
    $sql = "SELECT * FROM $tableName WHERE id='$id' ORDER BY updated_at ASC";
    //echo $sql . "*<br>";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

}
function colNameType($id_cluster)
{
    include "connection.php";
    $sqlColName = "SELECT colName1,type1 FROM tb_colname_program WHERE id_cluster='$id_cluster'";
    $arrayColTb = parentFromId($id_cluster, "tb_colname_program");

    $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
    $arrayColName = explode(",", $arrayColName);
    print_r($arrayColName);

    $arrayColType = str_replace("'", "", $arrayColTb['type1']);
    $arrayColType = explode(", ", $arrayColType);
    print_r($arrayColType);
}

function dateToText($date)
{
    $End = explode("-", $date);
    if (isset($End[1])) {
        $month = $End[1];
        switch ($month) {
            case 1:
                $month = "Januari";
                break;
            case 2:
                $month = "Februari";
                break;
            case 3:
                $month = "Maret";
                break;
            case 4:
                $month = "April";
                break;
            case 5:
                $month = "Mei";
                break;
            case 6:
                $month = "Juni";
                break;
            case 7:
                $month = "Juli";
                break;
            case 8:
                $month = "Agustus";
                break;
            case 9:
                $month = "September";
                break;
            case 10:
                $month = "Oktober";
                break;
            case 11:
                $month = "November";
                break;
            case 12:
                $month = "Desember";
                break;
            default:
                $month = "Invalid Month";
        }
        $dateEndNew = $End[2] . " " . $month . " " . $End[0];
    } else {
        $dateEndNew = "-";
    }
    return $dateEndNew;
}
function programFilterClusterInstansi($id_cluster, array $arrayInstansi)
{
    include "connection.php";
    $idProgramFilter_array = array();
    $idClusterArray = array();
    if ($id_cluster == "allCluster") {
        $idClusterArray = idListTable("tb_cluster");
    } else {
        $idClusterArray[] = $id_cluster;
    }

    // foreach ($idClusterArray as $id_cluster) {
    //     $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
    //     if ($arrayInstansi[0] != "allInstansi") {
    //         $indexInstansi = 0;
    //         foreach ($arrayInstansi as $id_instansi) {
    //             $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";

    //             $sqlProgramRecent = $sqlProgramRecent . " AND instansi_terkait = '$id_instansi'";

    //             $resultProgramRecent = $conn->query($sqlProgramRecent);
    //             if ($resultProgramRecent->num_rows > 0) {
    //                 while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
    //                     array_push($idProgramFilter_array, $rowProgramRecent['id']);
    //                 }
    //             }
    //             $indexInstansi++;
    //         }
    //     } else {
    //         $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
    //         $resultProgramRecent = $conn->query($sqlProgramRecent);
    //         if ($resultProgramRecent->num_rows > 0) {
    //             while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
    //                 array_push($idProgramFilter_array, $rowProgramRecent['id']);
    //             }
    //         }

    //     }


    // }
    foreach ($idClusterArray as $id_cluster) {
        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
        $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
        if ($arrayInstansi[0] != "allInstansi") {
            $indexInstansi = 0;
            foreach ($arrayInstansi as $id_instansi) {
                if ($indexInstansi == 0) {
                    $sqlProgramRecent = $sqlProgramRecent . " AND (instansi_terkait LIKE '%" . $id_instansi . ",%'";
                } else {
                    $sqlProgramRecent = $sqlProgramRecent . " OR instansi_terkait LIKE '%" . $id_instansi . ",%'";
                }
                $indexInstansi++;
            }
            $sqlProgramRecent = $sqlProgramRecent . ")";
        }

        $resultProgramRecent = $conn->query($sqlProgramRecent);
        if ($resultProgramRecent->num_rows > 0) {

            while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
                array_push($idProgramFilter_array, $rowProgramRecent['id']);
            }
        }
    }

    return $idProgramFilter_array;
}
function filterProgram($id_cluster = "allCluster", $arrayInstansi = array("allInstansi"), $id_program = "allProgram")
{
    include "connection.php";

    $idProgramFilter_array = array();
    $idClusterArray = array();
    if ($id_cluster == "allCluster") {
        $idClusterArray = idListTable("tb_cluster");
    } else {
        $idClusterArray[] = $id_cluster;
    }
    foreach ($idClusterArray as $id_cluster) {
        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
        $sqlProgramRecent = "SELECT * FROM tb_program_$id_clusterEdited WHERE flag_active=1";
        if ($arrayInstansi[0] != "allInstansi") {
            $indexInstansi = 0;
            foreach ($arrayInstansi as $id_instansi) {
                if ($indexInstansi == 0) {
                    $sqlProgramRecent = $sqlProgramRecent . " AND (instansi_terkait LIKE '%" . $id_instansi . "%'";
                } else {
                    $sqlProgramRecent = $sqlProgramRecent . " OR instansi_terkait LIKE '%" . $id_instansi . "%'";
                }
                $indexInstansi++;
            }
            $sqlProgramRecent = $sqlProgramRecent . ")";
        }
        $resultProgramRecent = $conn->query($sqlProgramRecent);
        if ($resultProgramRecent->num_rows > 0) {
            while ($rowProgramRecent = $resultProgramRecent->fetch_assoc()) {
                array_push($idProgramFilter_array, $rowProgramRecent['id']);
            }
        }
    }


}
//xparentFromId('CL-1', 'tb_cluster');
?>