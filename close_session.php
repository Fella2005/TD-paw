<?php
require 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $session_id = $_POST['session_id'];
    $stmt = $conn->prepare("UPDATE attendance_sessions SET status='closed' WHERE id=?");
    $stmt->execute([$session_id]);
    echo "Session fermée !";
}
?>

<h2>Fermer une session</h2>
<form method="post">
Session ID: <input type="text" name="session_id" required><br><br>
<button type="submit">Fermer session</button>
</form>
