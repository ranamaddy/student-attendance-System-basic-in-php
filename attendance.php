<?php
// Include database connection file
include('config.php');

// Check if attendance has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve all students
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Process attendance data
    foreach ($students as $student) {
        $studentId = $student['student_id'];
        $attendanceStatus = $_POST['attendance'][$studentId];

        // Validate attendance status
        if (in_array($attendanceStatus, ['P', 'A', 'E'])) {
            // Insert attendance record into database
            $sql = "INSERT INTO attendance_records (student_id, attendance_date, status, remarks) VALUES ($studentId, CURDATE(), '$attendanceStatus', '')";
            mysqli_query($conn, $sql);
        }
    }

    // Redirect to attendance page with success message
    header('Location: attendance.php?status=marked');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <?php
    include('menu.php');
    ?>
<h1>Daily Attendance - All Students</h1>

<?php if (isset($_GET['status']) && $_GET['status'] == 'marked') {
echo '<div class="alert alert-success">Attendance marked successfully.</div>';
} ?>

<form action="" method="post">
<table class="table table-striped">
<thead>
<tr>
<th>Student Name</th>
<th>Roll Number</th>
<th>Attendance</th>
</tr>
</thead>
<tbody>
<?php
// Retrieve all students
$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);
$students = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($students as $student) : ?>
<tr>
<td><?php echo $student['name']; ?></td>
<td><?php echo $student['roll_number']; ?></td>
<td>
<select name="attendance[<?php echo $student['student_id']; ?>]">
<option value="P">Present</option>
<option value="A">Absent</option>
<option value="E">Excused</option>
</select>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<button type="submit" class="btn btn-primary">Submit Attendance</button>
</form>
</div>
</body>
</html>
