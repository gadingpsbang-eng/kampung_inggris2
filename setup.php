<?php
// Halaman diagnosa: cek lingkungan, konfigurasi, dan koneksi database.
// HAPUS/AMANKAN file ini sebelum website dipublikasikan!

require_once __DIR__ . '/app/config/Bootstrap.php';

$config = require __DIR__ . '/app/config/config.php';
$db = $config['db'];

$dbOk = false;
$dbMsg = '';
$tableOk = false;
$count = null;

$dbObj = Database::getInstance();
if ($dbObj->isReady()) {
    $dbOk = true;
    try {
        $count = $dbObj->getPdo()->query('SELECT COUNT(*) AS c FROM pendaftaran')->fetch()['c'];
        $tableOk = true;
    } catch (Throwable $e) {
        $dbMsg = 'Gagal query tabel: ' . $e->getMessage();
    }
} else {
    $dbMsg = $dbObj->getError() ?: 'Koneksi gagal.';
}

$host = $_SERVER['HTTP_HOST'] ?? '(tidak diketahui)';
$isLocal = is_localhost() ? 'LOKAL' : 'HOSTING (INFINITY & sejenis)';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnosa Website | Kampung Inggris</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f6f8fc; color: #16213c; margin: 0; padding: 24px; }
        .box { max-width: 760px; margin: 0 auto; background: #fff; border-radius: 16px; padding: 24px 28px; box-shadow: 0 10px 30px rgba(22,33,60,.08); }
        h1 { font-size: 1.4rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        td, th { text-align: left; padding: 10px 8px; border-bottom: 1px solid #eef1f8; font-size: .92rem; }
        th { color: #667085; font-weight: 600; width: 38%; }
        .ok { color: #16a34a; font-weight: 700; }
        .no { color: #dc2626; font-weight: 700; }
        code { background: #eef1f8; padding: 2px 6px; border-radius: 6px; font-size: .85em; }
        .tip { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; padding: 12px 14px; margin-top: 16px; font-size: .9rem; color: #9a3412; }
    </style>
</head>

<body>
    <div class="box">
        <h1>🔍 Diagnosa Website — Kampung Inggris Karawaci II</h1>
        <table>
            <tr><th>PHP Version</th><td><?= PHP_VERSION; ?></td></tr>
            <tr><th>Lingkungan</th><td><span class="<?= $isLocal === 'HOSTING (INFINITY & sejenis)' ? 'no' : 'ok'; ?>"><?= $isLocal; ?></span></td></tr>
            <tr><th>Domain</th><td><?= htmlspecialchars($host); ?></td></tr>
            <tr><th>BASE_URL terdeteksi</th><td><code><?= htmlspecialchars(BASE_URL); ?></code></td></tr>
            <tr><th>Letak folder</th><td><code><?= htmlspecialchars(str_replace('\\', '/', __DIR__)); ?></code></td></tr>
            <tr><th>Sitemap URL saya</th><td>Silakan buka <code><?= htmlspecialchars(BASE_URL); ?>index.php</code></td></tr>
        </table>

        <h2 style="margin-top:24px;font-size:1.1rem;">Database</h2>
        <table>
            <tr><th>Host (config)</th><td><code><?= htmlspecialchars($db['host']); ?></code></td></tr>
            <tr><th>User (config)</th><td><code><?= htmlspecialchars($db['user']); ?></code></td></tr>
            <tr><th>Nama DB (config)</th><td><code><?= htmlspecialchars($db['name']); ?></code></td></tr>
            <tr><th>Koneksi</th>
                <td><?php if ($dbOk): ?><span class="ok">✅ Berhasil</span>
                    <?php else: ?><span class="no">❌ Gagal</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php if (!$dbOk && $dbMsg): ?>
                <tr><th>Pesan error</th><td class="no"><?= htmlspecialchars($dbMsg); ?></td></tr>
            <?php endif; ?>
            <tr><th>Tabel pendaftaran</th>
                <td><?php if ($tableOk): ?><span class="ok">✅ Ada (<?= (int)$count; ?> data)</span>
                    <?php else: ?><span class="no">❌ <?= htmlspecialchars($dbMsg); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <?php if (!$dbOk || !$tableOk): ?>
            <div class="tip">
                <strong>Cara mengisi database untuk InfinityFree:</strong><br>
                1. Masuk ke <em>cp.infinityfree.com</em> → menu <strong>Manage Databases</strong>.<br>
                2. Salin <strong>host</strong>, <strong>username</strong> (mis. <code>if0_12345678</code>),
                dan buat <strong>password</strong> sendiri.<br>
                3. Buka <code>app/config/config.php</code>, lalu isi bagian DB yang ber-tanda
                <em>"UNTUK HOSTING INFINITY"</em> dengan data tersebut (hapus tanda <code>#</code>).<br>
                4. Simpan &amp; muat ulang halaman ini.
            </div>
        <?php endif; ?>

        <p style="margin-top:20px;font-size:.85rem;color:#98a1b8;">
            ⚠️ Hapus file <code>setup.php</code> sebelum situs dipublikasikan agar info server tidak bocor.
        </p>
    </div>
</body>

</html>