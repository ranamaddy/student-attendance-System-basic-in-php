<?php
// Include database connection file
include('config.php');

// Get subject ID from URL parameter
$subjectId = $_GET['id'];

// Check if subject ID is set and is numeric
if (isset($subjectId) && is_numeric($subjectId)) {
    // Retrieve subject data from database
    $sql = "SELECT * FROM subjects WHERE subject_id = $subjectId";
    $result = mysqli_query($conn, $sql);
    $subject = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate user input
        $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
        

        // Check for empty fields
        if (empty($subject_name) ) {
            echo '<div class="alert alert-danger">Please fill in all required fields.</div>';
        } else {
            // Update subject data in database
            $sql = "UPDATE subjects SET subject_name = '$subject_name' WHERE subject_id = $subjectId";
            if (mysqli_query($conn, $sql)) {
                // Redirect back to subject list with success message
                header('Location: subject_list.php?status=updated');
                exit();
            } else {
                echo '<div class="alert alert-danger">Error updating subject: ' . mysqli_error($conn) . '</div>';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
include('menu.php');
?>
<h1>Edit Subject</h1>

<form action="" method="post">
    <div class="mb-3">
        <label for="subject_name" class="form-label">Subject Name</label>
        <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo $subject['subject_name']; ?>" required>
    </div>

    

    <button type="submit" class="btn btn-primary">Update Subject</button>
</form>
</div>
</body>
</html>
<?php } else {
echo '<div class="alert alert-danger">Invalid subject ID</div>';
} ?>
