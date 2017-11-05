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

$treport=(empty($_POST["treport"])?1:$_POST["treport"]);
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setReport1 = sprintf("SELECT food_name, order_amount, food_price FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id=$treport)", GetSQLValueString($colname_setReport1, "int"));
$setReport1 = mysql_query($query_setReport1, $connect_restaurant) or die(mysql_error());
$row_setReport1 = mysql_fetch_assoc($setReport1);
$totalRows_setReport1 = mysql_num_rows($setReport1);

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setTotal = sprintf("SELECT SUM(order_amount*food_price) AS total FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= $treport)");
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
<title>Cashier Reprot</title>
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
</style>

</head>
<body>
<table width="90%" border="0" align="center">
  <tr>
    <td height="52">
      <table width="100%" border="0" align="left" valign="bottom">
              <tr>
                <td width="68%">&nbsp;</td>
                <td width="25%">
                  <div class="dropdown">
                      <button class="dropbtn">Menu</button>
                      <div class="dropdown-content">
                      <a href="http://localhost/ProjectFinal/Web/Test_Cashier_Reprot.php">รับชำระเงิน</a>
                      <a href="#">ตรวจสอบข้อมูลโต๊ะ</a>
                  </div></td>
                <td width="7%">&nbsp;</td>
              </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="bottom"><label for="print"></label>
      <form id="form1" name="form1" method="post" action="">
 		เลือกโต๊ะ&nbsp;&nbsp;
    
 		  <label for="treport"></label>
     
 		  <select name="treport" id="treport">
 		    <option value="1" <?php if (!(strcmp(1, $treport))) {echo "selected=\"selected\"";} ?>>1</option>
 		    <option value="2" <?php if (!(strcmp(2, $treport))) {echo "selected=\"selected\"";} ?>>2</option>
 		    <option value="3" <?php if (!(strcmp(3, $treport))) {echo "selected=\"selected\"";} ?>>3</option>
 		    <option value="4" <?php if (!(strcmp(4, $treport))) {echo "selected=\"selected\"";} ?>>4</option>
 		    <option value="5" <?php if (!(strcmp(5, $treport))) {echo "selected=\"selected\"";} ?>>5</option>
 		    <option value="6" <?php if (!(strcmp(6, $treport))) {echo "selected=\"selected\"";} ?>>6</option>
 		    <option value="7" <?php if (!(strcmp(7, $treport))) {echo "selected=\"selected\"";} ?>>7</option>
 		    <option value="8" <?php if (!(strcmp(8, $treport))) {echo "selected=\"selected\"";} ?>>8</option>
 		    <option value="9" <?php if (!(strcmp(9, $treport))) {echo "selected=\"selected\"";} ?>>9</option>
 		    <option value="10" <?php if (!(strcmp(10, $treport))) {echo "selected=\"selected\"";} ?>>10</option>
 		    <option value="11" <?php if (!(strcmp(11, $treport))) {echo "selected=\"selected\"";} ?>>11</option>
 		    <option value="12" <?php if (!(strcmp(12, $treport))) {echo "selected=\"selected\"";} ?>>12</option>
 		    <option value="13" <?php if (!(strcmp(13, $treport))) {echo "selected=\"selected\"";} ?>>13</option>
 		    <option value="14" <?php if (!(strcmp(14, $treport))) {echo "selected=\"selected\"";} ?>>14</option>
 		    <option value="15" <?php if (!(strcmp(15, $treport))) {echo "selected=\"selected\"";} ?>>15</option>
 		    <option value="16" <?php if (!(strcmp(16, $treport))) {echo "selected=\"selected\"";} ?>>16</option>
        </select>&nbsp;&nbsp;
 
        <button class="button button2" type="submit" name="button" >ตกลง</button>
    
    </form></td>
</tr>
  <tr>
    <td><p>&nbsp;</p>
      <table width="50%" border="0" align="center">
      <tr>
        <th width="50%" height="33" bgcolor="#F3F3F3" scope="col"><strong>อาหาร</strong></th>
        <th width="28%" bgcolor="#F3F3F3" scope="col"><strong>จำนวน</strong></th>
        <th width="22%" bgcolor="#F3F3F3" scope="col"><strong>ราคา/หน่วย</strong></th>
      </tr>
      <?php do { ?>
        <tr valign="middle">
          <td height="39" scope="col"><?php echo $row_setReport1['food_name']; ?></td>
          <td align="center" scope="col"><?php echo $row_setReport1['order_amount']; ?></td>
          <td align="center" scope="col"><?php echo $row_setReport1['food_price']; ?></td>
        </tr>
        <?php } while ($row_setReport1 = mysql_fetch_assoc($setReport1)); ?>
<tr>
  <th height="41" scope="col">&nbsp;</th>
        <td align="center" valign="middle" scope="col">ยอดรวม</td>
        <td align="center" valign="middle" scope="col" width="50%"><h3><input type="text" id="total" name="total" size="5" value="<?php echo $row_setTotal['total']; ?>"></h3></td>
</tr>
      </table>
      <table width="70%" border="0" align="center">
        <tr>
          <td width="53%">&nbsp;</td>
          <td width="8%" align="left" valign="middle">เงินสด</td>
          <td width="39%" align="left" valign="middle">
            <form id="form2" name="form2" method="post" action="">
              <input type="text" id="kid" name="kid" size="5" value="<?php echo($kid)?>">
              <button class="button button3" type="submit1" name="btn_kid" witdh="50%">คำนวณเงินทอน</button>
          </form></td>
        </tr>
        <tr>
          <td height="40">&nbsp;</td>
          <td align="left" valign="middle">เงินทอน</td>
          <td align="left" valign="middle">
            <input type="text" id="kong" name="kong"  size="5" value="<?php echo($kong)?>" readonly>
          </td>
        </tr>
      </table>
    <p>&nbsp;</p></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($setReport1);

mysql_free_result($setTotal);
?>
