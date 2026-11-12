<?php

header("Content-Type: application/json");

include "database.php";

$sql = "SELECT * FROM game";

$result = mysqli_query($conn, $sql);

$games = [];

while ($row = mysqli_fetch_assoc($result)) {
	$games[] = $row;
}

echo json_encode($games);

?>