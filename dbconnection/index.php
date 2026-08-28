<?php

include "db.php";

$sql = "SELECT * FROM students";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Management</title>
</head>

<body>

<h1>Student Management System</h1>

<a href="add_student.php">
    Add New Student
</a>

<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Course</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($result)) { ?>

<tr>

    <td>
        <?php echo $row["id"]; ?>
    </td>

    <td>
        <?php echo $row["name"]; ?>
    </td>

    <td>
        <?php echo $row["email"]; ?>
    </td>

    <td>
        <?php echo $row["course"]; ?>
    </td>

</tr>

<?php } ?>

</table>

</body>

</html>