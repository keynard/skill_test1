
<?php
require 'db.php';

// Example: Fetch all participants
$stmt = $pdo->query("SELECT * FROM participants");
$participants = $stmt->fetchAll();

foreach ($participants as $p) {
    echo $p['partFName'] . " " . $p['partLName'] . "<br>";
}