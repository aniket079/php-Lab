<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$name = "";
$email = "";
$age = "";
$message = "";
$errors = [];

// Check whether the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Read input safely
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $age = trim($_POST["age"] ?? "");

    // Validate name
    if ($name === "") {
        $errors[] = "Name is required.";
    } elseif (strlen($name) < 3) {
        $errors[] = "Name must contain at least 3 characters.";
    }

    // Validate email
    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validate age
    if ($age === "") {
        $errors[] = "Age is required.";
    } elseif (!filter_var($age, FILTER_VALIDATE_INT)) {
        $errors[] = "Age must be a valid integer.";
    } elseif ((int)$age < 16) {
        $errors[] = "Age must be at least 16.";
    }

    if (empty($errors)) {
        $message = "Form submitted successfully.";
    }
}

/*
|--------------------------------------------------------------------------
| htmlspecialchars()
|--------------------------------------------------------------------------
| Never directly print user input into HTML.
| It prevents user input from being interpreted as HTML or JavaScript.
|--------------------------------------------------------------------------
*/
// <a href="malcious.site">Aniket</a>
function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHP Form Handling</title>
</head>

<body>

<h1>Student Registration Form</h1>

<!-- <script>
    alert("Hello world");
    fetch().then(res=>res.data).then()
</script> -->
<?php
   
?>
<?php if (!empty($errors)): ?>

    <div style="color: red;">

        <h3>Please correct the following errors:</h3>
        
        <!-- <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul> -->
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= escape($error) ?></li>
            <?php endforeach; ?>
        </ul>

    </div>

<?php endif; ?>

<?php if ($message !== ""): ?>

    <p style="color: green;">
        <?= escape($message) ?>
    </p>

<?php endif; ?>

<form method="POST" action="">

    <label for="name">Name</label><br>

    <input
        type="text"
        id="name"
        name="name"
        value="<?= escape($name) ?>"
    >

    <br><br>

    <label for="email">Email</label><br>

    <input
        type="email"
        id="email"
        name="email"
        value="<?= escape($email) ?>"
    >

    <br><br>

    <label for="age">Age</label><br>

    <input
        type="number"
        id="age"
        name="age"
        value="<?= escape($age) ?>"
    >

    <br><br>

    <button type="submit">Register</button>

</form>

</body>

</html>