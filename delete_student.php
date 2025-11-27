<?php
require 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // MySQL delete
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->execute([$id]);

    // JSON delete
    if (file_exists('students.json')) {
        $json_students = json_decode(file_get_contents('students.json'), true);
        $json_students = array_filter($json_students, fn($s) => $s['student_id'] != $id);
        file_put_contents('students.json', json_encode(array_values($json_students), JSON_PRETTY_PRINT));
    }

    echo "Étudiant supprimé !";
} else {
    echo "ID manquant.";
}
?>
