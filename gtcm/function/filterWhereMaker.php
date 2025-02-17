<?php
function whereMaker($formType, array $filter){
    include('connection.php');
    if ($formType == "search") {
    } else {
        $where = "SELECT * FROM tb_program WHERE flag_active=1";
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
?>