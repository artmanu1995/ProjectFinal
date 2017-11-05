<?php require_once('Connections/connect_restaurant.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_setReport = "-1";
if (isset($_POST['treport'])) {
  $colname_setReport = $_POST['treport'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setReport = sprintf("SELECT food_name, order_amount, food_price FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setReport, "int"));
$setReport = mysql_query($query_setReport, $connect_restaurant) or die(mysql_error());
$row_setReport = mysql_fetch_assoc($setReport);
$totalRows_setReport = mysql_num_rows($setReport);

$colname_setTotal = "-1";
if (isset($_POST['treport'])) {
  $colname_setTotal = $_POST['treport'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setTotal = sprintf("SELECT SUM(order_amount*food_price) AS total FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setTotal, "int"));
$setTotal = mysql_query($query_setTotal, $connect_restaurant) or die(mysql_error());
$row_setTotal = mysql_fetch_assoc($setTotal);
$totalRows_setTotal = mysql_num_rows($setTotal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
    <style>
              table, th, td {
                  border: 1px solid black;
                  border-collapse: collapse;
              }
              th {
                  padding: 15px;
              }
              td {
                  padding: 10px;
              }
    </style>
</head>

<body>
<table width="35%" border="0" align="center">
  <tr>
    <td align="right"><center>
	  <p><img src="img/restaurant.png" alt="Mountain View" width="70" height="70"></p>
       <h5>ระบบสั่งอาหารในร้านอาหาร</h5>
	     <h5>A Food Ordering System in the Restaurant</h5>
	</center><br>
      <table align="center" id="table1" style="width:100%">
          <tr>
            <th bgcolor="#F9F9F9">อาหาร</th>
            <th bgcolor="#F9F9F9">จำนวน</th> 
            <th bgcolor="#F9F9F9">ราคา</th>
          </tr>
          <tr>
            <td align="left"><?php echo $row_setReport['food_name']; ?></td>
            <td align="center"><?php echo $row_setReport['order_amount']; ?></td>
            <td align="center"><?php echo $row_setReport['food_price']; ?></td>
          </tr>
      </table>
     <p>ยอดรวม <?php echo $row_setTotal['total']; ?></p>
     <p>เงินสด</p>
     <p>เงินทอน</p>
     <br><table width="200" border="0" align="right">
       <tr>
         <td align="center"><p>ลงชื่อ......................................................</p>
          <p>(....................................................)</p>
          <p>ผู้รับชำระเงิน</p></td>
       </tr>
     </table></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($setReport);

mysql_free_result($setTotal);
?>
