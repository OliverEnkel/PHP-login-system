<?php
require "db.php";

$stmt = $db->prepare("UPDATE applications SET status = ? WHERE id = ?");
$stmt->execute([
    $_POST["status"],
    $_POST["id"]
]);

header("Location: index.php");