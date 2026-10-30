# Practical 01: Student Grade Management System

## Aim
To develop a PHP-based web application that accepts student details and marks through a form, performs calculations for total marks and percentage, and assigns grades automatically.

## Objective
To master the use of HTML forms, PHP global variables (`$_POST`), and multi-way branching (`if-elseif-else`) for automated decision-making.

## System Requirements
- **Hardware:** Dual-core processor, 4GB RAM, 100MB free disk space.
- **Software:** Windows 10/11, XAMPP Server (Apache, PHP 8.x), VS Code or text editor, Web Browser (Chrome/Edge/Firefox).

## Theory & Logic
The system utilizes the HTTP POST method to securely send data to the server. PHP captures this data using the `$_POST` associative array. The application logic follows three distinct phases:
1. **Data Acquisition:** Extracting marks and student details from HTML form input fields via `$_POST`.
2. **Processing:** Summing subject marks and calculating the percentage using the formula:
   $$\text{Percentage} = \left( \frac{\text{Total Marks}}{\text{Maximum Marks}} \right) \times 100$$
3. **Evaluation:** Comparing the calculated percentage against predefined grade thresholds using multi-way conditional statements (`if-elseif-else`).

## Lab Setup & Procedure
1. Open XAMPP Control Panel and start the Apache module.
2. Create a folder named `grade_system` inside `C:\xampp\htdocs\`.
3. Save the input program as `index.php` inside the `grade_system` folder.
4. Open the browser and navigate to `http://localhost/grade_system/index.php`.
5. Enter student details and subject marks, submit the form, and observe the dynamically generated grade report.

## Algorithm
1. Start the XAMPP Apache server and open `index.php` in the browser.
2. Display an HTML form accepting Student Name, Physics marks (`m1`), and Chemistry marks (`m2`).
3. Upon form submission, verify `isset($_POST['submit'])` and retrieve data from `$_POST`. Sanitize the name string using `htmlspecialchars()`.
4. Calculate aggregate total $total = m1 + m2$ and percentage $per = (total / 200) \times 100$.
5. Evaluate grade using conditional logic:
   - If $per \ge 85$: Grade = "A+ (Excellent)"
   - Else if $per \ge 60$: Grade = "B (First Class)"
   - Else if $per \ge 40$: Grade = "C (Pass)"
   - Else: Grade = "F (Fail)"
6. Display the student name, total aggregate, percentage, and assigned grade inside a formatted HTML box.

## Source Code (`index.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title>Student Grade Management System</title>
</head>
<body>
<h2>Student Grade Portal</h2>
<form method="post">
    Student Name: <input type="text" name="name" required><br><br>
    Physics Marks: <input type="number" name="m1" max="100" required><br><br>
    Chemistry Marks: <input type="number" name="m2" max="100" required><br><br>
    <input type="submit" name="submit" value="Generate Report">
</form>

<?php
if(isset($_POST['submit'])){
    $name = htmlspecialchars($_POST['name']);
    $m1 = $_POST['m1'];
    $m2 = $_POST['m2'];
    
    $total = $m1 + $m2;
    $per = ($total / 200) * 100;
    
    if($per >= 85) {
        $grade = "A+ (Excellent)";
    } elseif($per >= 60) {
        $grade = "B (First Class)";
    } elseif($per >= 40) {
        $grade = "C (Pass)";
    } else {
        $grade = "F (Fail)";
    }
    
    echo "<div style='border:1px solid #000; padding:10px; margin-top:20px; width:300px;'>";
    echo "<strong>Student:</strong> $name <br>";
    echo "<strong>Aggregate:</strong> $total/200 <br>";
    echo "<strong>Percentage:</strong> $per% <br>";
    echo "<strong>Final Grade:</strong> $grade";
    echo "</div>";
}
?>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `isset($_POST['submit'])` | Checks if the form has been submitted before attempting to process variables. |
| `htmlspecialchars()` | Sanitizes user input by converting special characters to HTML entities to prevent XSS attacks. |
| `$total = $m1 + $m2;` | Computes aggregate total marks out of 200. |
| `$per = ($total / 200) * 100;` | Applies percentage calculation formula. |
| `if / elseif / else` | Multi-way decision branching to assign grade based on percentage brackets. |
| `echo "<div ...>"` | Interpolates variables inside double quotes and renders a formatted output container. |

## Expected Output & Test Cases
| Test Case # | Input Details | Expected Output Result |
| :---: | :--- | :--- |
| **1** | Name: Riya, Physics: 90, Chemistry: 85 | Aggregate: 175/200, Percentage: 87.5%, Grade: A+ (Excellent) |
| **2** | Name: Aman, Physics: 70, Chemistry: 60 | Aggregate: 130/200, Percentage: 65%, Grade: B (First Class) |
| **3** | Name: Neha, Physics: 50, Chemistry: 40 | Aggregate: 90/200, Percentage: 45%, Grade: C (Pass) |
| **4** | Name: Karan, Physics: 30, Chemistry: 20 | Aggregate: 50/200, Percentage: 25%, Grade: F (Fail) |

## Viva Questions & Answers
**Q1. Which HTTP method is used to send form data securely in this application?**  
*Ans:* The HTTP POST method; form data is transmitted within the HTTP request body and accessed via `$_POST`.

**Q2. What is the key difference between GET and POST requests?**  
*Ans:* GET appends form data to the URL parameter string (visible, limited length, bookmarkable), whereas POST sends data securely inside the HTTP request body.

**Q3. Why is `htmlspecialchars()` necessary for form inputs?**  
*Ans:* It escapes special characters (such as `<` and `>`) into HTML entities, preventing malicious user inputs from executing as HTML or JavaScript scripts (Cross-Site Scripting protection).

**Q4. Why use `elseif` instead of multiple independent `if` statements?**  
*Ans:* `elseif` ensures mutually exclusive execution — once a condition evaluates to true, subsequent checks are skipped, ensuring exactly one grade is assigned efficiently.

**Q5. What role do the `required` and `max` attributes play in HTML form fields?**  
*Ans:* They perform client-side browser validation to ensure non-empty inputs and restrict mark values up to 100 before form submission.

## Precautions
1. Always ensure Apache server is running in XAMPP before executing the script.
2. Access the file via `http://localhost/` URL rather than direct file paths to ensure PHP processing.
