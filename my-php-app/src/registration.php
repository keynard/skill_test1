
<?php
require 'db.php';

// Example: Fetch all registrations
$stmt = $pdo->query("SELECT * FROM registration");
$regs = $stmt->fetchAll();

foreach ($regs as $r) {
    echo "Reg Code: " . $r['regCode'] . "<br>";
}