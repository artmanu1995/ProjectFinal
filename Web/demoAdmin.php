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
</head>

<body>
<table width="90%" border="0" align="center" cellspacing="0">
  <tr>
    <td>
       <div class="dropdown">
         <button class="dropbtn">จัดการข้อมูลอาหาร</button>
        <div class="dropdown-content">
          <a href="http://localhost/ProjectFinal/Web/Admin_data_food.php">ข้อมูลอาหาร</a>
          <a href="http://localhost/ProjectFinal/Web/Admin_add_food.php">เพิ่มข้อมูลอาหาร</a></div>
    </td>
  </tr>
</table>
</body>
</html>