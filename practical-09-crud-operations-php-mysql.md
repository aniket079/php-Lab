# Practical 09: CRUD Operations Using PHP & MySQL

## Aim
To implement Create, Read, Update, and Delete (CRUD) database operations using PHP and MySQL database driver (`mysqli`).

## Objective
To master database connectivity, SQL query execution, result set iteration with `mysqli_fetch_assoc()`, and secure queries using prepared statements.

## System Requirements
- **Software:** XAMPP (Apache + MySQL / phpMyAdmin), PHP 8.x, Web Browser.

## Theory & Logic
CRUD operations represent fundamental database interactions:
- **Create:** `INSERT INTO table_name ...`
- **Read:** `SELECT * FROM table_name`
- **Update:** `UPDATE table_name SET ... WHERE id = ...`
- **Delete:** `DELETE FROM table_name WHERE id = ...`

Connection is established via `mysqli_connect(host, username, password, database)`. Prepared statements (`mysqli_prepare`, `mysqli_stmt_bind_param`) are used for secure operations to prevent SQL injection vulnerabilities.

## Database Setup (SQL)
Execute the following SQL commands in phpMyAdmin SQL tab:
```sql
CREATE DATABASE IF NOT EXISTS test_db;
USE test_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);
```

## Lab Setup & Procedure
1. Start Apache and MySQL in XAMPP Control Panel.
2. Open phpMyAdmin (`http://localhost/phpmyadmin/`) and create `test_db` database and `users` table.
3. Create `crud.php` in `htdocs/lab/`.
4. Connect PHP to MySQL and implement forms and queries for CRUD actions.

## Algorithm
1. Connect to MySQL: `$conn = mysqli_connect("localhost", "root", "", "test_db")`.
2. **Create (Insert):** Upon submit `add`, read username and execute `$stmt` insert query.
3. **Read (Select):** Execute `SELECT * FROM users` and loop results through `mysqli_fetch_assoc()` in an HTML table.
4. **Update:** Upon submit `update`, bind `$name` and `$id` in `UPDATE` prepared statement and execute.
5. **Delete:** Upon GET request `?delete=id`, execute `DELETE` prepared statement for given user ID.

## Source Code (`crud.php`)
```php
<?php
$conn = mysqli_connect("localhost", "root", "", "test_db");

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// CREATE
if (isset($_POST['create'])) {
    $name = trim($_POST['username']);
    if (!empty($name)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO users (name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// UPDATE
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $name = trim($_POST['username']);
    if ($id > 0 && !empty($name)) {
        $stmt = mysqli_prepare($conn, "UPDATE users SET name = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "si", $name, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("Location: crud.php");
        exit();
    }
}

// READ
$result = mysqli_query($conn, "SELECT * FROM users");
?>
<!DOCTYPE html>
<html>
<head><title>PHP MySQL CRUD</title></head>
<body>
<h2>CRUD Operations in PHP & MySQL</h2>

<h3>1. Add New User (Create)</h3>
<form method="post">
    Name: <input type="text" name="username" required>
    <input type="submit" name="create" value="Add User">
</form>

<h3>2. Update User</h3>
<form method="post">
    User ID: <input type="number" name="id" required>
    New Name: <input type="text" name="username" required>
    <input type="submit" name="update" value="Update User">
</form>

<h3>3. User Records (Read & Delete)</h3>
<table border="1" cellpadding="8" cellspacing="0">
    <tr><th>ID</th><th>Name</th><th>Action</th></tr>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete user?');">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="3">No records found.</td></tr>
    <?php endif; ?>
</table>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `mysqli_connect()` | Establishes active database connection handle to MySQL server. |
| `mysqli_prepare()` | Pre-compiles SQL query template on server for secure variable binding. |
| `mysqli_stmt_bind_param()` | Binds parameters (`"s"` = string, `"i"` = integer) preventing SQL injection. |
| `mysqli_query()` | Sends raw SQL query to database engine. |
| `mysqli_fetch_assoc()` | Fetches next result row as an associative array where column names are array keys. |

## Expected Output & Test Cases
| Test Case # | Action Executed | Expected Result |
| :---: | :--- | :--- |
| **1** | Add User "Aniket" | New row appears in table with generated ID and name "Aniket". |
| **2** | Add Users "Rahul" and "Subham" | Table displays three total rows. |
| **3** | Update ID 2 to "Rohit" | Row 2 name updates to "Rohit". |
| **4** | Delete User ID 3 | Row 3 is permanently removed from table and database. |

## Viva Questions & Answers
**Q1. What does the CRUD acronym stand for?**  
*Ans:* **C**reate, **R**ead, **U**pdate, **D**elete — the four fundamental persistent storage operations.

**Q2. Which SQL statement corresponds to each CRUD operation?**  
*Ans:* Create $\rightarrow$ `INSERT`, Read $\rightarrow$ `SELECT`, Update $\rightarrow$ `UPDATE`, Delete $\rightarrow$ `DELETE`.

**Q3. What is the function of `mysqli_fetch_assoc()`?**  
*Ans:* It fetches a result row from a query result set as an associative array indexed by column names.

**Q4. What is SQL Injection and how do prepared statements prevent it?**  
*Ans:* SQL Injection occurs when malicious user inputs alter SQL query logic. Prepared statements separate SQL query code from data parameters, ensuring user input is treated strictly as data.

**Q5. What does `AUTO_INCREMENT` do in MySQL table definitions?**  
*Ans:* It automatically generates a sequential, unique integer primary key for every newly inserted row.
