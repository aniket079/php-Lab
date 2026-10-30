# Practical 02: Simple Calculator Using PHP

## Aim
To design a web-based calculator using PHP that performs basic arithmetic operations based on user input.

## Objective
To implement the `switch-case` control structure and handle mathematical operations within a stateless web environment.

## System Requirements
- **Hardware:** Standard PC / Laptop.
- **Software:** XAMPP / WAMP Server, PHP 7.4+, Modern Web Browser.

## Theory & Logic
A `switch-case` control structure is ideal for multi-option execution based on a single scalar variable (the chosen operator). It provides clean and efficient conditional routing for four fundamental arithmetic operations: Addition (`+`), Subtraction (`-`), Multiplication (`*`), and Division (`/`). Special condition logic handles division by zero to prevent execution runtime exceptions.

## Lab Setup & Procedure
1. Start the Apache module in XAMPP.
2. Create `calculator.php` in `C:\xampp\htdocs\lab\`.
3. Construct an HTML form containing two numeric inputs and an operation dropdown selector (`<select>`).
4. Write PHP logic checking `$_SERVER["REQUEST_METHOD"] == "POST"`.
5. Execute arithmetic logic within a `switch` block and output the result.

## Algorithm
1. Display an HTML form with two input fields (`num1`, `num2`) and an operation selection dropdown (`add`, `sub`, `mul`, `div`).
2. Detect form submission by checking `$_SERVER["REQUEST_METHOD"] == "POST"`.
3. Extract `num1`, `num2`, and `operation` values from `$_POST`.
4. Pass the `operation` variable into a `switch` statement:
   - Case `add`: Calculate `$n1 + $n2`.
   - Case `sub`: Calculate `$n1 - $n2`.
   - Case `mul`: Calculate `$n1 * $n2`.
   - Case `div`: Check if `$n2 != 0`. If true, compute `$n1 / $n2`; otherwise set error message "Error: Division by Zero".
5. Render the result heading dynamically on screen.

## Source Code (`calculator.php`)
```php
<!DOCTYPE html>
<html>
<head>
    <title>Simple Calculator</title>
</head>
<body>
<h2>PHP Simple Calculator</h2>
<form method="post">
    <input type="number" name="num1" placeholder="First Number" step="any" required>
    <select name="operation">
        <option value="add">Add (+)</option>
        <option value="sub">Subtract (-)</option>
        <option value="mul">Multiply (*)</option>
        <option value="div">Divide (/)</option>
    </select>
    <input type="number" name="num2" placeholder="Second Number" step="any" required>
    <input type="submit" value="Calculate">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $n1 = $_POST['num1'];
    $n2 = $_POST['num2'];
    $op = $_POST['operation'];
    $res = 0;

    switch ($op) {
        case "add":
            $res = $n1 + $n2;
            break;
        case "sub":
            $res = $n1 - $n2;
            break;
        case "mul":
            $res = $n1 * $n2;
            break;
        case "div":
            if ($n2 != 0) {
                $res = $n1 / $n2;
            } else {
                $res = "Error: Division by Zero";
            }
            break;
        default:
            $res = "Invalid Operation";
    }

    echo "<h3>Result: $res</h3>";
}
?>
</body>
</html>
```

## Code Explanation
| Statement / Construct | Purpose |
| :--- | :--- |
| `$_SERVER["REQUEST_METHOD"] == "POST"` | Validates that the request was generated via an HTTP POST form submission. |
| `switch ($op)` | Evaluates operator variable against multiple matching case blocks. |
| `break;` | Terminating keyword that prevents fall-through execution into lower cases. |
| `if($n2 != 0)` | Defensive check preventing division by zero before executing `/`. |
| `echo "<h3>Result: $res</h3>"` | Outputs either the calculated numerical result or the descriptive error string. |

## Expected Output & Test Cases
| Test Case # | Inputs | Operation Selected | Expected Output |
| :---: | :--- | :--- | :--- |
| **1** | Num1: 10, Num2: 5 | Add (+) | Result: 15 |
| **2** | Num1: 10, Num2: 5 | Subtract (-) | Result: 5 |
| **3** | Num1: 10, Num2: 5 | Multiply (*) | Result: 50 |
| **4** | Num1: 10, Num2: 4 | Divide (/) | Result: 2.5 |
| **5** | Num1: 10, Num2: 0 | Divide (/) | Result: Error: Division by Zero |

## Viva Questions & Answers
**Q1. Why is `switch-case` preferred over `if-elseif` for this program?**  
*Ans:* When evaluating a single variable against fixed literal values, `switch` provides cleaner syntax, better readability, and optimized branch evaluation.

**Q2. What occurs if the `break` keyword is omitted from a case block?**  
*Ans:* Execution continues into subsequent case blocks regardless of whether their case conditions match ("fall-through"), causing invalid calculation results.

**Q3. Why must division by zero be explicitly checked in PHP 8?**  
*Ans:* In PHP 8, division by zero throws a `DivisionByZeroError` exception, which halts script execution if unhandled.

**Q4. What does `$_SERVER["REQUEST_METHOD"]` return?**  
*Ans:* It returns the HTTP request method used to access the page (e.g., `GET` or `POST`).

**Q5. Why is the HTTP web protocol referred to as stateless?**  
*Ans:* HTTP does not maintain connection state or context between consecutive requests; every request is treated as independent unless sessions, cookies, or database storage are utilized.
