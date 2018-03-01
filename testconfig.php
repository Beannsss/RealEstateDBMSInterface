<?php

if(!isset($_SESSION)){session_start();}

// Connecting to the MySQL database
$tns = "
(DESCRIPTION =
(ADDRESS = (PROTOCOL = TCP)(HOST = CITDB.NKU.EDU)(PORT = 1521))
(CONNECT_DATA =
(SERVER = DEDICATED)
(SERVICE_NAME = csc450.citdb.nku.edu)
)
)";
$db_username = "whelanb1";
$db_password = "csc63";

try {
$dbh = new PDO("oci:dbname=".$tns,$db_username,$db_password);
} catch(PDOException $e) {
die('CONNECT error because ' .$e->getMessage());
}

$current_url = basename($_SERVER['REQUEST_URI']);

// if customerID is not set in the session and current URL not login.php redirect to login page
if (!isset($_SESSION['USERID']) && $current_url != 'test.php') {
    header("Location: test.php");
}