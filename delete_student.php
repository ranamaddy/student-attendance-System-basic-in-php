<?php
// Include database connection file
include('config.php');

// Get student ID from URL parameter
$studentId = $_GET['id'];

// Check if student ID is set and is numeric
if (isset($studentId) && is_numeric($studentId)) {
    // Prepare and execute SQL query to delete student
    $sql = "DELETE FROM students WHERE student_id  = $studentId";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to student list with success message
        header('Location: index.php?status=deleted');
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting student: ' . mysqli_error($conn) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid student ID</div>';
}
?>
