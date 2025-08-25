<?php

$nameError = "";
$emailError = "";
$genderError = "";
$dobError = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];


    if (empty($name)) {
        $nameError = "Name is required.";
    }


    if (empty($email)) {
        $emailError = "Email is required.";
    } else if (!strpos($email, "@") || !strpos($email, ".")) {
        $emailError = "Invalid email format. Use @ and .";
    }


    if (empty($gender)) {
        $genderError = "Please select a gender.";
    }

 
    if (empty($dob)) {
        $dobError = "Date of Birth is required.";
    } else if (strlen($dob) != 10 || substr($dob, 4, 1) != "-" || substr($dob, 7, 1) != "-") {
        $dobError = "Invalid DOB format. Use YYYY-MM-DD.";
    }


    if (empty($nameError) && empty($emailError) && empty($genderError) && empty($dobError)) {
        echo "Form submitted successfully!<br>";
        echo "Name: " . $name . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Gender: " . $gender . "<br>";
        echo "Date of Birth: " . $dob . "<br>";
    } else {
        
        echo $nameError . "<br>";
        echo $emailError . "<br>";
        echo $genderError . "<br>";
        echo $dobError . "<br>";
    }
}

$date_time = "12:14 PM +06 on Monday, August 25, 2025";
echo "<br>Current Date and Time: " . $date_time;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        .error { color: red; font-size: 12px; }
    </style>
</head>
<body>
    <h2>Registration Form</h2>
    <form action="F_L_PHP.php" method="post">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" size="30">
            <div id="nameError" class="error"></div>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="text" name="email" size="30">
            <div id="emailError" class="error"></div>
        </div>
        <div class="form-group">
            <label>Gender:</label>
            <input type="radio" name="gender" value="male"> Male
            <input type="radio" name="gender" value="female"> Female
            <div id="genderError" class="error"></div>
        </div>
        <div class="form-group">
            <label>Date of Birth (YYYY-MM-DD):</label>
            <input type="text" name="dob" size="10">
            <div id="dobError" class="error"></div>
        </div>
        <input type="submit" value="Submit">
    </form>
</body>
</html>