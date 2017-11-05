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
$kon=(empty($_POST["kon"])?1:$_POST["kon"]);
$colname_setKon = "-1";
if (isset($_POST['kon'])) {
  $colname_setKon = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setKon = sprintf("SELECT food_name, order_amount, food_price FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setKon, "int"));
$setKon = mysql_query($query_setKon, $connect_restaurant) or die(mysql_error());
$row_setKon = mysql_fetch_assoc($setKon);
$totalRows_setKon = mysql_num_rows($setKon);

$colname_setTotal = "-1";
if (isset($_POST['kon'])) {
  $colname_setTotal = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setTotal = sprintf("SELECT SUM(order_amount*food_price) AS total FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setTotal, "int"));
$setTotal = mysql_query($query_setTotal, $connect_restaurant) or die(mysql_error());
$row_setTotal = mysql_fetch_assoc($setTotal);
$totalRows_setTotal = mysql_num_rows($setTotal);

$kid=(empty($_POST['kid'])?0:$_POST['kid']);
$kong=$kid-$row_setTotal['total'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <a href="http://localhost/ProjectFinal/Web/DEMOReport.php">LINK</a></p>
    <select name="kon" id="kon">
      <option value="1" <?php if (!(strcmp(1, $kon))) {echo "selected=\"selected\"";} ?>>1</option>
      <option value="2" <?php if (!(strcmp(2, $kon))) {echo "selected=\"selected\"";} ?>>2</option>
      <option value="3" <?php if (!(strcmp(3, $kon))) {echo "selected=\"selected\"";} ?>>3</option>
      <option value="4" <?php if (!(strcmp(4, $kon))) {echo "selected=\"selected\"";} ?>>4</option>
      <option value="5" <?php if (!(strcmp(5, $kon))) {echo "selected=\"selected\"";} ?>>5</option>
      <option value="6" <?php if (!(strcmp(6, $kon))) {echo "selected=\"selected\"";} ?>>6</option>
      <option value="7" <?php if (!(strcmp(7, $kon))) {echo "selected=\"selected\"";} ?>>7</option>
      <option value="8" <?php if (!(strcmp(8, $kon))) {echo "selected=\"selected\"";} ?>>8</option>
      <option value="9" <?php if (!(strcmp(9, $kon))) {echo "selected=\"selected\"";} ?>>9</option>
      <option value="10" <?php if (!(strcmp(10, $kon))) {echo "selected=\"selected\"";} ?>>10</option>
      <option value="11" <?php if (!(strcmp(11, $kon))) {echo "selected=\"selected\"";} ?>>11</option>
      <option value="12" <?php if (!(strcmp(12, $kon))) {echo "selected=\"selected\"";} ?>>12</option>
      <option value="13" <?php if (!(strcmp(13, $kon))) {echo "selected=\"selected\"";} ?>>13</option>
      <option value="14" <?php if (!(strcmp(14, $kon))) {echo "selected=\"selected\"";} ?>>14</option>
      <option value="15" <?php if (!(strcmp(15, $kon))) {echo "selected=\"selected\"";} ?>>15</option>
      <option value="16" <?php if (!(strcmp(16, $kon))) {echo "selected=\"selected\"";} ?>>16</option>
    </select>
  <button type="submit" name="submitkon" id="submitkon">ตกลง</button>
  <table border="1">
    <tr>
      <td>food_name</td>
      <td>order_amount</td>
      <td>food_price</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_setKon['food_name']; ?></td>
        <td><?php echo $row_setKon['order_amount']; ?></td>
        <td><?php echo $row_setKon['food_price']; ?></td>
      </tr>
      <?php } while ($row_setKon = mysql_fetch_assoc($setKon)); ?>
  </table>
  <p><?php echo $row_setTotal['total']; ?></p>
  <p>
    <label for="kid"></label>
    <input type="text" name="kid" id="kid" value="<?php echo($kid)?>" />
    <button type="submit" name="subkid" id="subkid">คำนวนเงิน</button> 
  </p>
  <p>
    <label for="kong"></label>
    <input type="text" name="kong" id="kong" value="<?php echo($kong)?>" />
  </p>
</form>
</body>
</html>
<?php
mysql_free_result($setKon);

mysql_free_result($setTotal);
?>
