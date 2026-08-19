<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Student Information</h1> 

    <p>Student ID: <?= htmlspecialchars($student['student_id'] ?? '') ?></p>
    <p>Name: <?= htmlspecialchars($student['name'] ?? '') ?></p>
    <p>Course: <?= htmlspecialchars($student['course'] ?? '') ?></p>
    <p>Year Level: <?= htmlspecialchars($student['year'] ?? '') ?></p>
    <p>Section: <?= htmlspecialchars($student['section'] ?? '') ?></p>
    <p>Email: <?= htmlspecialchars($student['email'] ?? '') ?></p>
</body>
</html>