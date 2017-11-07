
<?php require_once('Connections/connect_restaurant.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "FromLogin.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "FromLogin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$date=date("Y-m-d H:i:s");

$kon=(empty($_POST['kon'])?1:$_POST['kon']);
$colname_setReport = "-1";
if (isset($_POST['kon'])) {
  $colname_setReport = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setReport = sprintf("SELECT order_openTable, food_name, order_amount, food_price, (order_amount*food_price) AS KOON FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id=%s)", GetSQLValueString($colname_setReport, "int"));
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

mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setOpentabel = "SELECT COUNT(*) FROM data_payment";
$setOpentabel = mysql_query($query_setOpentabel, $connect_restaurant) or die(mysql_error());
$row_setOpentabel = mysql_fetch_assoc($setOpentabel);
$totalRows_setOpentabel = mysql_num_rows($setOpentabel);

$colname_setCountReport = "-1";
if (isset($_POST['kon'])) {
  $colname_setCountReport = $_POST['kon'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setCountReport = sprintf("SELECT COUNT(*)  FROM data_listorder INNER JOIN data_order ON  data_listorder.listO_id = data_order.listO_id INNER JOIN data_foods ON  data_listorder.food_id = data_foods.food_id WHERE (sttSO_id=0) AND (sttCS_id=0) AND (sttPay_id=1) AND (table_id= %s)", GetSQLValueString($colname_setCountReport, "int"));
$setCountReport = mysql_query($query_setCountReport, $connect_restaurant) or die(mysql_error());
$row_setCountReport = mysql_fetch_assoc($setCountReport);
$totalRows_setCountReport = mysql_num_rows($setCountReport);

$total= $row_setTotal['total'];
$opent = $row_setReport['order_openTable'];

$payid = $query_setOpentabel+1;

$kid=(empty($_POST['kid'])?0:$_POST['kid']);
$kong=$kid-$row_setTotal['total'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>A Food Ordering System in the Restaurant</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }
    </style>

    <style type="text/css">
#wrapAll {
  font-family: Tahoma, Geneva, sans-serif;
  color: #000000;
  margin: auto;
  width: 800px;
}
#reportID {
  font-size: 1em;
  font-weight: bold;
  color: #000;
  float: left;
  width: 30%;
}
#dataTable {
  font-size: 1em;
  font-weight: bold;
  color: #000;
  float: left;
  width: 20%;
}
#dateTime {
  font-size: 1em;
  color: #000;
  float: right;
  width: 35%;
}
.TableReport {
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
  #sumToMySQL{
    display:none;
  }
  #navbardrop{
    display:none;
  }
  #navbarResponsive{
    display:none;
  }
  #logo{
    display:none;
  }
  #subToMySQL{
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
          .button4 {
              padding: 10px 20px;
              background-color: #0087ff; 
              color: white; 
              border: 2px solid #0087ff;
          }

          .button4:hover {
              background-color: white;
              color: black;
          }
  </style>
  </head>
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" id="logo" href="#">A Food Ordering System in the Restaurant</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

           <li class="nav-item">
              <a class="nav-link" href="http://localhost/ProjectFinal/Web/Cashier_Report.php">ออกบิลค่าอาหาร</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="http://localhost/ProjectFinal/Web/Cashier_StatusTable.php">ตรวจสอบสถานะโต๊ะ</a>
            </li>

             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?php echo $_SESSION['MM_Username']; ?></a>
                  <div class="dropdown-menu">
                       <a class="dropdown-item" href="#">ตำแหน่ง : Cashier</a>
                      
                       <a class="dropdown-item" href="<?php echo $logoutAction ?>">ออกจากระบบ</a>
                   </div>
                </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
        <h3 class="mt-5">ออกบิลค่าอาหาร</h3>
        <p>
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
            <button class="button button2" type="submit" name="subkon" id="subkon">ตกลง</button></td>
        </tr>
    </table>
      <div id="wrapAll">
        <p><div id="reportID">รหัสใบเสร็จ : </div>
        <div id="dataTable">หมายเลขโต๊ะ : <?php echo $kon?></div>
        <div class="dataKid"></div>
        <div id="dateTime">วันที่ <?php echo $today_date ?></div>
        <div class="dataKid"></div>
        <div class="TableReport">
          <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#ddd">
            <tr>
              <td width="28%" height="38" align="center" valign="middle" bgcolor="#D8D8D8" scope="col"><strong>อาหาร</strong></td>
              <td width="23%" align="center" valign="middle" bgcolor="#D8D8D8" scope="col"><strong>จำนวน</strong></td>
              <td width="24%" align="center" valign="middle" bgcolor="#D8D8D8" scope="col"><strong>ราคา/หน่วย</strong></td>
              <td width="25%" align="center" valign="middle" bgcolor="#D8D8D8" scope="col"><strong>รวมหน่วย</strong></td>
            </tr>
            <?php do { ?>
              <tr>
                <td valign="middle"><?php echo $row_setReport['food_name']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setReport['order_amount']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setReport['food_price']; ?></td>
                <td align="center" valign="middle"><?php echo $row_setReport['KOON']; ?></td>
              </tr>
              <?php } while ($row_setReport = mysql_fetch_assoc($setReport)); ?>
          </table>
      </div>
              <div class="TableReport">

                <table width="100%" border="0">
  <tr>
    <td width="48%" height="42">&nbsp;</td>
    <td width="16%">ยอดชำระ</td>
    <td width="36%">
      <strong><?php echo $row_setTotal['total']; ?></strong>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>เงินสด</td>
    <td>
      <input type="text" name="kid" id="kid"  value="<?php echo($kid)?>" size="10%"/>
      <button class = "button button3" type="submit" name="subkid" id="subkid">คำนวณเงินทอน</button>
    </td>
  </tr>
  <tr>
    <td height="46">&nbsp;</td>
    <td>งินทอน</td>
    <td><input type="text" name="kong" id="kong" size="10" value="<?php echo ($kong)?>"/></td>
  </tr>
  <tr>
    <td height="67">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left"><button class="button button2" type="submit" name="subToMySQL" id="subToMySQL" onclick="subToMySQL()">บันทึก</button></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><button class = "button button4" type="submit" name="subprint" id="subprint" onclick="window.print()">พิมพ์ใบเสร็จ</button></td>
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
    <script>
        function subToMySQL() {
          InputStream objInputStream = null;
        String strJSON = "";
        try {

            HttpClient objHttpClient = new DefaultHttpClient();
            HttpPost objHttpPost = new HttpPost("http://192.168.1.90/ProjectFinal/Web/set_open_id.php");
            HttpResponse objHttpResponse = objHttpClient.execute(objHttpPost);
            HttpEntity objHttpEntity = objHttpResponse.getEntity();
            objInputStream = objHttpEntity.getContent();

        } catch (Exception e) {
            Log.d("oic", "InputStream ==> " + e.toString());
        }
        //Create strJSON
        try {
            BufferedReader objBufferedReader = new BufferedReader(new InputStreamReader(objInputStream, "UTF-8"));
            StringBuilder objStringBuilder = new StringBuilder();
            String strLine = null;
            while ((strLine = objBufferedReader.readLine()) != null) {
                objStringBuilder.append(strLine);
            }   // while
            objInputStream.close();
            strJSON = objStringBuilder.toString();

        } catch (Exception e) {
            Log.d("oic", "strJSON ==> " + e.toString());
        }
        //UpData SQLite
        try {
            final JSONArray objJsonArray = new JSONArray(strJSON);
            for (int j = 0; j < objJsonArray.length(); j++) {
                JSONObject objJSONObject = objJsonArray.getJSONObject(j);
                String strTableID = objJSONObject.getString("table_id");
                String strOpenTable = objJSONObject.getString("order_openTable");
                Integer intableid = Integer.parseInt(strTableID);
                Integer intopenid = Integer.parseInt(strOpenTable);

                if ($kon=strTableID) {

                          <?php
                          $servername = "localhost";
                          $username = "root";
                          $password = "00112233";
                          $dbname = "restaurant_db";
                      
                          try {
                              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                  $sql = "UPDATE data_order SET sttPay_id=0 WHERE order_openTable=intopenid";
                                  $stmt = $conn->prepare($sql);
                                  $stmt->execute();

                          }catch(PDOException $e){
                              echo $sql . "<br>" . $e->getMessage();
                            }
                          $conn = null;
                          ?>
                }
            }
        } catch (Exception e) {
            Log.d("oic", "Update ==> " + e.toString());
          }
        }
      </script>
    </form></td>
  </tr>
</table>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="jquery/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<?php
mysql_free_result($setReport);

mysql_free_result($setTotal);

mysql_free_result($setOpentabel);

mysql_free_result($setCountReport);
?>