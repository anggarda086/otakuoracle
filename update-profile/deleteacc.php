<?php

include 'db_connection2.php';

if (isset($_POST['delete_account'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];


        if (password_verify($password, $hashedPassword)) {
            $deleteSql = "DELETE FROM users WHERE email = '$email'";
            if ($conn->query($deleteSql) === TRUE) {
                $conn->close();
                header("Location: /index.html");
                exit(); 
            } else {
                echo "Error deleting account: " . $conn->error;
            }
        } else {
            echo "Invalid email or password. Please try again.";
        }
    } else {
        echo "Invalid email or password. Please try again.";
    }
}

?>
