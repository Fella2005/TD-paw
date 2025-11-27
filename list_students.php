<?php
// list_students.php
require 'db_connect.php';

echo "<h2>Liste des étudiants (MySQL)</h2>";
$stmt = $conn->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Nom</th><th>Groupe</th></tr>";
foreach ($students as $s) {
    echo "<tr><td>{$s['id']}</td><td>{$s['fullname']}</td><td>{$s['group_id']}</td></tr>";
}
echo "</table>";

echo "<h2>Liste des étudiants (JSON)</h2>";
if (file_exists('students.json')) {
    $json_students = json_decode(file_get_contents('students.json'), true);
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Groupe</th></tr>";
    foreach ($json_students as $s) {
        echo "<tr><td>{$s['student_id']}</td><td>{$s['name']}</td><td>{$s['group']}</td></tr>";
    }
    echo "</table>";
}
?>
