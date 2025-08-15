<?php
// verify_code.php
session_start();

if (isset($_POST['email']) && isset($_POST['code'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $code = $_POST['code'];

    // Cek apakah ada kode yang tersimpan di session
    if (!isset($_SESSION['verification_code'])) {
        echo "Kode tidak ditemukan. Silakan kirim ulang kode.";
        exit;
    }

    $stored_data = $_SESSION['verification_code'];

    // Periksa email, kode, dan waktu kadaluarsa
    if ($stored_data['email'] === $email && $stored_data['code'] == $code && time() < $stored_data['expires_at']) {
        // Kode valid
        unset($_SESSION['verification_code']); // Hapus kode setelah berhasil diverifikasi
        echo "Verifikasi berhasil! Akun Anda telah terverifikasi.";
    } else {
        // Kode tidak valid
        echo "Kode salah atau sudah kadaluarsa.";
    }

} else {
    echo "Akses tidak valid.";
}
?>