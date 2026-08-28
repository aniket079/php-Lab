<?php

include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $course = trim($_POST["course"]);

    if (
        empty($name) ||
        empty($email) ||
        empty($course)
    ) {
        $message = "All fields are required.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email address.";
    }
    else {

        $sql = "INSERT INTO students
                (name, email, course)
                VALUES (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $name,
            $email,
            $course
        );

        if (mysqli_stmt_execute($stmt)) {
            $message = "Student added successfully!";
        } else {
            $message = "Something went wrong.";
        }

        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Student</title>
</head>

<body>

<h1>Add Student</h1>

<p><?php echo $message; ?></p>

<form method="POST">

    <input
        type="text"
        name="name"
        placeholder="Student Name"
    >

    <br><br>

    <input
        type="email"
        name="email"
        placeholder="Email"
    >

    <br><br>

    <input
        type="text"
        name="course"
        placeholder="Course"
    >

    <br><br>

    <button type="submit">
        Add Student
    </button>

</form>

<br>

<a href="index.php">View Students</a>

</body>

</html>