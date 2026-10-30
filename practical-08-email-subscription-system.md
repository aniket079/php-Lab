# Practical 08: Email Subscription System

## Aim
To design a PHP subscription application that collects user email addresses, checks for duplicates, and appends unique emails to a text file.

## Objective
To implement string searching within files (`strpos`), understand strict comparison operators (`!==`), and use file append flags (`FILE_APPEND`).

## System Requirements
- **Software:** XAMPP / WAMP Server, PHP 7.4+, Text Editor, Web Browser.

## Theory & Logic
To prevent duplicate subscriptions, the application reads existing file content before writing new entries.
Key concepts:
1. `file_get_contents()`: Retrieves current subscribed emails list from `emails.txt`.
2. `strpos($content, $email)`: Searches for substring occurrences. Strict comparison `!== false` is required because position `0` (match at start) evaluates as falsy in loose checks.
3. `FILE_APPEND`: Flag used with `file_put_contents()` to append data without overwriting existing contents.
4. `PHP_EOL`: Constant providing operating system-independent newline character.

## Lab Setup & Procedure
1. Create `subscribe.php` in `htdocs/lab/`.
2. Form accepts user email input via POST.
3. Script reads `emails.txt`, performs duplicate check, and appends unique email with newline.

## Algorithm
1. Render HTML form accepting `user_email` input.
2. Upon submit, extract email and define `$filename = "emails.txt"`.
3. Check if file exists: If yes, read content via `file_get_contents()`; else set `$current_emails = ""`.
4. Perform duplicate check: `strpos($current_emails, $email) !== false`.
   - If true: Display error "Error: You are already subscribed!".
   - If false: Append email using `file_put_contents($filename, $email . PHP_EOL, FILE_APPEND)` and display "Success! Email added to our list.".

## Source Code (`subscribe.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title>Email Subscription System</title>
</head>
<body>
<h2>Newsletter Subscription</h2>

<form method="post">
    Subscribe Email: <input type="email" name="user_email" required>
    <input type="submit" value="Join Newsletter">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['user_email']);
    $filename = "emails.txt";

    $current_emails = file_exists($filename) ? file_get_contents($filename) : "";

    if (strpos($current_emails, $email) !== false) {
        echo "<p style='color:red;'>Error: You are already subscribed!</p>";
    } else {
        file_put_contents($filename, $email . PHP_EOL, FILE_APPEND);
        echo "<p style='color:green;'>Success! Email added to our list.</p>";
    }
}
?>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `type="email"` | Performs client-side email format validation in modern browsers. |
| Ternary Operator `? :` | Concisely checks file existence and assigns file content or empty string. |
| `strpos(...) !== false` | Searches for email string inside existing file content using strict type comparison. |
| `PHP_EOL` | Inserts OS-appropriate line break to keep one email per line. |
| `FILE_APPEND` | Appends text content to file end without overwriting existing data. |

## Expected Output & Test Cases
| Test Case # | Input Email | Expected Output | File Status (`emails.txt`) |
| :---: | :--- | :--- | :--- |
| **1** | `ravi@example.com` (First time) | "Success! Email added to our list." | Contains `ravi@example.com` |
| **2** | `ravi@example.com` (Second time) | "Error: You are already subscribed!" | Unchanged |
| **3** | `meena@example.com` | "Success! Email added to our list." | Contains both emails on separate lines |

## Viva Questions & Answers
**Q1. Why is strict operator `!==` required when evaluating `strpos()`?**  
*Ans:* `strpos()` returns `0` if the string match is found at index zero. In loose comparison (`!=`), `0` coerces to `false`, causing false duplicate checks.

**Q2. What is the function of `FILE_APPEND` in `file_put_contents()`?**  
*Ans:* It instructs PHP to append new string data to the end of the file instead of clearing existing contents.

**Q3. What is a key limitation of using `strpos()` for email duplicate checking?**  
*Ans:* `strpos()` checks substring inclusion; thus, searching for `a@x.com` would falsely trigger a duplicate match if `aa@x.com` is already present. Exact line-by-line comparison (`file()`) is more accurate.

**Q4. What purpose does `PHP_EOL` serve?**  
*Ans:* It inserts the standard End-Of-Line character for the host operating system (`\n` on Linux/macOS, `\r\n` on Windows).

**Q5. Should email inputs be validated on the server side?**  
*Ans:* Yes; browser-level `type="email"` checks can be bypassed, so `filter_var($email, FILTER_VALIDATE_EMAIL)` should always be enforced on the server.
