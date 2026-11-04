<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

$name = '';
$username = '';
$email = '';
$error = '';

if (currentUser() !== null) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim((string) ($_POST['name'] ?? ''));
    $username = trim((string) ($_POST['username'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    $passwordConfirmation = (string) ($_POST['password_confirmation'] ?? '');

    if ($name === '' || $username === '' || $email === '' || $password === '') {
        $error = 'Semua field wajib diisi.';
    } elseif (!preg_match('/^[A-Za-z0-9._-]{3,30}$/', $username)) {
        $error = 'Username harus 3-30 karakter dan hanya boleh berisi huruf, angka, titik, garis bawah, atau strip.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal terdiri dari 6 karakter.';
    } elseif ($password !== $passwordConfirmation) {
        $error = 'Konfirmasi password tidak cocok.';
    } else {
        try {
            if (usernameOrEmailExists($username, $email)) {
                $error = 'Username atau email sudah digunakan.';
            } else {
                createUser($name, $username, $email, $password);
                session_regenerate_id(true);
                $_SESSION['user'] = ['username' => $username, 'name' => $name, 'role' => 'user'];
                header('Location: index.php');
                exit;
            }
        } catch (PDOException $exception) {
            $error = 'Akun gagal disimpan. Periksa koneksi dan struktur database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Jurusan TKR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --dark:#07131c; --red:#e51b23; --text:#101820; --muted:#68747b; --border:#dce2e5; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { align-items:center; background:linear-gradient(135deg,#07131c 0%,#10232e 55%,#f5f6f7 55%); color:var(--text); display:flex; font-family:"Poppins",sans-serif; justify-content:center; min-height:100vh; padding:24px; }
        .card { background:#fff; border-radius:18px; box-shadow:0 24px 60px rgba(7,19,28,.2); display:grid; grid-template-columns:minmax(230px,.75fr) minmax(320px,1.25fr); max-width:860px; overflow:hidden; width:100%; }
        .intro { background:var(--dark); color:#fff; padding:48px 38px; }
        .brand { align-items:center; display:flex; gap:12px; margin-bottom:78px; }
        .brand img { background:#fff; border-radius:8px; height:48px; object-fit:contain; padding:3px; width:48px; }
        .brand strong { font-size:19px; line-height:1.1; }
        .brand small { color:#aeb8bd; display:block; font-size:9px; letter-spacing:1.5px; margin-top:4px; }
        .intro h1 { font-size:clamp(29px,4vw,42px); line-height:1.1; margin-bottom:16px; }
        .intro h1 span { color:var(--red); display:block; }
        .intro p { color:#bfc9ce; font-size:13px; line-height:1.8; max-width:250px; }
        .form { padding:42px clamp(28px,6vw,64px); }
        .form h2 { font-size:27px; margin-bottom:8px; }
        .subtitle { color:var(--muted); font-size:13px; margin-bottom:22px; }
        .alert { background:#fff0f0; border-left:4px solid var(--red); color:#a9151b; font-size:12px; margin-bottom:18px; padding:11px 13px; }
        .field { margin-bottom:14px; }
        label { display:block; font-size:12px; font-weight:600; margin-bottom:7px; }
        input { border:1px solid var(--border); border-radius:8px; color:var(--text); font:inherit; font-size:13px; outline:none; padding:11px 14px; width:100%; }
        input:focus { border-color:var(--red); box-shadow:0 0 0 3px rgba(229,27,35,.12); }
        button { background:var(--red); border:0; border-radius:8px; color:#fff; cursor:pointer; font:inherit; font-size:13px; font-weight:600; margin-top:7px; padding:13px; width:100%; }
        button:hover { background:#c9151d; }
        .link { color:var(--muted); display:block; font-size:12px; margin-top:20px; text-align:center; text-decoration:none; }
        .link strong { color:var(--red); }
        @media (max-width:650px) { body { background:var(--dark); } .card { display:block; } .intro { padding:28px; } .brand { margin-bottom:38px; } .intro p { display:none; } .form { padding:32px 28px; } }
    </style>
</head>
<body>
    <main class="card">
        <section class="intro">
            <div class="brand"><img src="smk.png" alt="Logo SMK"><div><strong>JURUSAN TKR</strong><small>TEKNIK KENDARAAN RINGAN</small></div></div>
            <h1>Buat<br><span>Akun.</span></h1>
            <p>Daftarkan diri untuk mengakses informasi dan layanan Jurusan Teknik Kendaraan Ringan.</p>
        </section>
        <section class="form" aria-labelledby="register-title">
            <h2 id="register-title">Daftar Akun</h2>
            <p class="subtitle">Lengkapi data untuk membuat akun baru.</p>
            <?php if ($error !== ''): ?>
                <p class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <form method="post" action="daftar.php">
                <div class="field"><label for="name">Nama lengkap</label><input id="name" name="name" type="text" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>" placeholder="Masukkan nama lengkap" autocomplete="name" required></div>
                <div class="field"><label for="username">Username</label><input id="username" name="username" type="text" value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>" placeholder="Buat username" autocomplete="username" required></div>
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>" placeholder="nama@email.com" autocomplete="email" required></div>
                <div class="field"><label for="password">Password</label><input id="password" name="password" type="password" placeholder="Minimal 6 karakter" autocomplete="new-password" required></div>
                <div class="field"><label for="password_confirmation">Konfirmasi password</label><input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password" autocomplete="new-password" required></div>
                <button type="submit">Daftar</button>
            </form>
            <a class="link" href="login.php">Sudah punya akun? <strong>Login</strong></a>
        </section>
    </main>
</body>
</html>