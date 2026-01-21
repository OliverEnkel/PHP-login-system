<?php
require "auth.php";
require "db.php";

/* FILTER */
if (!empty($_GET["filter"])) {
    $stmt = $db->prepare("SELECT * FROM applications WHERE status = ? ORDER BY id DESC");
    $stmt->execute([$_GET["filter"]]);
    $apps = $stmt->fetchAll();
} else {
    $apps = $db->query("SELECT * FROM applications ORDER BY id DESC")->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Bewerbungsmanager</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="top-bar">
        <h1>Bewerbungsmanager</h1>
        <div>
            <a href="export.php">CSV Export</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>

    <!-- FILTER -->
    <form method="GET" class="filter-bar">
        <select name="filter">
            <option value="">Alle Status</option>
            <?php
            $statuses = ["Offen", "Gesendet", "Einladung", "Absage"];
            foreach ($statuses as $status) {
                $selected = (isset($_GET["filter"]) && $_GET["filter"] === $status) ? "selected" : "";
                echo "<option value=\"$status\" $selected>$status</option>";
            }
            ?>
        </select>
        <button type="submit">Filtern</button>
    </form>

    <!-- NEUE BEWERBUNG -->
    <form action="add.php" method="POST">
        <input type="text" name="company" placeholder="Firma" required>
        <input type="text" name="position" placeholder="Position" required>

        <select name="status">
            <option>Offen</option>
            <option>Gesendet</option>
            <option>Einladung</option>
            <option>Absage</option>
        </select>

        <input type="text" name="note" placeholder="Notiz (optional)">
        <button type="submit">Hinzufügen</button>
    </form>

    <!-- TABELLE -->
    <table>
        <thead>
            <tr>
                <th>Firma</th>
                <th>Position</th>
                <th>Status</th>
                <th>Notiz</th>
                <th>Datum</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>

        <?php if (count($apps) === 0): ?>
            <tr>
                <td colspan="6">Keine Bewerbungen gefunden.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($apps as $app): ?>
            <tr>
                <td><?= htmlspecialchars($app["company"]) ?></td>
                <td><?= htmlspecialchars($app["position"]) ?></td>

                <!-- STATUS -->
                <td>
                    <form action="update.php" method="POST">
                        <input type="hidden" name="id" value="<?= $app["id"] ?>">
                        <select name="status" onchange="this.form.submit()">
                            <?php
                            foreach ($statuses as $s) {
                                $selected = ($app["status"] === $s) ? "selected" : "";
                                echo "<option value=\"$s\" $selected>$s</option>";
                            }
                            ?>
                        </select>
                    </form>

                    <br>
                    <span class="status <?= $app["status"] ?>">
                        <?= htmlspecialchars($app["status"]) ?>
                    </span>
                </td>

                <td><?= htmlspecialchars($app["note"]) ?></td>

                <td>
                    <?= date("d.m.Y", strtotime($app["created_at"])) ?>
                </td>

                <!-- AKTIONEN -->
                <td class="actions">
                    <a href="delete.php?id=<?= $app["id"] ?>" onclick="return confirm('Eintrag wirklich löschen?')">
                        🗑
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

</body>
</html>
