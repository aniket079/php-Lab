<?php

/*
|--------------------------------------------------------------------------
| PHP BASIC SYNTAX
|--------------------------------------------------------------------------
| This file demonstrates variables, data types, constants, operators,
| output statements and basic debugging.
|--------------------------------------------------------------------------
*/


// Printing output
echo "<h1>PHP Basics</h1>";
echo "Welcome to PHP Programming.<br><br>";

// Variables in PHP start with $
$studentName = "Rahul";
$age = 20;
$percentage = 82.5;
$isPassed = false;
$backlogCount = null;

// Printing variables using interpolation
echo "Student Name: $studentName <br>";
echo "Age: $age <br>";

// Printing using concatenation
echo "Percentage: " . $percentage . "%<br>";

// Boolean values normally print 1 for true and nothing for false
echo "Passed: " . $isPassed . "<br><br>";

// Checking variable data types
echo "<h2>Data Types</h2>";

var_dump($studentName);
echo "<br>";

var_dump($age);
echo "<br>";

var_dump($percentage);
echo "<br>";

var_dump($isPassed);
echo "<br>";

var_dump($backlogCount);
echo "<br><br>";

// Constant: value should not change during execution
define("COLLEGE_NAME", "ABC Engineering College");

echo "College: " . COLLEGE_NAME . "<br><br>";

// Arithmetic operators
$subjectOne = 75;
$subjectTwo = 85;
$subjectThree = 90;

$total = $subjectOne + $subjectTwo + $subjectThree;
$average = $total / 3;

echo "<h2>Marks Calculation</h2>";
echo "Total Marks: $total <br>";
echo "Average Marks: " . round($average, 2) . "<br>";

// Comparison operators
echo "<h2>Comparison</h2>";
// $isAge = ($age == "20");
// echo "is Age is true or false -->$isAge";
var_dump($age == "20");  // true: compares value
echo "<br>";

var_dump($age === "20"); // false: compares value and data type
echo "<br>";

// Increment operator
$attendance = 70;
$attendance++;

echo "<br>Updated Attendance: $attendance";