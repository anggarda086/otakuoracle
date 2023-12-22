<?php
session_start();

include_once 'db_connection.php';


if (isset($_POST['signin'])) {
    include_once 'login.php';
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
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['password'] = $row['password'];
            header("Location: /home/home.html");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid email";
    }

    $stmt->close();
}


if (isset($_POST['signup'])) {
    include_once 'login.php';

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

    $stmt->close();
    header("Location: index.html");
    exit();
}
?>
