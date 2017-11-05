<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connect_restaurant = "localhost";
$database_connect_restaurant = "restaurant_db";
$username_connect_restaurant = "root";
$password_connect_restaurant = "00112233";
$connect_restaurant = mysql_pconnect($hostname_connect_restaurant, $username_connect_restaurant, $password_connect_restaurant) or trigger_error(mysql_error(),E_USER_ERROR); 
?>