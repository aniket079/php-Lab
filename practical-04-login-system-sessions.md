# Practical 04: Login System Using Sessions

## Aim
To implement a user login and authentication system in PHP utilizing session management for session persistence and page access control.

## Objective
To understand session lifecycle, `session_start()`, `$_SESSION` global array, and securing protected dashboard pages from unauthorized direct access.

## System Requirements
- **Software:** XAMPP (Apache + PHP 8.x), Web Browser, Text Editor.

## Theory & Logic
Because HTTP is stateless, servers cannot naturally retain user state across requests. Sessions solve this problem by assigning a unique Session ID stored in a client cookie (`PHPSESSID`), while mapping state data in server-side session memory.
Key functions:
1. `session_start()`: Initializes or resumes an existing session. Must be called before any HTML output.
2. `$_SESSION`: Superglobal associative array for persisting state variables across pages.
3. `session_destroy()`: Clears server-side session data during logout.

## Lab Setup & Procedure
1. Create three PHP files inside `htdocs/lab/`: `login.php`, `dashboard.php`, and `logout.php`.
2. On successful login in `login.php`, set `$_SESSION['logged_in'] = true` and redirect to `dashboard.php`.
3. In `dashboard.php`, verify session status. If unauthenticated, redirect immediately to `login.php`.
4. In `logout.php`, destroy session data and redirect back to `login.php`.

## Algorithm
1. **Login Page (`login.php`):**
   - Call `session_start()`.
   - Display login form with `user` and `pass` fields.
   - On submission, check credentials (e.g., `admin` / `password`).
   - If valid: set `$_SESSION['logged_in'] = true`, `$_SESSION['username'] = $user`, and execute `header("Location: dashboard.php")`.
   - Else: display "Invalid Login!".
2. **Dashboard Page (`dashboard.php`):**
   - Call `session_start()`.
   - Check if `!isset($_SESSION['logged_in'])`. If true, redirect to `login.php` and call `exit()`.
   - Display welcome banner and Logout link.
3. **Logout Page (`logout.php`):**
   - Call `session_start()`, `session_unset()`, and `session_destroy()`.
   - Redirect to `login.php`.

## Source Code

### 1. `login.php`
```php
<?php
session_start();

if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if ($user == "admin" && $pass == "password") {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $user;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Login!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>User Login</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    Username: <input type="text" name="user" required><br><br>
    Password: <input type="password" name="pass" required><br><br>
    <input type="submit" name="login" value="Sign In">
</form>
</body>
</html>
```

### 2. `dashboard.php`
```php
<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<p>You have successfully accessed the protected dashboard page.</p>
<a href="logout.php">Logout</a>
</body>
</html>
```

### 3. `logout.php`
```php
<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `session_start()` | Initializes session engine; sends HTTP headers with session cookie ID. |
| `$_SESSION['logged_in'] = true;` | Sets authentication state on the server. |
| `header("Location: dashboard.php")` | Sends HTTP 302 redirect header to the browser. |
| `exit();` | Immediately terminates script execution after sending redirect header. |
| `session_destroy()` | Purges all session data associated with current session ID on server. |

## Expected Output & Test Cases
| Test Case # | User Action / Inputs | Expected Output / Behavior |
| :---: | :--- | :--- |
| **1** | Username: admin, Password: password | Redirects to `dashboard.php`, shows "Welcome, admin!". |
| **2** | Username: admin, Password: wrong | Displays "Invalid Login!" on login page. |
| **3** | Direct URL access to `dashboard.php` without logging in | Automatically redirected back to `login.php`. |
| **4** | Click "Logout" in dashboard, then press Back button and reload | Redirected to `login.php` because session was destroyed. |

## Viva Questions & Answers
**Q1. Why are sessions required in web development?**  
*Ans:* Because HTTP is stateless; sessions maintain user state across multiple page visits by mapping client session cookies to server-side variables.

**Q2. Where is session data stored?**  
*Ans:* Actual session data is stored securely on the web server; only a session identifier cookie (`PHPSESSID`) is stored on the user's browser.

**Q3. Why must `session_start()` precede any HTML output?**  
*Ans:* `session_start()` sets HTTP cookies in HTTP headers. HTTP headers must be sent before any HTML or body content is output to the browser.

**Q4. How are protected pages guarded from unauthorized access?**  
*Ans:* Each protected page verifies session flags (e.g., `$_SESSION['logged_in']`). If absent, it issues a redirect to `login.php` and exits execution.

**Q5. What is the weakness of hard-coded login credentials?**  
*Ans:* Hardcoded values cannot be dynamically updated and expose credentials in code. Production applications query hashed passwords from databases.
