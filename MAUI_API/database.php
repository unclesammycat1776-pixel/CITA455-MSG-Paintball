<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "msg_paintball";
	$conn = "";
	
	$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

	if (!$conn) {
	    die(json_encode([
	        "status" => "error",
	        "message" => "Database connection failed"
	    ]));
}
?>