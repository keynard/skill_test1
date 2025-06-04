
<?php
require 'db.php';

// Example: Fetch all events
$stmt = $pdo->query("SELECT * FROM events");
$events = $stmt->fetchAll();

foreach ($events as $event) {
    echo $event['evName'] . "<br>";
}