<?php
// Bootstrap: mendefinisikan BASE_URL otomatis + koneksi database
require_once __DIR__ . '/app/config/Bootstrap.php';

// ROUTING AJAX: semua request POST diproses oleh controller pendaftaran
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/app/controllers/PendaftaranController.php';
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kampung Inggris Karawaci II - Kursus Bahasa Inggris di Tangerang</title>

    <!-- SEO & Medsos -->
    <meta name="description"
        content="Kursus Bahasa Inggris offline di Karawaci, Tangerang untuk Preschool, Anak-Anak (SD & SMP), dan Dewasa. Kelas small group, Weekday & Weekend. Daftar sekarang!">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Kampung Inggris Karawaci II">
    <meta property="og:description"
        content="Belajar Bahasa Inggris menyenangkan untuk semua usia di Karawaci, Tangerang.">
    <meta property="og:image" content="<?= BASE_URL; ?>public/images/logo.png">
    <meta name="theme-color" content="#1e5ae0">

    <!-- Logo Perusahaan sebagai Icon / Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL; ?>public/images/logo.png">
    <link rel="apple-touch-icon" href="<?= BASE_URL; ?>public/images/logo.png">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- CSS Sendiri (internal, dari folder app) -->
    <style>
        <?php include __DIR__ . '/app/assets/css/style.css'; ?>
    </style>
</head>

<body>

    <!-- PRELOADER -->
    <div id="preloader" class="preloader">
        <div class="preloader-box">
            <img src="<?= BASE_URL; ?>public/images/logo.png" alt="Loading Kampung Inggris">
            <span class="preloader-spinner"></span>
            <span class="preloader-text">Memuat...</span>
        </div>
    </div>

    <!-- SCROLL PROGRESS -->
    <div id="scrollProgress" class="scroll-progress"></div>

    <!-- NAVBAR (template header) -->
    <?php include 'app/views/templates/header.php'; ?>

    <!-- KONTEN UTAMA -->
    <div class="site-wrap">
        <main>
            <?php include 'app/views/home.php'; ?>
        </main>

        <?php include 'app/views/templates/footer.php'; ?>
    </div>

    <!-- Tombol kembali ke atas -->
    <button type="button" id="backToTop" class="back-to-top" aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up-short"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Sendiri -->
    <script src="<?= BASE_URL; ?>public/js/script.js"></script>

</body>

</html>