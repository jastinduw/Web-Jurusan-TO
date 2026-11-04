<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';
requireAdmin();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $role = (string) ($_POST['role'] ?? '');

    if ($username === (string) currentUser()['username']) {
        $error = 'Role akun admin yang sedang digunakan tidak dapat diubah.';
    } else {
        try {
            updateUserRole($username, $role);
        } catch (InvalidArgumentException | PDOException $exception) {
            $error = 'Role gagal diperbarui.';
        }
    }
}

try {
    $users = getAdminUsers();
} catch (PDOException $exception) {
    $users = [];
    $error = 'Data akun tidak dapat dimuat.';
}

$adminCount = count(array_filter($users, static fn (array $account): bool => $account['role'] === 'admin'));
$userCount = count($users) - $adminCount;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Jurusan TKR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --dark:#07131c; --red:#e51b23; --muted:#68747b; --line:#e4e9eb; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { background:#f5f6f7; color:#101820; font-family:"Poppins",sans-serif; min-height:100vh; }
        header { align-items:center; background:var(--dark); color:#fff; display:flex; justify-content:space-between; padding:20px 7%; }
        header strong { font-size:20px; } header span { color:#aeb8bd; font-size:12px; }
        header a { color:#fff; font-size:12px; text-decoration:none; } header a:hover { color:#ff5a5f; }
        main { margin:42px auto; max-width:1100px; padding:0 24px; }
        .heading { margin-bottom:24px; } h1 { font-size:30px; } .heading p { color:var(--muted); font-size:13px; }
        .stats { display:grid; gap:18px; grid-template-columns:repeat(3, minmax(0, 1fr)); margin-bottom:24px; }
        .stat, .panel { background:#fff; border-radius:12px; box-shadow:0 8px 25px rgba(7,19,28,.06); }
        .stat { border-left:4px solid var(--red); padding:20px; } .stat small { color:var(--muted); display:block; font-size:12px; } .stat strong { font-size:28px; }
        .panel { overflow:hidden; padding:22px; } .panel h2 { font-size:18px; margin-bottom:18px; }
        .alert { background:#fff0f0; border-left:4px solid var(--red); color:#a9151b; font-size:12px; margin-bottom:18px; padding:11px 13px; }
        .table-wrap { overflow-x:auto; } table { border-collapse:collapse; min-width:650px; width:100%; } th, td { border-bottom:1px solid var(--line); padding:13px 10px; text-align:left; } th { color:var(--muted); font-size:11px; text-transform:uppercase; } td { font-size:13px; }
        .badge { background:#e9f7ed; border-radius:20px; color:#197438; font-size:11px; padding:5px 10px; } .badge.admin { background:#fff0f0; color:#b5161c; }
        select, button { border:1px solid var(--line); border-radius:6px; font:inherit; font-size:12px; padding:7px 9px; } button { background:var(--red); border:0; color:#fff; cursor:pointer; margin-left:5px; } button:hover { background:#c9151d; }
        @media (max-width:800px) { .stats { grid-template-columns:repeat(2, minmax(0, 1fr)); } }
        @media (max-width:600px) { header { align-items:flex-start; flex-direction:column; gap:10px; } .stats { grid-template-columns:1fr; } main { margin-top:28px; } }
    </style>
</head>
<body>
    <header>
        <div><strong>Panel Admin</strong><br><span>Jurusan Teknik Kendaraan Ringan</span></div>
        <a href="index.php">← Kembali ke halaman utama</a>
    </header>
    <main>
        <div class="heading"><h1>Dashboard Admin</h1><p>Kelola role akun pengguna website.</p></div>
        <?php if ($error !== ''): ?><p class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
        <section class="stats">
            <div class="stat"><small>Total akun</small><strong><?= count($users) ?></strong></div>
            <div class="stat"><small>Total admin</small><strong><?= $adminCount ?></strong></div>
            <div class="stat"><small>Total user</small><strong><?= $userCount ?></strong></div>
        </section>
        <section class="panel">
            <h2>Daftar Akun</h2>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Aksi</th></tr></thead>
                    <tbody>
                    <?php foreach ($users as $account): ?>
                        <tr>
                            <td><?= htmlspecialchars((string) $account['Nama_Lengkap'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) $account['username'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars((string) $account['Email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><span class="badge <?= $account['role'] === 'admin' ? 'admin' : '' ?>"><?= htmlspecialchars((string) $account['role'], ENT_QUOTES, 'UTF-8') ?></span></td>
                            <td>
                                <?php if ($account['username'] !== currentUser()['username']): ?>
                                    <form method="post">
                                        <input type="hidden" name="username" value="<?= htmlspecialchars((string) $account['username'], ENT_QUOTES, 'UTF-8') ?>">
                                        <select name="role" aria-label="Role akun">
                                            <option value="user" <?= $account['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                            <option value="admin" <?= $account['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                        <button type="submit">Simpan</button>
                                    </form>
                                <?php else: ?>Akun aktif<?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
