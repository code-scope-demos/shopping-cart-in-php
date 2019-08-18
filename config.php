<?php 

define('DB_HOSTNAME','localhost');	/* Database Hostname */
define('DB_USERNAME','root');		/* Database Username */
define('DB_PASSWORD','');			/* Database Password */
define('DB_NAME','shop');			/* Database Name */

session_start();

$dbconnection = mysqli_connect(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_NAME);

if (mysqli_connect_errno()) {
	echo mysqli_connect_error();
	die();
}

 ?>