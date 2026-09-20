<?php
require_once __DIR__ . '/app/config/Bootstrap.php';
require_once __DIR__ . '/app/models/Pendaftaran.php';

$db = Database::getInstance();
$isReady = $db->isReady();
$model = $isReady ? new Pendaftaran() : null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'], $_POST['id'], $_POST['status'])) {
    $allowed = ['baru', 'diproses', 'selesai'];
    if (in_array($_POST['status'], $allowed, true) && $model) {
        $model->updateStatus($_POST['id'], $_POST['status']);
        header('Location: ' . BASE_URL . 'admin.php');
        exit;
    }
}

$registrations = $model ? $model->all() : [];

$kategoriLabel = [
    'preschool' => 'Preschool',
    'anak_anak' => 'Anak-Anak (SD & SMP)',
    'dewasa'    => 'Dewasa',
];

$jadwalLabel = ['weekday' => 'Weekday', 'weekend' => 'Weekend'];

$statusBadge = [
    'baru'     => ['bg-primary', 'Baru'],
    'diproses' => ['bg-warning text-dark', 'Diproses'],
    'selesai'  => ['bg-success', 'Selesai'],
];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Pendaftar | Kampung Inggris Karawaci II</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        <?php include __DIR__ . '/app/assets/css/style.css'; ?>
    </style>
</head>

<body class="bg-light">

    <nav class="navbar" style="background:#101a33;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="#">
                <div class="logo-box me-2"><i class="bi bi-person-gear text-white"></i></div>
                Admin Pendaftaran
            </a>
            <div>
                <a href="<?= BASE_URL; ?>" class="btn btn-outline-light btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali ke Website</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">

        <?php if (!$isReady): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Database tidak terhubung: <?= htmlspecialchars($db->getError()); ?>
            </div>
        <?php else: ?>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Data Pendaftar <span class="badge bg-primary"><?= count($registrations); ?></span></h4>
                <button class="btn btn-sm btn-outline-secondary" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                </button>
            </div>

            <?php if (empty($registrations)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-3 text-secondary"></i>
                    <p class="text-secondary mt-3 mb-0">Belum ada pendaftar.</p>
                </div>
            <?php else: ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle bg-white shadow-sm rounded">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>WhatsApp</th>
                                <th>Paket</th>
                                <th>Jadwal</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $row): ?>
                                <tr>
                                    <td><?= $row['id']; ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['nama']); ?></td>
                                    <td>
                                        <a href="https://wa.me/62<?= ltrim(preg_replace('/\D/', '', $row['whatsapp']), '0'); ?>"
                                            target="_blank" class="text-decoration-none">
                                            <?= htmlspecialchars($row['whatsapp']); ?>
                                            <i class="bi bi-whatsapp text-success ms-1"></i>
                                        </a>
                                    </td>
                                    <td><?= $kategoriLabel[$row['kategori']] ?? $row['kategori']; ?></td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <?= $jadwalLabel[$row['jadwal']] ?? $row['jadwal']; ?>
                                        </span>
                                    </td>
                                    <td class="text-truncate" style="max-width:180px;" title="<?= htmlspecialchars($row['pesan'] ?? ''); ?>">
                                        <?= $row['pesan'] ? htmlspecialchars($row['pesan']) : '<span class="text-secondary">-</span>'; ?>
                                    </td>
                                    <td class="text-secondary small">
                                        <?= date('d M Y, H:i', strtotime($row['created_at'])); ?>
                                    </td>
                                    <td>
                                        <?php $sb = $statusBadge[$row['status']]; ?>
                                        <span class="badge <?= $sb[0]; ?>"><?= $sb[1]; ?></span>
                                    </td>
                                    <td>
                                        <form method="post" class="d-flex gap-1">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <input type="hidden" name="update_status" value="1">
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <?php foreach ($statusBadge as $key => $item): ?>
                                                    <option value="<?= $key; ?>" <?= $row['status'] === $key ? 'selected' : ''; ?>>
                                                        <?= $item[1]; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>