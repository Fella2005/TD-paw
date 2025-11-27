<?php
// take_attendance.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$students_file = 'students.json';
$today = date('Y-m-d');
$attendance_file = "attendance_$today.json";
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists($attendance_file)) {
        $message = "Attendance for today has already been taken.";
    } else {
        $attendance = [];
        foreach ($_POST['status'] as $id => $stat) {
            $attendance[] = ["student_id" => $id, "status" => $stat];
        }
        file_put_contents($attendance_file, json_encode($attendance, JSON_PRETTY_PRINT));
        $message = "Présence enregistrée pour $today";
    }
}

// Load students
$students = [];
if (file_exists($students_file)) {
    $students = json_decode(file_get_contents($students_file), true);
}
?>

<h2>Prendre la présence (<?php echo $today; ?>)</h2>
<?php if($message) echo "<p>$message</p>"; ?>
<form method="post">
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Nom</th><th>Présent</th><th>Absent</th></tr>
<?php foreach($students as $s): ?>
<tr>
    <td><?php echo $s['student_id']; ?></td>
    <td><?php echo $s['name']; ?></td>
    <td><input type="radio" name="status[<?php echo $s['student_id']; ?>]" value="present" required></td>
    <td><input type="radio" name="status[<?php echo $s['student_id']; ?>]" value="absent"></td>
</tr>
<?php endforeach; ?>
</table>
<br>
<button type="submit">Enregistrer la présence</button>
</form>
