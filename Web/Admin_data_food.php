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
  $insertSQL = sprintf("INSERT INTO data_foods (food_name, food_price) VALUES (%s, %s)",
                       GetSQLValueString($_POST['food_name'], "text"),
                       GetSQLValueString($_POST['food_price'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($insertSQL, $connect_restaurant) or die(mysql_error());

  $insertGoTo = "Admin_data_food.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setDataFood = "SELECT * FROM data_foods";
$setDataFood = mysql_query($query_setDataFood, $connect_restaurant) or die(mysql_error());
$row_setDataFood = mysql_fetch_assoc($setDataFood);
$totalRows_setDataFood = mysql_num_rows($setDataFood);
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
        tr:nth-child(even){background-color: #FCFCFC}
  </style>
</head>

<body>
<table width="30%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td align="center"><p>เพิ่ม</p>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table border="0" align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">ชื่ออาหาร </td>
          <td><input type="text" name="food_name" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="left">ราคา </td>
          <td><input type="text" name="food_price" value="" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><button type="submit">บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
  </form></td>
  </tr>
</table>
<p><table width="50%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td width="20%" height="33" align="center" valign="middle" bgcolor="#CCCCCC">รหัสอาหาร</td>
    <td width="23%" align="center" valign="middle" bgcolor="#CCCCCC">ชื่อ</td>
    <td width="23%" align="center" valign="middle" bgcolor="#CCCCCC">ราคา</td>
    <td width="34%" align="center" valign="middle" bgcolor="#CCCCCC">Option</td>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" valign="middle"><?php echo $row_setDataFood['food_id']; ?></td>
      <td valign="middle"><?php echo $row_setDataFood['food_name']; ?></td>
      <td align="center" valign="middle"><?php echo $row_setDataFood['food_price']; ?></td>
      <td align="center" valign="middle"><table width="100%" border="0">
        <tr>
          <td width="52%" align="center" valign="middle"><a href="Admin_Delete_food.php?food_id=<?php echo $row_setDataFood['food_id']; ?>">ลบ</a></td>
          <td width="48%" align="center" valign="middle"><a href="Admin_Update_food.php?food_idup=<?php echo $row_setDataFood['food_id']; ?>">แก้ไข</a></td>
        </tr>
      </table></td>
    </tr>
    <?php } while ($row_setDataFood = mysql_fetch_assoc($setDataFood)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($setDataFood);
?>
