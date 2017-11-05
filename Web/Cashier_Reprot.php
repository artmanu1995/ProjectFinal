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
<style>
          .button {
              background-color: #4CAF50; /* Green */
              border: none;
              color: white;
              padding: 7px 30px;
              text-align: center;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin: 4px 2px;
              -webkit-transition-duration: 0.4s;
              transition-duration: 0.4s;
              cursor: pointer;
          }
          .button2 {
              background-color: #0fc15a; 
              color: white; 
              border: 2px solid #0fc15a;
          }

          .button2:hover {
              background-color: white;
              color: black;
          }
          .button3 {
              padding: 10px 20px;
              background-color: #ffa700; 
              color: white; 
              border: 2px solid #ffa700;
          }

          .button3:hover {
              background-color: white;
              color: black;
          }
</style>
<style> 
        select {
            width: 10%;
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
        }
</style>
<style>
      .dropbtn {
          background-color: #008CBA;
          color: white;
          padding: 10px 40px;
          font-size: 16px;
          border: none;
          cursor: pointer;
      }

      .dropdown {
          position: relative;
          display: inline-block;
      }

      .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f9f9f9;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
      }

      .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
      }

      .dropdown-content a:hover {background-color: #f1f1f1}

      .dropdown:hover .dropdown-content {
          display: block;
      }

      .dropdown:hover .dropbtn {
          background-color: #1e90ff;
      }
</style>
<style> 
    input[type=text] {
        width: 40%;
        padding: 10px 10px;
        margin: 8px 0;
        box-sizing: border-box;
    }
a:link {
	color: #00F;
}
a:hover {
	color: #F00;
}
</style>
</head>
<body>
<form id="form1" name="form1" method="post" action="">
  <table width="90%" border="0" align="center">
        <tr>
             <td width="25%" height="46" align="left">
                  <div class="dropdown">
                      <button class="dropbtn">Menu</button>
                      <div class="dropdown-content">
                      	<a href="http://localhost/ProjectFinal/Web/Cashier_Reprot.php">รับชำระเงิน</a>
                  		<a href="http://localhost/ProjectFinal/Web/Cashier_sttTable.php">ตรวจสอบข้อมูลโต๊ะ</a></div></td>
        </tr>
        <tr>
        <td align="center">เลือกโต๊ะที่ต้องการชำระเงิน 
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
          <button class="button button2" type="submit" name="submitkon" id="submitkon">ตกลง</button>
          <p>&nbsp;</p>
          <table width="50%" border="0" align="center">
            <tr>
              <td width="38%" height="38" align="center" valign="middle" bgcolor="#E8E8E8">อาหาร</td>
              <td width="33%" align="center" valign="middle" bgcolor="#E8E8E8">จำนวน</td>
              <td width="29%" align="center" valign="middle" bgcolor="#E8E8E8">ราคา</td>
            </tr>
            <?php do { ?>
              <tr>
                <td height="27" valign="middle"><?php echo $row_setKon['food_name']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setKon['order_amount']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setKon['food_price']; ?></td>
              </tr>
              <?php } while ($row_setKon = mysql_fetch_assoc($setKon)); ?>
            <tr>
              <td height="29" valign="middle">&nbsp;</td>
              <td align="center" valign="middle" bgcolor="#F3F3F3">ยอดรวม</td>
              <td align="center" valign="middle" bgcolor="#F3F3F3"><?php echo $row_setTotal['total']; ?></td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <table width="100%" border="0">
            <tr>
              <td width="50%">&nbsp;</td>
              <td width="11%" align="left" valign="middle">เงินสด</td>
              <td width="39%" align="left" valign="middle">
              	<input type="text" name="kid" id="kid" value="<?php echo($kid)?>" />
            	<button class="button button3" type="submit" name="subkid" id="subkid" witdh="50%">คำนวนเงิน</button>
             </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td valign="middle">เงินทอน</td>
              <td align="left" valign="middle">
              	<input type="text" name="kong" id="kong" value="<?php echo($kong)?>" />
              </td>
            </tr>
            <tr>
              <td height="32">&nbsp;</td>
              <td>&nbsp;</td>
              <td align="left" valign="middle"><a href="http://localhost/ProjectFinal/Web/Cashier_Total.php?kon=$kon">พิมพ์ใบเสร็จ</a></td>
            </tr>
          </table>
        </td>
        </tr>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($setKon);

mysql_free_result($setTotal);
?>
