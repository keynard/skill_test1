<?php
require_once 'db.php';

// 1. Filter Registrations by Event Name
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filterRegistrations'])) {
    $evName = $_GET['evName'];
    $stmt = $pdo->prepare(
        "SELECT e.evName, CONCAT(p.partFName, ' ', p.partLName) AS fullName, r.regDate, r.regFeePaid
         FROM registration r
         JOIN participants p ON r.partID = p.partID
         JOIN events e ON r.evCode = e.evCode
         WHERE e.evName LIKE ?
         ORDER BY r.regDate DESC"
    );
    $stmt->execute(['%' . $evName . '%']);
    echo "<h3>Registrations for Event: " . htmlspecialchars($evName) . "</h3>
    <table border='1'>
        <tr>
            <th>Event Name</th>
            <th>Participant's Full Name</th>
            <th>Registration Date</th>
            <th>Registration Fee Paid</th>
        </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td>{$row['evName']}</td>
            <td>{$row['fullName']}</td>
            <td>{$row['regDate']}</td>
            <td>{$row['regFeePaid']}</td>
        </tr>";
    }
    echo "</table><br><a href='../public/monitoring.html'>Back</a>";
    exit;
}

// 2. Count Records
if (isset($_GET['count'])) {
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM registration");
    $row = $stmt->fetch();
    echo "<h3>Total Number of Registration Records: {$row['total']}</h3>";
    echo "<a href='../public/monitoring.html'>Back</a>";
    exit;
}

// 3. Sum Registration Fees
if (isset($_GET['sum'])) {
    $stmt = $pdo->query("SELECT SUM(regFeePaid) AS totalFees FROM registration");
    $row = $stmt->fetch();
    echo "<h3>Total Registration Fees Paid: {$row['totalFees']}</h3>";
    echo "<a href='../public/monitoring.html'>Back</a>";
    exit;
}

// 4. Total Discounts
if (isset($_GET['discounts'])) {
    // a = number of registrations, b = sum(regFeePaid), evRFee = event fee
    $stmt = $pdo->query(
        "SELECT SUM(e.evRFee) AS totalEventFees, SUM(r.regFeePaid) AS totalPaid, COUNT(*) AS regCount
         FROM registration r
         JOIN events e ON r.evCode = e.evCode"
    );
    $row = $stmt->fetch();
    $totalDiscounts = $row['totalEventFees'] - $row['totalPaid'];
    echo "<h3>Total Amount of Discounts: {$totalDiscounts}</h3>";
    echo "<a href='../public/monitoring.html'>Back</a>";
    exit;
}

// Default: redirect to form
header("Location: ../public/monitoring.html");
exit;