<?php
function idListTable($tableName, $parameter="")
{
  include "connection.php";
  $idList = array();
  $sqlIdList = "SELECT id FROM $tableName WHERE flag_active=1";
  if($parameter != ""){
    foreach($parameter as $key=>$value){
      $sqlIdList = $sqlIdList . " AND ". $key . "='" . $value . "'";
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
?>