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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE data_foods SET food_name=%s, food_price=%s WHERE food_id=%s",
                       GetSQLValueString($_POST['food_name'], "text"),
                       GetSQLValueString($_POST['food_price'], "int"),
                       GetSQLValueString($_POST['food_id'], "int"));

  mysql_select_db($database_connect_restaurant, $connect_restaurant);
  $Result1 = mysql_query($updateSQL, $connect_restaurant) or die(mysql_error());

  $updateGoTo = "http://localhost/ProjectFinal/Web/Admin_food.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_setUpdateFood = "-1";
if (isset($_GET['food_idup'])) {
  $colname_setUpdateFood = $_GET['food_idup'];
}
mysql_select_db($database_connect_restaurant, $connect_restaurant);
$query_setUpdateFood = sprintf("SELECT * FROM data_foods WHERE food_id = %s", GetSQLValueString($colname_setUpdateFood, "int"));
$setUpdateFood = mysql_query($query_setUpdateFood, $connect_restaurant) or die(mysql_error());
$row_setUpdateFood = mysql_fetch_assoc($setUpdateFood);
$totalRows_setUpdateFood = mysql_num_rows($setUpdateFood);
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
          <h4 class="mt-5">จัดการข้อมูลอาหาร</h4><p>
         <table width="40%" border="1" align="center" cellspacing="0" bordercolor="#ddd">
  <tr>
    <td align="center" valign="middle">&nbsp;
      <h4>เเก้ไข      </h4>
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
        <table width="314" border="0" align="center" cellspacing="0">
          <tr valign="baseline">
            <td width="103" height="41" align="left" valign="middle" nowrap="nowrap">รหัสอาหาร</td>
            <td width="205" align="left" valign="middle"><strong><?php echo $row_setUpdateFood['food_id']; ?></strong></td>
          </tr>
          <tr valign="baseline">
            <td height="39" align="left" valign="middle" nowrap="nowrap">ชื่ออารหาร</td>
            <td valign="middle"><input type="text" name="food_name" value="<?php echo htmlentities($row_setUpdateFood['food_name'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td height="42" align="left" valign="middle" nowrap="nowrap">ราคา</td>
            <td valign="middle"><input type="text" name="food_price" value="<?php echo htmlentities($row_setUpdateFood['food_price'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
          </tr>
          <tr valign="baseline">
            <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
            <td valign="middle"><button  class="button button2" type="submit" >บันทึก</button></td>
          </tr>
        </table>
        <p>
          <input type="hidden" name="MM_update" value="form1" />
          <input type="hidden" name="food_id" value="<?php echo $row_setUpdateFood['food_id']; ?>" />
        </p>
        <p>&nbsp;</p>
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
mysql_free_result($setUpdateFood);
?>