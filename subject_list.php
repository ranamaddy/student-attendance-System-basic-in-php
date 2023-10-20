<?php
// Include database connection file
include('config.php');

// Retrieve subject data
$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);
$subjects = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
// Include menu file
include('menu.php');

// Check for status message
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'added') {
        echo '<div class="alert alert-success">Subject added successfully.</div>';
    } else if ($_GET['status'] == 'deleted') {
        echo '<div class="alert alert-success">Subject deleted successfully.</div>';
    } else if ($_GET['status'] == 'updated') {
        echo '<div class="alert alert-success">Subject updated successfully.</div>';
    }
}
?>

<h1>Subject List</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Subject Name</th>
            
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($subjects as $subject) : ?>
            <tr>
                <td><?php echo $subject['subject_name']; ?></td>
                
                <td>
                    <a href="edit_subject.php?id=<?php echo $subject['subject_id']; ?>" class="btn btn-primary">Edit</a>
                    <a href="delete_subject.php?id=<?php echo $subject['subject_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="addsubject.php" class="btn btn-primary">Add Subject</a>
</div>
</body>
</html>
