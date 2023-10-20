<?php
// Include database connection file
include('config.php');

// Get student ID from URL parameter
$studentId = $_GET['id'];

// Check if student ID is set and is numeric
if (isset($studentId) && is_numeric($studentId)) {
    // Retrieve student data from database
    $sql = "SELECT * FROM students WHERE student_id  = $studentId";
    $result = mysqli_query($conn, $sql);
    $student = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate user input
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $roll_number = mysqli_real_escape_string($conn, $_POST['roll_number']);
        $class = mysqli_real_escape_string($conn, $_POST['class']);
        $section = mysqli_real_escape_string($conn, $_POST['section']);
        $admission_number = mysqli_real_escape_string($conn, $_POST['admission_number']);

        // Check for empty fields
        if (empty($name) || empty($roll_number) || empty($class) || empty($section) || empty($admission_number)) {
            echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
        } else {
            // Update student data in database
            $sql = "UPDATE students SET name = '$name', roll_number = '$roll_number', class = '$class', section = '$section', admission_number = '$admission_number' WHERE student_id  = $studentId";
            if (mysqli_query($conn, $sql)) {
                // Redirect back to student list with success message
                header('Location: index.php?status=updated');
                exit();
            } else {
                echo '<div class="alert alert-danger">Error updating student: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
include('menu.php');
?>
<h1>Edit Student</h1>

<form action="" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Student Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo $student['name']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="roll_number" class="form-label">Roll Number</label>
        <input type="text" class="form-control" id="roll_number" name="roll_number" value="<?php echo $student['roll_number']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="class" class="form-label">Class</label>
        <input type="text" class="form-control" id="class" name="class" value="<?php echo $student['class']; ?>" required>
    </div>

    <div class="mb-3">
        <label for="section" class="form-label">Section</label>
        <input type="text" class="form-control" id="section" name="section" value="<?php echo $student['section']; ?>" required>
    </div>

    <div class="mb-3">
    <label for="admission_number" class="form-label">Admission Number</label>
<input type="text" class="form-control" id="admission_number" name="admission_number" value="<?php echo $student['admission_number']; ?>" required>
</div>

<button type="submit" class="btn btn-primary">Update Student</button>
</form>
</div>
</body>
</html>
<?php } else {
echo '<div class="alert alert-danger">Invalid student ID</div>';
} ?>
