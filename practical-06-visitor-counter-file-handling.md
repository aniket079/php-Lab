# Practical 06: Visitor Counter Using File Handling

## Aim
To develop a web visitor counter application in PHP that tracks and displays page hit counts using flat-file storage.

## Objective
To learn file I/O operations in PHP including reading (`file_get_contents`), writing (`file_put_contents`), and checking file existence (`file_exists`).

## System Requirements
- **Software:** XAMPP / WAMP Server, PHP 7.4+, Text Editor, Web Browser.

## Theory & Logic
Flat-file storage provides basic data persistence without requiring a database engine.
The hit counter logic follows three steps:
1. **Read:** Read current hit count integer from `counter.txt` via `file_get_contents()`.
2. **Increment:** Increment the integer variable by 1 (`$count++`).
3. **Write:** Write the updated integer back to `counter.txt` using `file_put_contents()`.

## Lab Setup & Procedure
1. Create `counter.php` in `htdocs/lab/`.
2. Optionally create `counter.txt` initialized to `0`. (Script creates it automatically if absent).
3. Open `http://localhost/lab/counter.php` in a web browser.
4. Refresh the browser repeatedly to verify hit counter increments.

## Algorithm
1. Set `$file = 'counter.txt'`.
2. Check `!file_exists($file)`: If missing, initialize file with `'0'` via `file_put_contents()`.
3. Read current value from `$file` using `file_get_contents($file)`.
4. Cast value to integer and increment `$count++`.
5. Save updated count back to file via `file_put_contents($file, $count)`.
6. Display output: `"You are visitor number: $count"`.

## Source Code (`counter.php`)
```php
<?php
$file = 'counter.txt';

// Initialize counter file if missing
if (!file_exists($file)) {
    file_put_contents($file, '0');
}

// Read current counter
$count = (int)file_get_contents($file);

// Increment count
$count++;

// Save updated count back to file
file_put_contents($file, $count);

// Display counter
echo "<!DOCTYPE html><html><head><title>Visitor Counter</title></head><body>";
echo "<div style='font-family:Arial; padding:20px; border:1px solid #ccc; width:300px; text-align:center;'>";
echo "<h2>You are visitor number:</h2>";
echo "<h1 style='color:blue;'>$count</h1>";
echo "</div>";
echo "</body></html>";
?>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `file_exists($file)` | Checks whether `counter.txt` exists on the server filesystem. |
| `file_get_contents($file)` | Reads entire text file content into a string variable. |
| `$count++` | Increments count; PHP handles automatic type coercion from string to integer. |
| `file_put_contents($file, $count)` | Overwrites file contents with the updated count value. |

## Expected Output & Test Cases
| Test Case # | Action / Event | Expected Visitor Output |
| :---: | :--- | :--- |
| **1** | Open page first time (`counter.txt` absent) | Displays: "You are visitor number: 1" |
| **2** | Refresh page once | Displays: "You are visitor number: 2" |
| **3** | Refresh 5 additional times | Displays: "You are visitor number: 7" |
| **4** | Delete `counter.txt` and reload | Counter resets and displays: "You are visitor number: 1" |

## Viva Questions & Answers
**Q1. What is flat-file storage?**  
*Ans:* Storing structured or unstructured data inside ordinary text files on the filesystem instead of a relational database management system.

**Q2. How do `file_put_contents()` operations differ when using the `FILE_APPEND` flag?**  
*Ans:* Without `FILE_APPEND`, the file is completely overwritten. With `FILE_APPEND`, new data is appended to the end of the existing file.

**Q3. What are the main drawbacks of using a flat-file hit counter?**  
*Ans:* It counts total page reloads rather than unique visitor sessions, and concurrent HTTP requests can cause race conditions and data corruption.

**Q4. How can file race conditions be prevented during concurrent file writes?**  
*Ans:* By applying file locking using `flock()` or passing the `LOCK_EX` flag to `file_put_contents()`.

**Q5. Why must directory permissions be configured correctly for file handling scripts?**  
*Ans:* The web server process requires write permissions on the directory to create and modify `counter.txt`.
