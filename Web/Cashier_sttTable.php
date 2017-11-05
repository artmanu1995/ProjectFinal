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
$query_setSttTable = "SELECT table_id, sttOFT_name  FROM data_onofftable, data_statusonofftable WHERE data_onofftable.sttOFT_id=data_statusonofftable.sttOFT_id";
$setSttTable = mysql_query($query_setSttTable, $connect_restaurant) or die(mysql_error());
$row_setSttTable = mysql_fetch_assoc($setSttTable);
$totalRows_setSttTable = mysql_num_rows($setSttTable);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
</head>

<body>
       <table width="90%" border="0" align="center">
         <tr>
           <td align="left">
              <div class="dropdown">
				<button class="dropbtn">Menu</button>
                   <div class="dropdown-content">
                    <p><a href="http://localhost/ProjectFinal/Web/Cashier_Reprot.php">รับชำระเงิน</a>
                    <a href="http://localhost/ProjectFinal/Web/Cashier_sttTable.php">ตรวจสอบข้อมูลโต๊ะ</a>
       				</div>
           </td>
         </tr>
       </table>
<p><table width="30%" border="1" align="center" cellspacing="0">
              <tr>
                <td width="61%" height="33" align="center" valign="middle" bgcolor="#E8E8E8">หมายเลขโต๊ะ</td>
                <td width="39%" align="center" valign="middle" bgcolor="#E8E8E8">สถานะโต๊ะ</td>
              </tr>
              <?php do { ?>
                <tr>
                  <td height="22" align="center" valign="middle"><?php echo $row_setSttTable['table_id']; ?></td>
                  <td align="center" valign="middle"><?php echo $row_setSttTable['sttOFT_name']; ?></td>
                </tr>
                <?php } while ($row_setSttTable = mysql_fetch_assoc($setSttTable)); ?>
	  </table>
</body>

</html>
<?php
mysql_free_result($setSttTable);
?>
