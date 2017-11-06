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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE data_foods SET food_name=%s, food_price=%s WHERE food_id=%s",
                       GetSQLValueString($_POST['food_name'], "text"),
                       GetSQLValueString($_POST['food_price'], "int"),
                       GetSQLValueString($_POST['food_id'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($updateSQL, $connect_restaurant) or die(mysql_error());

  $updateGoTo = "Admin_data_food.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_setUpdateFood = "-1";
if (isset($_GET['food_idup'])) {
  $colname_setUpdateFood = $_GET['food_idup'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setUpdateFood = sprintf("SELECT * FROM data_foods WHERE food_id = %s", GetSQLValueString($colname_setUpdateFood, "int"));
$setUpdateFood = mysql_query($query_setUpdateFood, $connect_restaurant) or die(mysql_error());
$row_setUpdateFood = mysql_fetch_assoc($setUpdateFood);
$totalRows_setUpdateFood = mysql_num_rows($setUpdateFood);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="90%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td align="center" valign="middle">&nbsp;
      <p>เเก้ไข </p>
      <p>&nbsp;</p>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
          <tr valign="baseline">
            <td align="left" valign="middle" nowrap="nowrap">รหัสอาหาร</td>
            <td align="center" valign="middle"><?php echo $row_setUpdateFood['food_id']; ?></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="middle" nowrap="nowrap">ชื่ออารหาร</td>
            <td valign="middle"><input type="text" name="food_name" value="<?php echo htmlentities($row_setUpdateFood['food_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="left" valign="middle" nowrap="nowrap">ราคา</td>
            <td valign="middle"><input type="text" name="food_price" value="<?php echo htmlentities($row_setUpdateFood['food_price'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
            <td valign="middle"><input type="submit" value="บันทึก" /></td>
          </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="food_id" value="<?php echo $row_setUpdateFood['food_id']; ?>" />
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($setUpdateFood);
?>
