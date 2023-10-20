<?php
// Include database connection file
include('config.php');

// Get attendance date from URL parameter
if (isset($_GET['attendance_date'])) {
    $attendanceDate = $_GET['attendance_date'];
} else {
    $attendanceDate = "2023-10-20";
}

// Check if attendance date is set and is valid
if (isset($attendanceDate) && !empty($attendanceDate)) {
    // Validate attendance date format
    if (date('Y-m-d', strtotime($attendanceDate)) != $attendanceDate) {
        echo '<div class="alert alert-danger">Invalid attendance date format</div>';
    } else {
        // Retrieve attendance records for the selected date
        $sql = "SELECT s.name, s.roll_number, ar.attendance_date, ar.status, ar.remarks, ar.attendance_id, ar.student_id
                FROM attendance_records ar
                JOIN students s ON ar.student_id = s.student_id
                WHERE ar.attendance_date = '$attendanceDate'";
        $result = mysqli_query($conn, $sql);
        $attendanceRecords = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>View Attendance</h1>

<?php if (isset($attendanceRecords)) { ?>
<form action="" method="get">
<div class="form-group">
<label for="attendance_date">Select Attendance Date:</label>
<input type="date" class="form-control" id="attendance_date" name="attendance_date" value="<?php echo $attendanceDate; ?>">
</div>
<button type="submit" class="btn btn-primary">View Attendance</button>
</form>

<table class="table table-striped">
<thead>
<tr>
<th>Student Name</th>
<th>Roll Number</th>
<th>Attendance Date</th>
<th>Attendance Status</th>
<th>Remarks</th>
</tr>
</thead>
<tbody>
<?php foreach ($attendanceRecords as $attendanceRecord) : ?>
<tr>
<td><?php echo $attendanceRecord['name']; ?></td>
<td><?php echo $attendanceRecord['roll_number']; ?></td>
<td><?php echo $attendanceRecord['attendance_date']; ?></td>
<td>
<select name="attendance_status[<?php echo $attendanceRecord['student_id']; ?>]">
<option value="P" <?php if ($attendanceRecord['status'] == 'P') echo 'selected'; ?>>Present</option>
<option value="A" <?php if ($attendanceRecord['status'] == 'A') echo 'selected'; ?>>Absent</option>
<option value="E" <?php if ($attendanceRecord['status'] == 'E') echo 'selected'; ?>>Excused</option>
</select>
</td>
<td>
<input type="text" class="form-control" name="attendance_remarks[<?php echo $attendanceRecord['student_id']; ?>]" value="<?php echo $attendanceRecord['remarks']; ?>">
</td
</tr>
<?php endforeach; ?>
</tbody>
</table>

<form action="" method="post">
<div class="form-group">
<label for="bulk_attendance_status">Select Attendance Status for All:</label>
<select name="bulk_attendance_status" id="bulk_attendance_status">
<option value="">Select Status</option>
<option value="P">Present</option>
<option value="A">Absent</option>
<option value="E">Excused</option>
</select>
</div>
<button type="submit" class="btn btn-primary" name="update_all_attendance">Update All Attendance</button>
</form>

<?php } ?>

</div>
</body>
</html>

<?php } else {
echo '<div class="alert alert-danger">Please select an attendance date</div>';
}

// Check if bulk attendance update is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_all_attendance'])) {
$bulkAttendanceStatus = $_POST['bulk_attendance_status'];

// Validate attendance status
if (in_array($bulkAttendanceStatus, ['P', 'A', 'E'])) {
// Update all attendance records
$sql = "UPDATE attendance_records SET status = '$bulkAttendanceStatus' WHERE attendance_date = '$attendanceDate'";
mysqli_query($conn, $sql);

// Redirect to attendance page with success message
header('Location: viewattendance.php?attendance_date=' . $attendanceDate . '&status=updated_all');
exit();
} else {
echo '<div class="alert alert-danger">Invalid attendance status</div>';
}
}
?>
