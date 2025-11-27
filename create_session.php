<?php
require 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $group_id = $_POST['group_id'];
    $professor_id = $_POST['professor_id'];
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO attendance_sessions (course_id, group_id, date, opened_by, status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$course_id, $group_id, $date, $professor_id, 'open']);

    echo "Session créée avec succès ! ID: " . $conn->lastInsertId();
}
?>

<h2>Créer une session</h2>
<form method="post">
Course ID: <input type="text" name="course_id" required><br><br>
Group ID: <input type="text" name="group_id" required><br><br>
Professor ID: <input type="text" name="professor_id" required><br><br>
<button type="submit">Créer session</button>
</form>
