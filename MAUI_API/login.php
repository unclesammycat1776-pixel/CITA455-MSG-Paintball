
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo json_encode([
        "success" => false,
        "message" => "POST requests only."
    ]);
    exit();
}

include "../db.php";

$data = json_decode(file_get_contents("php://input"), true);

$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

if ($email == "" || $password == "") {
    echo json_encode([
        "success" => false,
        "message" => "Please enter your email and password."
    ]);
    exit();
}

$sql = "SELECT Player_ID, First_Name, Last_Name, Player_Email, Password
        FROM player
        WHERE Player_Email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $player = $result->fetch_assoc();

    if (password_verify($password, $player["Password"])) {

        echo json_encode([
            "success" => true,
            "message" => "Login successful.",
            "player" => [
                "player_id" => $player["Player_ID"],
                "first_name" => $player["First_Name"],
                "last_name" => $player["Last_Name"],
                "email" => $player["Player_Email"]
            ]
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Incorrect email or password."
        ]);
    }

} else {

    echo json_encode([
        "success" => false,
        "message" => "Incorrect email or password."
    ]);
}

$stmt->close();
$conn->close();
?>
