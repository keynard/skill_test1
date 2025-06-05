<?php
require_once 'db.php';

// Register Participant to Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerParticipant'])) {
    $partID = $_POST['partID'];
    $evCode = $_POST['evCode'];
    $regPMode = $_POST['regPMode'];
    $regDate = date('Y-m-d');

    // Get event fee and participant discount
    $stmt = $pdo->prepare("SELECT evRFee FROM events WHERE evCode = ?");
    $stmt->execute([$evCode]);
    $event = $stmt->fetch();

    $stmt2 = $pdo->prepare("SELECT partDRate FROM participants WHERE partID = ?");
    $stmt2->execute([$partID]);
    $participant = $stmt2->fetch();

    if ($event && $participant) {
        $regFeePaid = $event['evRFee'] - $participant['partDRate'];
        if ($regFeePaid < 0) $regFeePaid = 0;

        // Insert registration
        $stmt3 = $pdo->prepare("INSERT INTO registration (partID, evCode, regDate, regFeePaid, regPMode) VALUES (?, ?, ?, ?, ?)");
        $stmt3->execute([$partID, $evCode, $regDate, $regFeePaid, $regPMode]);

        echo "Participant registered successfully.<br><a href='../public/registration.html'>Back</a>";
    } else {
        echo "Invalid Participant ID or Event Code.<br><a href='../public/registration.html'>Back</a>";
    }
    exit;
}

// View All Registrations
if (isset($_GET['viewAll'])) {
    $stmt = $pdo->query(
        "SELECT r.regCode, r.regDate, r.regFeePaid, r.regPMode, 
                p.partFName, p.partLName, e.evName
        FROM registration r
        JOIN participants p ON r.partID = p.partID
        JOIN events e ON r.evCode = e.evCode
        ORDER BY r.regDate DESC"
    );
    echo "<h3>All Registration Transactions</h3>
    <table border='1'>
        <tr>
            <th>Reg Code</th>
            <th>Participant Name</th>
            <th>Event Name</th>
            <th>Reg Date</th>
            <th>Fee Paid</th>
            <th>Payment Mode</th>
        </tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td>{$row['regCode']}</td>
            <td>{$row['partFName']} {$row['partLName']}</td>
            <td>{$row['evName']}</td>
            <td>{$row['regDate']}</td>
            <td>{$row['regFeePaid']}</td>
            <td>{$row['regPMode']}</td>
        </tr>";
    }
    echo "</table><br><a href='../public/registration.html'>Back</a>";
    exit;
}

// Default: redirect to form
header("Location: ../public/registration.html");
exit;