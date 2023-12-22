<?php
session_start();

include_once 'D:/xampp/htdocs/uas_lab_pemweb/db_connection.php';

// Check if the form is submitted for sign-in
if (isset($_POST['signin'])) {
    include_once 'D:/xampp/htdocs/uas_lab_pemweb/login.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        echo "Please fill in all fields";
        exit();
    }

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Use password_verify to compare the entered password with the hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email']; // Set the session variable
            $_SESSION['name'] = $row['name'];
            $_SESSION['password'] = $row['password'];
            header("Location: /uas_lab_pemweb/home/home.html");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid email";
    }

    $stmt->close();
}

// Check if the form is submitted for sign-up
if (isset($_POST['signup'])) {
    include_once 'D:/xampp/htdocs/uas_lab_pemweb/login/login.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($name) || empty($email) || empty($_POST['password'])) {
        echo "Please fill in all fields";
        exit();
    }

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();

    echo "Account created successfully";
    header("Location: index.html");

    $stmt->close();
}
?>
