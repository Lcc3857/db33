<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mySQL33 = "localhost";
$database_mySQL33 = "db3";
$username_mySQL33 = "root";
$password_mySQL33 = "12345678";
$mySQL33 = mysql_pconnect($hostname_mySQL33, $username_mySQL33, $password_mySQL33) or trigger_error(mysql_error(),E_USER_ERROR); 
?>