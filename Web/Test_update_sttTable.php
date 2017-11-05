<!DOCTYPE html>
<html>
<head>
<body>
  <?php
      $servername = "localhost";
      $username = "root";
      $password = "00112233";
      $dbname = "restaurant_db";

      try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $numtable=1;
          for ($i=0; $i<16; $i++) { 
              $sql = "UPDATE data_onofftable SET sttOFT_id=0 WHERE table_id=$numtable";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $numtable++;
          }

          $numtable=1;
          for ($i=0; $i<16; $i++) { 
              $sql = "UPDATE data_table SET sttTable_id=0 WHERE table_id=$numtable";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $numtable++;
          }

          $numtable=1;
          for ($i=0; $i<($_POST["valueTable"]); $i++) { 
              $sql = "UPDATE data_table SET sttTable_id=1 WHERE table_id=$numtable";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $numtable++;
          }
      }catch(PDOException $e){
          echo $sql . "<br>" . $e->getMessage();
        }
      $conn = null;
  ?>
  <script type="text/javascript">
    alert("บันทึกเรียบร้อย")
  </script>
  <!--<?php
          $servername = "localhost";
          $username = "root";
          $password = "00112233";
          $dbname = "restaurant_db";

          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
          $numtable=1;
          for ($i=1; $i<=count($_POST["valueTable"]); $i++) { 
              $sql = "UPDATE data_table SET sttTable_id=1 WHERE table_id=$numtable";
              $numtable++;
          }
          if ($conn->query($sql) === TRUE) {
              echo "Record updated successfully";
          }else {
              echo "Error updating record: " . $conn->error;
          }
          $conn->close();
      ?> -->
</body>
</head>
</html> 
      