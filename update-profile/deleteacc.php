<?php

include 'db_connection2.php';

if (isset($_POST['delete_account'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input here if needed

    // Check if the provided email matches a user in the database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $hashedPassword)) {
            // Passwords match, proceed with deletion
            $deleteSql = "DELETE FROM users WHERE email = '$email'";
            if ($conn->query($deleteSql) === TRUE) {
                echo "Account deleted successfully";

                // Redirect to the login page
                header("Location: ../index.html");
                exit(); // Ensure that no further code is executed after the redirect
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

$conn->close();

?>
