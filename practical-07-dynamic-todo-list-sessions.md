# Practical 07: Dynamic To-Do List Using Sessions

## Aim
To create a dynamic to-do list web application in PHP where tasks can be dynamically added and deleted using session array storage.

## Objective
To master session array handling, appending array elements (`$array[] = value`), array element removal (`unset()`), and list rendering.

## System Requirements
- **Software:** XAMPP (Apache + PHP), Code Editor, Web Browser.

## Theory & Logic
Because HTTP is stateless, standard PHP array variables reset on every request. Storing an array inside `$_SESSION['todo']` allows tasks to persist across page reloads for the current user session.
Operations:
1. **Add Task:** Appends new item to session array: `$_SESSION['todo'][] = $task`.
2. **Delete Task:** Removes element by array index: `unset($_SESSION['todo'][$id])`.
3. **Redirect:** Calls `header("Location: todo.php")` after deletion to prevent accidental re-deletion upon browser refresh.

## Lab Setup & Procedure
1. Create `todo.php` inside `htdocs/lab/`.
2. Call `session_start()` at top of file.
3. Initialize `$_SESSION['todo']` as empty array if uninitialized.
4. Handle task addition via POST request and task deletion via GET query string (`?delete=index`).

## Algorithm
1. Call `session_start()`.
2. If `!isset($_SESSION['todo'])`, set `$_SESSION['todo'] = []`.
3. If `isset($_POST['add_task'])`: Append `$_POST['task_item']` to `$_SESSION['todo'][]`.
4. If `isset($_GET['delete'])`:
   - Store target index `$id = $_GET['delete']`.
   - Remove element via `unset($_SESSION['todo'][$id])`.
   - Issue HTTP redirect `header("Location: todo.php")` and `exit()`.
5. Iterate through `$_SESSION['todo']` with `foreach` and display tasks with a corresponding "Delete" hyperlinked button containing array index key.

## Source Code (`todo.php`)
```php
<?php
session_start();

if (!isset($_SESSION['todo'])) {
    $_SESSION['todo'] = [];
}

// Add task
if (isset($_POST['add_task']) && !empty(trim($_POST['task_item']))) {
    $_SESSION['todo'][] = htmlspecialchars(trim($_POST['task_item']));
    header("Location: todo.php");
    exit();
}

// Delete task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (isset($_SESSION['todo'][$id])) {
        unset($_SESSION['todo'][$id]);
    }
    header("Location: todo.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dynamic To-Do List</title>
</head>
<body>
<h2>PHP Dynamic To-Do List</h2>

<form method="post">
    <input type="text" name="task_item" placeholder="Enter new task..." required>
    <button type="submit" name="add_task">Add Task</button>
</form>

<h3>Tasks:</h3>
<ul>
    <?php if (empty($_SESSION['todo'])): ?>
        <li>No tasks available. Add one above!</li>
    <?php else: ?>
        <?php foreach ($_SESSION['todo'] as $key => $task): ?>
            <li>
                <?php echo $task; ?> 
                <a href="?delete=<?php echo $key; ?>" onclick="return confirm('Delete task?');">[Delete]</a>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `$_SESSION['todo'] = []` | Initializes empty array in session storage if not already present. |
| `$_SESSION['todo'][] = ...` | Appends new task item to end of session array. |
| `unset($_SESSION['todo'][$id])` | Removes task element at specified array index. |
| `foreach(... as $key => $task)` | Loops over session array, capturing index key `$key` for delete action URL. |
| `header("Location: todo.php")` | Implements Post/Redirect/Get pattern to prevent duplicate form submissions upon page refresh. |

## Expected Output & Test Cases
| Test Case # | Action / Input | Expected Result |
| :---: | :--- | :--- |
| **1** | Enter "Buy Milk" and click Add Task | "Buy Milk" appears in list with a [Delete] link. |
| **2** | Add "Study PHP" and "Submit Assignment" | List updates displaying all 3 tasks in order. |
| **3** | Click [Delete] next to "Study PHP" | "Study PHP" disappears; remaining tasks stay. |
| **4** | Close browser completely and reopen page | Session ends; task list resets to empty. |

## Viva Questions & Answers
**Q1. Why are session variables used instead of local variables for the task list?**  
*Ans:* Local variables are destroyed when script execution ends. Session variables persist across multiple HTTP requests.

**Q2. What is the difference between `array_push()` and `$array[] = $value` syntax?**  
*Ans:* Both append elements to an array; however, `$array[] = $value` is cleaner and avoids function call overhead.

**Q3. What happens to array keys when `unset()` is used on an element?**  
*Ans:* `unset()` deletes the key-value pair without re-indexing array keys.

**Q4. Why is HTTP redirect issued after deleting a task?**  
*Ans:* To clean URL query parameters (`?delete=N`), preventing accidental re-execution of deletion when users refresh the browser.

**Q5. Is session storage suitable for permanent task storage?**  
*Ans:* No; session data is ephemeral and expires when sessions close. Databases or flat files are required for permanent storage.
