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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO data_users (user_username, user_password, user_name, position_id) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['user_username'], "text"),
                       GetSQLValueString($_POST['user_password'], "text"),
                       GetSQLValueString($_POST['user_name'], "text"),
                       GetSQLValueString($_POST['position_id'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($insertSQL, $connect_restaurant) or die(mysql_error());

  $insertGoTo = "Admin_data_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setDataUser = "SELECT user_id, user_username, user_password, user_name, position_name FROM data_users INNER JOIN data_position ON data_users.position_id=data_position.position_id";
$setDataUser = mysql_query($query_setDataUser, $connect_restaurant) or die(mysql_error());
$row_setDataUser = mysql_fetch_assoc($setDataUser);
$totalRows_setDataUser = mysql_num_rows($setDataUser);

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
  <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            padding: 3px;
        }
        th{
          color: #ffffff;
        }
        tr:nth-child(even){background-color: #FCFCFC}
  </style>

</head>

<body>
<table width="30%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td align="center" valign="middle"><p>เพิ่ม
    </p>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table align="center">
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">Username</td>
          <td align="left" valign="middle"><input type="text" name="user_username" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">Password</td>
          <td align="left" valign="middle"><input type="text" name="user_password" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">ชื่อ-สกุล</td>
          <td align="left" valign="middle"><input type="text" name="user_name" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td align="left" valign="middle" nowrap="nowrap">ตำแหน่ง</td>
          <td align="left" valign="middle"><select name="position_id">
            <?php 
do {  
?>
            <option value="<?php echo $row_setPosition['position_id']?>" ><?php echo $row_setPosition['position_name']?></option>
            <?php
} while ($row_setPosition = mysql_fetch_assoc($setPosition));
?>
          </select></td>
        </tr>
        <tr> </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td align="left" valign="middle"><input type="submit" value="บันทึก" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
  </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="70%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td height="38" align="center" valign="middle" bgcolor="#CCCCCC">รหัสสมาชิก</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Username</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Password</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">ชื่อ-สกุล</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">ตำแหน่ง</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Option</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_setDataUser['user_id']; ?></td>
      <td valign="middle"><?php echo $row_setDataUser['user_username']; ?></td>
      <td valign="middle"><?php echo $row_setDataUser['user_password']; ?></td>
      <td valign="middle"><?php echo $row_setDataUser['user_name']; ?></td>
      <td valign="middle"><?php echo $row_setDataUser['position_name']; ?></td>
      <td valign="middle"><table width="100%" border="0">
        <tr>
          <td align="center" valign="middle"><a href="Admin_Delete_user.php?user_id=<?php echo $row_setDataUser['user_id']; ?>">ลบ</a></td>
          <td align="center" valign="middle"><a href="Admin_Update_user.php?user_idup=<?php echo $row_setDataUser['user_id']; ?>">แก้ไข</a></td>
        </tr>
      </table></td>
    </tr>
    <?php } while ($row_setDataUser = mysql_fetch_assoc($setDataUser)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($setDataUser);

mysql_free_result($setPosition);
?>
