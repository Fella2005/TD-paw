<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'db_connect.php';

echo "<h2>Test de connexion</h2>";

// Test MySQL
try {
    $stmt = $conn->query("SELECT 1");
    echo "MySQL: OK<br>";
} catch (Exception $e) {
    echo "MySQL: Erreur - " . $e->getMessage() . "<br>";
}

// Test JSON
$json_file = 'students.json';
if (file_exists($json_file)) {
    echo "JSON: OK<br>";
} else {
    echo "JSON: Le fichier n'existe pas (OK si tu n'as pas encore ajouté d'étudiant)<br>";
}
?>
