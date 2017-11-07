     <script>
        function subToMySQL() {
          <?php
          $servername = "localhost";
          $username = "root";
          $password = "00112233";
          $dbname = "restaurant_db";
      

          try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              // set the PDO error mode to exception
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $sql = "UPDATE data_onofftable SET sttOFT_id=0 WHERE table_id=$kon";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();

                  for ($i = 0; $i < ($row_setCountReport['COUNT(*)']); $i++) {
                  $sql = "UPDATE data_order SET sttPay_id=0 WHERE order_openTable=$opent";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  }

                  $sql = "INSERT INTO data_payment (payment_id, table_id, payment_date, user_id) VALUES ($payid, $kon, '$date', 11)";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();

                  for ($i = 0; $i < ($row_setCountReport['COUNT(*)']); $i++) {
                  $sql = "INSERT INTO data_listpayment (listP_id, payment_id, listO_id, listP_ptotal, listP_pbalance) VALUES (NULL, $payid, $opent, $total, $kong)";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  }

                  for ($i = 0; $i < ($row_setCountReport['COUNT(*)']); $i++) {
                  $sql = "UPDATE data_order SET sttPay_id=0 WHERE order_openTable=$opent";
                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  }

          }catch(PDOException $e){
              echo $sql . "<br>" . $e->getMessage();
            }
          $conn = null;
          ?>
        }
      </script>