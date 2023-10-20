<?php
// Include database connection file
include('config.php');

// Get subject ID from URL parameter
$subjectId = $_GET['id'];

// Check if subject ID is set and is numeric
if (isset($subjectId) && is_numeric($subjectId)) {
    // Prepare and execute SQL query to delete subject
    $sql = "DELETE FROM subjects WHERE subject_id = $subjectId";
    if (mysqli_query($conn, $sql)) {
        // Redirect back to subject list with success message
        header('Location: subject_list.php?status=deleted');
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting subject: ' . mysqli_error($conn) . '</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid subject ID</div>';
}
?>
