<?php
include('config.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body>
<div class="container">
<?php
include('menu.php');
if(isset($_GET['status']))
{ 
    $dis=$_GET['status'];
    echo '<div class="alert alert-success">Student  successfully  '.$dis.' </div>';
}
?>
    <h1>Student List</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Roll Number</th>
                <th>Class</th>
                <th>Section</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
          $result = mysqli_query($conn, "SELECT * FROM students");
                while ($student = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td><?php echo $student['roll_number']; ?></td>
                    <td><?php echo $student['class']; ?></td>
                    <td><?php echo $student['section']; ?></td>
                    <td>
                <a href="edit_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-primary">Edit</a>
                <a href="delete_student.php?id=<?php echo $student['student_id']; ?>" class="btn btn-danger">Delete</a>
            </td>
                </tr>
                <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
