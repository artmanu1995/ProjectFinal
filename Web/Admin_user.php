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
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

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
    if (($strUsers == "") && true) { 
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

  $insertGoTo = "http://localhost/ProjectFinal/Web/Admin_user.php";
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
  <style>
    tr:nth-child(even){background-color: #FCFCFC}
      </style>
  <style> 
        select {
            width: 100%;
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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">A Food Ordering System in the Restaurant</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

           <li class="nav-item">
              <a class="nav-link" href="http://localhost/ProjectFinal/Web/Admin_data_Table.php">จัดการข้อมูลโต๊ะ</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="http://localhost/ProjectFinal/Web/Admin_food.php">จัดการข้อมูลอาหาร</a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="http://localhost/ProjectFinal/Web/Admin_user.php">จัดการข้อมูล User</a>
            </li>

             <li class="nav-item dropdown">
                 <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?php echo $_SESSION['MM_Username']; ?></a>
                  <div class="dropdown-menu">
                       <a class="dropdown-item" href="#">ตำแหน่ง : Admin</a>
                      
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
          <h4 class="mt-5">จัดการข้อมูล User</h4><p>

         <table width="45%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td align="center" valign="middle"><p>
      <h5>เพิ่ม</h5>
    </p>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="393" align="center">
        <tr valign="baseline">
          <td width="91" height="47" align="left" valign="middle" nowrap="nowrap">Username</td>
          <td width="196" align="left" valign="middle"><input type="text" name="user_username" value="" size="40" /></td>
        </tr>
        <tr valign="baseline">
          <td height="43" align="left" valign="middle" nowrap="nowrap">Password</td>
          <td align="left" valign="middle"><input type="text" name="user_password" value="" size="40" /></td>
        </tr>
        <tr valign="baseline">
          <td height="45" align="left" valign="middle" nowrap="nowrap">ชื่อ-สกุล</td>
          <td align="left" valign="middle"><input type="text" name="user_name" value="" size="40" /></td>
        </tr>
        <tr valign="baseline">
          <td height="55" align="left" valign="middle" nowrap="nowrap">ตำแหน่ง</td>
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
          <td align="left" valign="middle"><button type="submit" class="button button2">บันทึก</button></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1" />
  </form></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="70%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td height="41" align="center" valign="middle" bgcolor="#CCCCCC">รหัสสมาชิก</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Username</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Password</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">ชื่อ-สกุล</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">ตำแหน่ง</td>
    <td align="center" valign="middle" bgcolor="#CCCCCC">Option</td>
  </tr>
  <?php do { ?>
    <tr>
      <td height="41" align="center" valign="middle"><?php echo $row_setDataUser['user_id']; ?></td>
      <td align="left" valign="middle"><?php echo $row_setDataUser['user_username']; ?></td>
      <td align="left" valign="middle"><?php echo $row_setDataUser['user_password']; ?></td>
      <td align="left" valign="middle"><?php echo $row_setDataUser['user_name']; ?></td>
      <td align="left" valign="middle"><?php echo $row_setDataUser['position_name']; ?></td>
      <td valign="middle"><table width="100%" border="0" align="left">
        <tr>
          <td align="center" valign="middle"><a href="Admin_Delete_user.php?user_id=<?php echo $row_setDataUser['user_id']; ?>">ลบ</a></td>
          <td align="center" valign="middle"><a href="Admin_Upuser.php?user_idup=<?php echo $row_setDataUser['user_id']; ?>">แก้ไข</a></td>
        </tr>
      </table></td>
    </tr>
    <?php } while ($row_setDataUser = mysql_fetch_assoc($setDataUser)); ?>
</table>
<p>&nbsp;</p>
        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript -->
    <script src="jquery/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

  </body>
</html>
<?php
mysql_free_result($setDataUser);

mysql_free_result($setPosition);
?>