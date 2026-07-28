<?php


echo "<h1>Conditions, Loops, Arrays and Functions</h1>";

// ------------------------------------------------------------------
// Conditional Statements
// ------------------------------------------------------------------

$marks = 78;

if ($marks >= 90) {
    $grade = "A+";
} elseif ($marks >= 75) {
    $grade = "A";
} elseif ($marks >= 60) {
    $grade = "B";
} elseif ($marks >= 40) {
    $grade = "C";
} else {
    $grade = "Fail";
}

echo "Marks: $marks <br>";
echo "Grade: $grade <br><br>";

// ------------------------------------------------------------------
// Switch Statement
// ------------------------------------------------------------------

$role = "admin";

switch ($role) {
    case "admin":
        echo "Admin can manage all records.<br> $role";
        break;

    case "teacher":
        echo "Teacher can manage student marks.<br>";
        break;

    case "student":
        echo "Student can view personal records.<br>";
        break;

    default:
        echo "Unknown role.<br>";
}

echo "<hr>";

// ------------------------------------------------------------------
// For Loop
// ------------------------------------------------------------------

echo "<h2>For Loop</h2>";

for ($i = 1; $i <= 5; $i++) {
    echo "Iteration number: $i <br>";
}

// ------------------------------------------------------------------
// Indexed Array
// ------------------------------------------------------------------

$students = ["Rahul", "Priya", "Aman", "Neha"];

echo "<h2>Student List</h2>";

foreach ($students as $student) {
    echo $student . "<br>";
}

// ------------------------------------------------------------------
// Associative Array
// ------------------------------------------------------------------

$student = [
    "name" => "Rahul",
    "email" => "rahul@example.com",
    "course" => "B.Tech",
    "semester" => 5
];

echo "<h2>Associative Array</h2>";

echo "Name: " . $student["name"] . "<br>";
echo "Email: " . $student["email"] . "<br>";
echo "Course: " . $student["course"] . "<br>";

// ------------------------------------------------------------------
// Array of Associative Arrays
// Similar structure will come from a database.
// ------------------------------------------------------------------

$studentRecords = [
    [
        "id" => 1,
        "name" => "Rahul",
        "marks" => 78
    ],
    [
        "id" => 2,
        "name" => "Priya",
        "marks" => 92
    ],
    [
        "id" => 3,
        "name" => "Aman",
        "marks" => 65
    ]
];

echo "<h2>Student Records</h2>";

foreach ($studentRecords as $record) {
    echo "ID: " . $record["id"] . "<br>";
    echo "Name: " . $record["name"] . "<br>";
    echo "Marks: " . $record["marks"] . "<br>";
    echo "<br>";
}

// ------------------------------------------------------------------
// Functions
// ------------------------------------------------------------------

function calculateGrade(float $marks): string
{
    if ($marks >= 90) {
        return "A+";
    }

    if ($marks >= 75) {
        return "A";
    }

    if ($marks >= 60) {
        return "B";
    }

    if ($marks >= 40) {
        return "C";
    }

    return "Fail";
}

echo "<h2>Function Result</h2>";

echo calculateGrade(86);