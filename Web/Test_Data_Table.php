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

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setDataTable = "SELECT table_id, sttTable_name FROM data_table, data_statustable WHERE data_table.sttTable_id=data_statustable.sttTable_id";
$setDataTable = mysql_query($query_setDataTable, $connect_restaurant) or die(mysql_error());
$row_setDataTable = mysql_fetch_assoc($setDataTable);
$totalRows_setDataTable = mysql_num_rows($setDataTable);

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setValueTable = "SELECT COUNT(*) FROM data_table WHERE sttTable_id=1";
$setValueTable = mysql_query($query_setValueTable, $connect_restaurant) or die(mysql_error());
$row_setValueTable = mysql_fetch_assoc($setValueTable);
$totalRows_setValueTable = mysql_num_rows($setValueTable);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
  <style>
        table, td, th {    
            border: 1px solid #ddd;
        }
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
  <style> 
        select {
            width: 15%;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: #f1f1f1;
        }
  </style>
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
</head>

<body>
<table width="40%" border="0" align="center">
  <tr>
    <td valign="middle"><center><form id="form1" name="form1" method="POST" action="http://localhost/ProjectFinal/Web/Test_update_sttTable.php">
        <label for="valueTable"></label>
        เลือกจำนวนโต๊ะที่ต้องการใช้งาน 
        <select name="valueTable" id="valueTable">
          <option value="1" <?php if (!(strcmp(1, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>1</option>
          <option value="2" <?php if (!(strcmp(2, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>2</option>
          <option value="3" <?php if (!(strcmp(3, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>3</option>
          <option value="4" <?php if (!(strcmp(4, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>4</option>
          <option value="5" <?php if (!(strcmp(5, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>5</option>
          <option value="6" <?php if (!(strcmp(6, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>6</option>
          <option value="7" <?php if (!(strcmp(7, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>7</option>
          <option value="8" <?php if (!(strcmp(8, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>8</option>
          <option value="9" <?php if (!(strcmp(9, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>9</option>
          <option value="10" <?php if (!(strcmp(10, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>10</option>
          <option value="11" <?php if (!(strcmp(11, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>11</option>
          <option value="12" <?php if (!(strcmp(12, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>12</option>
          <option value="13" <?php if (!(strcmp(13, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>13</option>
          <option value="14" <?php if (!(strcmp(14, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>14</option>
          <option value="15" <?php if (!(strcmp(15, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>15</option>
          <option value="16" <?php if (!(strcmp(16, $row_setValueTable['COUNT(*)']))) {echo "selected=\"selected\"";} ?>>16</option>

        </select>
        <button class="button button2" type="submit" name="sub_table" id="sub_table">บันทึก</button>
    </form></center></td>
  </tr>
</table>
<p><table width="30%" border="1" align="center">
      <tr>
        <th width="54%" height="28" align="center" valign="middle" bgcolor="#666666">หมายเลขโต๊ะ</th>
        <th width="46%" align="center" valign="middle" bgcolor="#666666">สสถานะการใช้งาน</th>
      </tr>
      <?php do { ?>
        <tr>
          <td align="center" valign="middle"><?php echo $row_setDataTable['table_id']; ?></td>
          <td align="center" valign="middle"><?php echo $row_setDataTable['sttTable_name']; ?></td>
        </tr>
        <?php } while ($row_setDataTable = mysql_fetch_assoc($setDataTable)); ?>
    </table>
</body>
</html>
<?php
mysql_free_result($setDataTable);

mysql_free_result($setValueTable);
?>
