
<?php
require_once 'db.php';

// Add Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addEvent'])) {
    $evName = $_POST['evName'];
    $evDate = $_POST['evDate'];
    $evVenue = $_POST['evVenue'];
    $evRFee = $_POST['evRFee'];

    $stmt = $pdo->prepare("INSERT INTO events (evName, evDate, evVenue, evRFee) VALUES (?, ?, ?, ?)");
    $stmt->execute([$evName, $evDate, $evVenue, $evRFee]);
    echo "Event added successfully.<br><a href='../public/events.html'>Back</a>";
    exit;
}

// Update Event
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateEvent'])) {
    $evCode = $_POST['evCode'];
    $evName = $_POST['evName'];
    $evDate = $_POST['evDate'];
    $evVenue = $_POST['evVenue'];
    $evRFee = $_POST['evRFee'];

    $stmt = $pdo->prepare("UPDATE events SET evName=?, evDate=?, evVenue=?, evRFee=? WHERE evCode=?");
    $stmt->execute([$evName, $evDate, $evVenue, $evRFee, $evCode]);
    echo "Event updated successfully.<br><a href='../public/events.html'>Back</a>";
    exit;
}

// Search Event (show update form)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['searchEvent'])) {
    $evCode = $_GET['evCode'];
    $stmt = $pdo->prepare("SELECT * FROM events WHERE evCode = ?");
    $stmt->execute([$evCode]);
    $event = $stmt->fetch();
    if ($event) {
        echo "<h3>Edit Event</h3>
        <form action='../src/events.php' method='POST'>
            <input type='hidden' name='evCode' value='{$event['evCode']}'>
            <label>Event Name:</label>
            <input type='text' name='evName' value='{$event['evName']}' required><br>
            <label>Event Date:</label>
            <input type='date' name='evDate' value='{$event['evDate']}' required><br>
            <label>Event Venue:</label>
            <input type='text' name='evVenue' value='{$event['evVenue']}' required><br>
            <label>Registration Fee:</label>
            <input type='number' step='0.01' name='evRFee' value='{$event['evRFee']}' required><br>
            <button type='submit' name='updateEvent'>Update Event</button>
        </form>
        <br><a href='../public/events.html'>Back</a>";
    } else {
        echo "Event not found.<br><a href='../public/events.html'>Back</a>";
    }
    exit;
}

// Delete Event
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['deleteEvent'])) {
    $evCode = $_GET['evCode'];
    $stmt = $pdo->prepare("DELETE FROM events WHERE evCode = ?");
    $stmt->execute([$evCode]);
    echo "Event deleted (if existed).<br><a href='../public/events.html'>Back</a>";
    exit;
}

// View All Events
if (isset($_GET['viewAll'])) {
    $stmt = $pdo->query("SELECT * FROM events ORDER BY evDate DESC");
    echo "<h3>All Events</h3><table border='1'><tr><th>Code</th><th>Name</th><th>Date</th><th>Venue</th><th>Fee</th></tr>";
    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td>{$row['evCode']}</td>
            <td>{$row['evName']}</td>
            <td>{$row['evDate']}</td>
            <td>{$row['evVenue']}</td>
            <td>{$row['evRFee']}</td>
        </tr>";
    }
    echo "</table><br><a href='../public/events.html'>Back</a>";
    exit;
}

// Default: redirect to form
header("Location: ../public/events.html");
exit;