<?php
require 'db_connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = "";

// Récupérer l’étudiant à modifier via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // MySQL
    $stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // JSON
    $json_students = [];
    if (file_exists('students.json')) {
        $json_students = json_decode(file_get_contents('students.json'), true);
    }
}

// Soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['student_id'];
    $name = $_POST['name'];
    $group = $_POST['group'];

    // MySQL update
    $stmt = $conn->prepare("UPDATE students SET fullname=?, group_id=? WHERE id=?");
    $stmt->execute([$name, $group, $id]);

    // JSON update
    if (file_exists('students.json')) {
        $json_students = json_decode(file_get_contents('students.json'), true);
        foreach ($json_students as &$s) {
            if ($s['student_id'] == $id) {
                $s['name'] = $name;
                $s['group'] = $group;
                break;
            }
        }
        file_put_contents('students.json', json_encode($json_students, JSON_PRETTY_PRINT));
    }

    $message = "Étudiant mis à jour !";
}

?>

<h2>Mettre à jour un étudiant</h2>
<?php if($message) echo "<p>$message</p>"; ?>

<form method="post">
Student ID: <input type="text" name="student_id" value="<?php echo $student['id'] ?? ''; ?>" readonly><br><br>
Name: <input type="text" name="name" value="<?php echo $student['fullname'] ?? ''; ?>"><br><br>
Group: <input type="text" name="group" value="<?php echo $student['group_id'] ?? ''; ?>"><br><br>
<button type="submit">Mettre à jour</button>
</form>
