<?php
require "db.php";

$stmt = $db->prepare("
INSERT INTO applications (company, position, status, note, created_at)
VALUES (?, ?, ?, ?, datetime('now'))
");

$stmt->execute([
    $_POST["company"],
    $_POST["position"],
    $_POST["status"],
    $_POST["note"]
]);

header("Location: index.php");