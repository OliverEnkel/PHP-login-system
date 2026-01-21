<?php
require "db.php";

$stmt = $db->prepare("DELETE FROM applications WHERE id = ?");
$stmt->execute([$GET["id"]]);

header("Location: index.php");