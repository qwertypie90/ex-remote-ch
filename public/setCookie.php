<?php
if (isset($_POST['authToken'])) {
    $token = $_POST['authToken'];
    setcookie("authToken", $token, time() + (86400 * 30), "/");
    echo json_encode(["status" => "cookie set"]);
}
?>