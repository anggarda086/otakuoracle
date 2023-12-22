<?php
include 'db_connection2.php';

if (isset($_POST['update_password'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    // Hash password baru
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Gunakan pernyataan yang telah disiapkan untuk memperbarui password
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    
    if ($stmt) {
        $stmt->bind_param("ss", $newHashedPassword, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Password berhasil diperbarui!";
            echo "<script>window.location.href='/home/home.html';</script>";
        } else {
            echo "Gagal memperbarui password. Silakan coba lagi.";
        }

        $stmt->close();
    } else {
        echo "Error dalam pernyataan yang telah disiapkan: " . $conn->error;
    }
}

// Tutup koneksi database pada akhir skrip
$conn->close();
?>
