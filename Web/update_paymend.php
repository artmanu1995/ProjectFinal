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

  $updateSQL = sprintf("UPDATE data_order SET sttPay_id=0 WHERE order_openTable=%s",
                        GetSQLValueString($_GET['order_openTable'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($updateSQL, $connect_restaurant) or die(mysql_error());

  $updateGoTo = "http://localhost/ProjectFinal/Web/Cashier_Report.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));

$colname_setOrderUpPay = "-1";
if (isset($_GET['order_openTable'])) {
  $colname_setOrderUpPay = $_GET['order_openTable'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setOrderUpPay = sprintf("SELECT * FROM data_order WHERE order_openTable = %s", GetSQLValueString($colname_setOrderUpPay, "int"));
$setOrderUpPay = mysql_query($query_setOrderUpPay, $connect_restaurant) or die(mysql_error());
$row_setOrderUpPay = mysql_fetch_assoc($setOrderUpPay);
$totalRows_setOrderUpPay = mysql_num_rows($setOrderUpPay);

mysql_free_result($setOrderUpPay);
?>
