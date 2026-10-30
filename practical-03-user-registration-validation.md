# Practical 03: User Registration with Validation

## Aim
To create a user registration form in PHP with robust server-side data validation for name, email, and password fields.

## Objective
To master server-side input validation techniques, string sanitization using `trim()`, and email format checking with `filter_var()`.

## System Requirements
- **Software:** XAMPP / WAMP Server, PHP 8.x, Web Browser, Code Editor.

## Theory & Logic
Client-side HTML5 validation can be easily disabled or bypassed using browser developer tools or direct HTTP requests. Therefore, **server-side validation** is mandatory for application security.
Key PHP functions used:
1. `trim()`: Removes leading and trailing whitespace to prevent space-only inputs.
2. `empty()`: Determines if a variable is uninitialized or holds a falsy value.
3. `filter_var($email, FILTER_VALIDATE_EMAIL)`: Built-in PHP filter validating email syntax according to RFC standards.
4. `strlen()`: Counts string length to enforce minimum character thresholds.

## Lab Setup & Procedure
1. Create a project file `register.php` inside `C:\xampp\htdocs\lab\`.
2. Construct an HTML form submitting via POST.
3. Implement PHP processing logic checking form submission.
4. Collect validation failure messages inside an array `$errors`.
5. Render success message if `$errors` is empty, or loop through error messages in red text.

## Algorithm
1. Render HTML form with fields: `name`, `email`, `pass`.
2. Upon POST submission, extract inputs and apply `trim()` to `name`.
3. Initialize an empty array `$errors = []`.
4. Validation checks:
   - If `strlen($name) < 3`: Append "Name too short." to `$errors`.
   - If `!filter_var($email, FILTER_VALIDATE_EMAIL)`: Append "Invalid Email format." to `$errors`.
   - If `strlen($pass) < 6`: Append "Password must be 6+ chars." to `$errors`.
5. If `empty($errors)` is true, print "Registration Successful!" in green text.
6. Else, iterate through `$errors` using `foreach` and print each error message in red text.

## Source Code (`register.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
<h2>User Registration Form</h2>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pass = $_POST['pass'];
    $errors = [];

    if (strlen($name) < 3) {
        $errors[] = "Name too short (minimum 3 characters).";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email format.";
    }
    if (strlen($pass) < 6) {
        $errors[] = "Password must be 6+ chars.";
    }

    if (empty($errors)) {
        echo "<p style='color:green; font-weight:bold;'>Registration Successful!</p>";
    } else {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
    }
}
?>

<form method="post">
    Name: <input type="text" name="name"><br><br>
    Email: <input type="text" name="email"><br><br>
    Pass: <input type="password" name="pass"><br><br>
    <input type="submit" value="Register">
</form>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `trim($_POST['name'])` | Strips extra whitespace from beginning and end of name string. |
| `$errors = [];` | Array initialized to store dynamic validation failure messages. |
| `strlen($name) < 3` | Checks string length against required threshold. |
| `filter_var(..., FILTER_VALIDATE_EMAIL)` | Validates email syntax against standard specifications. |
| `empty($errors)` | Evaluates to true if no validation rules failed. |
| `foreach($errors as $err)` | Iterates and displays all error messages sequentially. |

## Expected Output & Test Cases
| Test Case # | Submitted Inputs | Expected Result / Output |
| :---: | :--- | :--- |
| **1** | Name: "Al", Email: "al@example.com", Pass: "secret1" | Red Text: "Name too short (minimum 3 characters)." |
| **2** | Name: "Rahul", Email: "rahul.com", Pass: "secret1" | Red Text: "Invalid Email format." |
| **3** | Name: "Rahul", Email: "rahul@example.com", Pass: "123" | Red Text: "Password must be 6+ chars." |
| **4** | Name: "Ra", Email: "abc", Pass: "12" | Red Text: All 3 error messages displayed together |
| **5** | Name: "Rahul", Email: "rahul@example.com", Pass: "secret1" | Green Text: "Registration Successful!" |

## Viva Questions & Answers
**Q1. Why is server-side validation mandatory even when HTML5 client-side validation is active?**  
*Ans:* Client-side checks can easily be bypassed, modified, or disabled in browsers. Server-side validation guarantees data integrity before accepting inputs.

**Q2. What is the role of `filter_var()` in PHP?**  
*Ans:* It provides built-in filtering and validation capabilities for common patterns like emails, URLs, IP addresses, and integers.

**Q3. How do `empty()` and `isset()` differ?**  
*Ans:* `isset()` checks whether a variable exists and is not `NULL`. `empty()` checks whether a variable is unset or contains a falsy value (e.g., `""`, `0`, `NULL`, `false`, `[]`).

**Q4. Why should user passwords never be stored as plain text?**  
*Ans:* Plain text storage exposes user credentials during database breaches; passwords should always be hashed securely using `password_hash()` and verified with `password_verify()`.

**Q5. What function does `trim()` perform?**  
*Ans:* It strips whitespace (spaces, tabs, newlines) from the beginning and end of a string.
