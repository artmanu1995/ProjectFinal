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
date_default_timezone_set('Asia/Bangkok');
$today_date=date("Y-m-d [H : i : s]");

$kon=(empty($_POST['kon'])?1:$_POST['kon']);
$colname_setReport = "-1";
if (isset($_POST['kon'])) {
  $colname_setReport = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setReport = sprintf("SELECT food_name, order_amount, food_price FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id=%s)", GetSQLValueString($colname_setReport, "int"));
$setReport = mysql_query($query_setReport, $connect_restaurant) or die(mysql_error());
$row_setReport = mysql_fetch_assoc($setReport);
$totalRows_setReport = mysql_num_rows($setReport);

$colname_setTotal = "-1";
if (isset($_POST['kon'])) {
  $colname_setTotal = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setTotal = sprintf("SELECT SUM(order_amount*food_price) AS total FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setTotal, "int"));
$setTotal = mysql_query($query_setTotal, $connect_restaurant) or die(mysql_error());
$row_setTotal = mysql_fetch_assoc($setTotal);
$totalRows_setTotal = mysql_num_rows($setTotal);

$kid=0;
$kid=(empty($_POST['kid'])?0:$_POST['kid']);
$kong=$kid-$row_setTotal['total'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#wrapAll {
	font-family: "TH SarabunPSK";
	color: #000000;
	margin: auto;
	width: 800px;
}
#reportID {
	font-family: "TH SarabunPSK";
	font-size: 1em;
	font-weight: bold;
	color: #000;
	float: left;
	width: 30%;
}
#dataTable {
	font-family: "TH SarabunPSK";
	font-size: 1em;
	font-weight: bold;
	color: #000;
	float: left;
	width: 20%;
}
#dateTime {
	font-family: "TH SarabunPSK";
	font-size: 1em;
	color: #000;
	float: right;
	width: 30%;
}
body,td,th {
	font-family: "TH SarabunPSK";
	font-size: 22px;
}
.TableReport {
	font-family: "TH SarabunPSK";
	font-size: 1em;
	font-weight: normal;
	color: #000;
	clear: both;
	width: 98%;
	padding-top: 10px;
}
@media print{
	#wrapAll{
		width:100%
	}
	#subprint{
		display:none;
	}
	#subkid{
		display:none;
	}
	#subkon{
		display:none;
	}
	#kon{
		display:none;
	}
	#titleText{
		display:none;
	}
	#kid{
		width:100%
	}
  #kong{
    width: 100%
  }
}
</style>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr>
    <td align="left" valign="middle"><form id="form1" name="form1" method="post" action="">
      <table width="40%" border="0" align="center">
        <tr>
          <td align="center"><label id="titleText">เลือกโต๊ะ</label>
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
            <input type="submit" name="subkon" id="subkon" value="ตกลง" /></td>
        </tr>
    </table>
      <div id="wrapAll">
        <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <th scope="col"><h2><strong>บิลค่าอาหาร</strong></h2></th>
          </tr>
      </table>
        <p><div id="reportID">รหัสใบเสร็จ : </div>
        <div id="dataTable">หมายเลขโต๊ะ : <?php echo $kon?></div>
        <div class="dataKid"></div>
        <div id="dateTime">วันที่ <?php echo $today_date ?></div>
        <div class="dataKid"></div>
        <div class="TableReport">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr>
              <th width="43%" height="38" align="center" valign="middle" bgcolor="#D8D8D8" scope="col">อาหาร</th>
              <th width="27%" align="center" valign="middle" bgcolor="#D8D8D8" scope="col">จำนวน</th>
              <th width="30%" align="center" valign="middle" bgcolor="#D8D8D8" scope="col">ราคา</th>
            </tr>
            <?php do { ?>
              <tr>
                <td valign="middle"><?php echo $row_setReport['food_name']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setReport['order_amount']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setReport['food_price']; ?></td>
              </tr>
              <?php } while ($row_setReport = mysql_fetch_assoc($setReport)); ?>
          </table>
      </div>
              <div class="TableReport">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <th width="59%" height="45" align="center" valign="middle" scope="col">&nbsp;</th>
              <td width="14%" align="left" valign="middle" scope="col">ยอดชำระ</td>
              <td width="27%" align="center" valign="middle" bgcolor="#F5F5F5" scope="col"><?php echo $row_setTotal['total']; ?></td>
            </tr>
            <tr>
              <td valign="middle">&nbsp;</td>
              <td align="left" valign="middle">เงินสด</td>
              <td align="left" valign="middle"><label for="kid"></label>
                <input type="text" name="kid" id="kid" value="<?php echo($kid)?>" size="10%"/>
                <button type="submit" name="subkid" id="subkid">คำนวณเงินทอน</button></td>
            </tr>
            <tr>
              <td height="34" valign="middle">&nbsp;</td>
              <td align="left" valign="middle">เงินทอน</td>
              <td align="left" valign="middle">
                <input type="text" name="kong" id="kong" size="10" value="<?php echo ($kong)?>"/>
              </td>
            </tr>
            <tr>
              <td valign="middle">&nbsp;</td>
              <td align="left" valign="middle">&nbsp;</td>
              <td align="left" valign="middle"><button type="submit" name="subprint" id="subprint" onclick="window.print()">พิมพ์ใบเสร็จ</button></td>
            </tr>
          </table>
          </div>
              <div class="TableReport">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <th width="62%" height="38" align="center" valign="middle" scope="col">&nbsp;</th>
              <td width="38%" align="center" valign="middle" scope="col"><p>ลงชื่อ.................................................</p>
                <p>(...............................................)</p>
                <p>ผู้รับชำระเงิน</p></td>
              </tr>
            </table>
      </div>
        </p>
  </div>
      <p>&nbsp;</p>
    </form></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($setReport);

mysql_free_result($setTotal);
?>
