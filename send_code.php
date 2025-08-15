<?php
// send_code.php
session_start();

if (isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid.";
        exit;
    }

    // Generate kode verifikasi 6 digit acak
    $code = rand(100000, 999999);

    // Simpan kode di session (cara sederhana, tidak disarankan untuk skala besar)
    $_SESSION['verification_code'] = [
        'email' => $email,
        'code' => $code,
        'expires_at' => time() + 300 // Kadaluarsa dalam 5 menit
    ];

    $subject = "Kode Verifikasi Anda";
    $message = "Kode verifikasi Anda adalah: " . $code . ". Kode ini akan kadaluarsa dalam 5 menit.";
    $headers = 'From: noreply@contohdomain.com' . "\r\n" .
               'Reply-To: noreply@contohdomain.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Mengirim email
    // PENTING: Untuk menghindari email masuk spam, pastikan server Anda dikonfigurasi dengan benar.
    // Untuk keandalan lebih baik, gunakan library seperti PHPMailer atau layanan pihak ketiga.
    $mail_sent = mail($email, $subject, $message, $headers);

    if ($mail_sent) {
        echo "Kode verifikasi berhasil dikirim! Silakan cek email Anda.";
    } else {
        echo "Gagal mengirim email. Silakan coba lagi.";
    }
} else {
    echo "Akses tidak valid.";
}
?>