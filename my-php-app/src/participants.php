<?php
require_once 'db.php';

// Add Participant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addParticipant'])) {
    $partFName = $_POST['partFName'];
    $partLName = $_POST['partLName'];
    $partDRate = $_POST['partDRate'];

    $stmt = $pdo->prepare("INSERT INTO participants (partFName, partLName, partDRate) VALUES (?, ?, ?)");
    $stmt->execute([$partFName, $partLName, $partDRate]);
    echo "Participant added successfully.<br><a href='../public/participants.html'>Back</a>";
    exit;
}

// Search Participant
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['searchParticipant'])) {
    $partID = $_GET['partID'];
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE partID = ?");
    $stmt->execute([$partID]);
    $participant = $stmt->fetch();
    if ($participant) {
        echo "<h3>Participant Found:</h3>";
        echo "ID: {$participant['partID']}<br>Name: {$participant['partFName']} {$participant['partLName']}<br>Discount Rate: {$participant['partDRate']}<br>";
    } else {
        echo "Participant not found.<br>";
    }
    echo "<a href='../public/participants.html'>Back</a>";
    exit;
}

// Delete Participant
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['deleteParticipant'])) {
    $partID = $_GET['partID'];
    $stmt = $pdo->prepare("DELETE FROM participants WHERE partID = ?");
    $stmt->execute([$partID]);
    echo "Participant deleted (if existed).<br><a href='../public/participants.html'>Back</a>";
    exit;
}

// View All Participants
if (isset($_GET['viewAll'])) {
    $stmt = $pdo->query("SELECT * FROM participants ORDER BY partID DESC");
    echo "<h3>All Participants</h3><table border='1'><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Discount Rate</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td>{$row['partID']}</td>
            <td>{$row['partFName']}</td>
            <td>{$row['partLName']}</td>
            <td>{$row['partDRate']}</td>
        </tr>";
    }
    echo "</table><br><a href='../public/participants.html'>Back</a>";
    exit;
}

// Default: redirect to form
header("Location: ../public/participants.html");
exit;