<?php
// add_student.php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $group = $_POST['group'];

    // Validation
    if (!is_numeric($student_id) || empty($name) || empty($group)) {
        $message = "Vérifiez vos données : ID numérique et champs obligatoires";
    } else {
        // JSON
        $json_file = 'students.json';
        $students = [];
        if (file_exists($json_file)) {
            $students = json_decode(file_get_contents($json_file), true);
        }
        $students[] = ["student_id" => $student_id, "name" => $name, "group" => $group];
        file_put_contents($json_file, json_encode($students, JSON_PRETTY_PRINT));

        // MySQL
        $stmt = $conn->prepare("INSERT INTO students (id, fullname, group_id) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $name, $group]);

        $message = "Étudiant ajouté avec succès !";
    }
}
?>

<h2>Ajouter un étudiant</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<form method="post">
    Student ID: <input type="text" name="student_id" required><br><br>
    Name: <input type="text" name="name" required><br><br>
    Group: <input type="text" name="group" required><br><br>
    <button type="submit">Ajouter</button>
</form>
