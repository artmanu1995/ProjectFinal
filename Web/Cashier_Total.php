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
$kon=$_REQUEST['kon']; 
$kid=$_GET['kid']; 
$kong=$_GET['kong'];

$colname_setReport = "-1";
if (isset($_GET['kon'])) {
  $colname_setReport = $_GET['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setReport = sprintf("SELECT food_name, order_amount, food_price FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setReport, "int"));
$setReport = mysql_query($query_setReport, $connect_restaurant) or die(mysql_error());
$row_setReport = mysql_fetch_assoc($setReport);
$totalRows_setReport = mysql_num_rows($setReport);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<body>
	<!-- onload="window.print(); window.close();" -->
	<center>
              <p><img src="img/logo.png" width="150" height="123" /></p>
      <div>
        โต๊ะ <?php echo ($kon) ?><p>
        <table border="1" align="center" cellspacing="0" id="table1" width="50%">
                  <tr>
                    <th width="49%" height="39" bgcolor="#ffffff"><strong>อาหาร</strong></th>
                    <th width="27%" bgcolor="#ffffff"><strong>จำนวน</strong></th> 
                    <th width="24%" bgcolor="#ffffff"><strong>ราคา</strong></th>
          </tr>
                  <tr>
                    <td height="26" align="left"><?php echo $row_setReport['food_name']; ?></td>
                    <td align="center"><?php echo $row_setReport['order_amount']; ?></td>
                    <td align="center"><?php echo $row_setReport['food_price']; ?></td>
                  </tr>
        </table><p>
      </div>
      <div>
        <table width="50%" border="0">
          <tr>
            <td width="49%" valign="middle">&nbsp;</td>
            <td width="22%" valign="middle"><strong>ยอดชำระ</strong></td>
            <td width="29%" align="center" valign="middle"><?php echo ($kon) ?></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><strong>เงินสด</strong></td>
            <td align="center" valign="middle"><?php echo ($kid) ?></td>
          </tr>
          <tr>
            <td valign="middle">&nbsp;</td>
            <td valign="middle"><strong>เงินทอน</strong></td>
            <td align="center" valign="middle"><?php echo ($kong) ?></td>
          </tr>
          </table>
          <table width="50%" border="0">
          <tr>
            <td width="14%">&nbsp;</td>
            <td width="43%">&nbsp;</td>
            <td width="43%" align="center"><p>ลงชื่อ.................................................</p>
              <p>(...............................................)</p>
            <p>ผู้รับชำระเงิน</p></td>
          </tr>
        </table>
        <p>&nbsp;</p>
        </p>
    </div>
	</center>
</body>
</html>
<?php
mysql_free_result($setReport);
?>
