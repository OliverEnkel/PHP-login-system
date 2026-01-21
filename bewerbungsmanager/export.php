<?php
require "auth.php";
require "db.php";

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=bewerbungen.csv");

$output = fopen("php://output", "w");
fputcsv($output, ["Firma", "Position", "Status", "Notiz", "Datum"]);

$apps = $db->query("SELECT * FROM applications")->fetchAll();

foreach ($apps as $app) {
    fputcsv($output, [
        $app["company"],
        $app["position"],
        $app["status"],
        $app["note"],
        $app["created_at"]
    ]);
}

fclose($output);
