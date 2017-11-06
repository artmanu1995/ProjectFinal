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
  $updateSQL = sprintf("UPDATE data_users SET user_username=%s, user_password=%s, user_name=%s, position_id=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['user_username'], "text"),
                       GetSQLValueString($_POST['user_password'], "text"),
                       GetSQLValueString($_POST['user_name'], "text"),
                       GetSQLValueString($_POST['position_id'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($updateSQL, $connect_restaurant) or die(mysql_error());

  $updateGoTo = "Admin_data_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_setUpdateUser = "-1";
if (isset($_GET['user_idup'])) {
  $colname_setUpdateUser = $_GET['user_idup'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setUpdateUser = sprintf("SELECT * FROM data_users WHERE user_id = %s", GetSQLValueString($colname_setUpdateUser, "int"));
$setUpdateUser = mysql_query($query_setUpdateUser, $connect_restaurant) or die(mysql_error());
$row_setUpdateUser = mysql_fetch_assoc($setUpdateUser);
$totalRows_setUpdateUser = mysql_num_rows($setUpdateUser);

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setPosition = "SELECT * FROM data_position";
$setPosition = mysql_query($query_setPosition, $connect_restaurant) or die(mysql_error());
$row_setPosition = mysql_fetch_assoc($setPosition);
$totalRows_setPosition = mysql_num_rows($setPosition);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="70%" border="1" align="center" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><p>แก้ไข</p>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">รหัสสมาชิก</td>
          <td valign="middle"><?php echo $row_setUpdateUser['user_id']; ?></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">Username</td>
          <td valign="middle"><input type="text" name="user_username" value="<?php echo htmlentities($row_setUpdateUser['user_username'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">Password</td>
          <td valign="middle"><input type="text" name="user_password" value="<?php echo htmlentities($row_setUpdateUser['user_password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">ชื่อ - สกุล</td>
          <td valign="middle"><input type="text" name="user_name" value="<?php echo htmlentities($row_setUpdateUser['user_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">ตำแหน่ง</td>
          <td valign="middle"><select name="position_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_setPosition['position_id']?>" <?php if (!(strcmp($row_setPosition['position_id'], htmlentities($row_setUpdateUser['position_id'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_setPosition['position_name']?></option>
            <?php
} while ($row_setPosition = mysql_fetch_assoc($setPosition));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
          <td valign="middle"><input type="submit" value="บันทึก" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="user_id" value="<?php echo $row_setUpdateUser['user_id']; ?>" />
    </form>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($setUpdateUser);

mysql_free_result($setPosition);
?>
