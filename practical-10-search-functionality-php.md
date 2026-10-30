# Practical 10: Search Functionality in PHP

## Aim
To develop a PHP database search feature that retrieves and renders matching records using the SQL `LIKE` operator and wildcard pattern matching.

## Objective
To understand partial pattern matching in SQL, handle GET parameters for search queries, sanitize inputs with `mysqli_real_escape_string()`, and process search result sets.

## System Requirements
- **Software:** XAMPP (Apache + MySQL / phpMyAdmin), PHP 8.x, Web Browser.

## Theory & Logic
Search features rely on pattern matching to find partial matches.
In SQL, the `LIKE` operator uses wildcards:
- `%term%`: Matches strings containing "term" anywhere.
- `term%`: Matches strings starting with "term".
- `%term`: Matches strings ending with "term".

The GET HTTP method (`method="get"`) is standard for search forms so that search URLs (`?query=searchterm`) can be bookmarked and shared.

## Database Sample Setup (SQL)
Populate `test_db` from Practical 09 with sample records in phpMyAdmin SQL tab:
```sql
USE test_db;

INSERT INTO users (name) VALUES
('Subham'), 
('Aniket'), 
('Rahul'), 
('Subhash'), 
('Meena');
```

## Lab Setup & Procedure
1. Ensure `test_db` database and `users` table exist with sample records.
2. Create `search.php` in `htdocs/lab/`.
3. Construct search form with GET method.
4. Process query, sanitize input via `mysqli_real_escape_string()`, execute `LIKE` query, and output matching rows.

## Algorithm
1. Render HTML form `<form method="get">` with input field named `query`.
2. Check `isset($_GET['query'])` and `$search = trim($_GET['query'])`.
3. Connect to MySQL database.
4. Sanitize search string using `mysqli_real_escape_string($conn, $search)`.
5. Execute query: `SELECT * FROM users WHERE name LIKE '%$search%'`.
6. Evaluate `mysqli_num_rows($result)`:
   - If $> 0$: Loop through matching rows with `mysqli_fetch_assoc()` and print user records.
   - Else: Output "No matches found."

## Source Code (`search.php`)
```php
<?php
$conn = mysqli_connect("localhost", "root", "", "test_db");

if (!$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP Database Search</title>
</head>
<body>
<h2>Search Users Database</h2>

<form method="get">
    Search Users: <input type="text" name="query" value="<?php if(isset($_GET['query'])) echo htmlspecialchars($_GET['query']); ?>" required>
    <input type="submit" value="Search">
</form>

<?php
if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search = mysqli_real_escape_string($conn, trim($_GET['query']));
    $sql = "SELECT * FROM users WHERE name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    echo "<h4>Search Results for '" . htmlspecialchars($search) . "':</h4>";

    if (mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li><strong>User ID:</strong> " . $row['id'] . " | <strong>Name:</strong> " . htmlspecialchars($row['name']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>No matches found.</p>";
    }
}
?>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `method="get"` | Appends search terms to the browser URL parameters (`?query=term`), allowing shareable URLs. |
| `mysqli_real_escape_string()` | Escapes special SQL characters in input string to prevent basic SQL injection. |
| `LIKE '%$search%'` | SQL wildcard pattern matching records containing search string anywhere. |
| `mysqli_num_rows()` | Returns total count of matching rows returned in result set. |

## Expected Output & Test Cases
| Test Case # | Search Query Entered | Expected Output Result |
| :---: | :--- | :--- |
| **1** | "Subham" | Displays: User ID: 1 \| Name: Subham |
| **2** | "Sub" | Displays both "Subham" and "Subhash" records. |
| **3** | "a" | Displays all names containing character "a" (case-insensitive in default collation). |
| **4** | "xyz" | Displays: "No matches found." |

## Viva Questions & Answers
**Q1. What is the function of the SQL `LIKE` operator?**  
*Ans:* The `LIKE` operator is used in a `WHERE` clause to search for a specified pattern in a column.

**Q2. What is the difference between `%` and `_` wildcards in SQL?**  
*Ans:* `%` represents zero, one, or multiple characters; `_` represents exactly one single character.

**Q3. Why is the HTTP GET method standard for search functionality?**  
*Ans:* Because searches are read-only operations. GET request parameters appear in the URL, making search result pages bookmarkable and linkable.

**Q4. What would the query `SELECT * FROM users WHERE name LIKE 'A%'` return?**  
*Ans:* It returns all user records whose `name` column starts with the letter 'A'.

**Q5. Why is `mysqli_real_escape_string()` used, and what is its better alternative?**  
*Ans:* It escapes special characters in strings for SQL safety; prepared statements (`mysqli_prepare`) are the superior alternative for total SQL injection prevention.
