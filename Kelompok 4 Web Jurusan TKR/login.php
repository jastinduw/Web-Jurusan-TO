<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'auth.php';

$username = '';
$email = '';
$error = '';

if (currentUser() !== null) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($username === '' || $email === '' || $password === '') {
        $error = 'Username, email, dan password wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        try {
            $account = findUser($username, $email);
            if ($account === null || !password_verify($password, (string) $account['Password'])) {
                $error = 'Username atau password salah.';
            } else {
                session_regenerate_id(true);
                $_SESSION['user'] = [
                    'username' => (string) $account['username'],
                    'name' => (string) $account['Nama_Lengkap'],
                    'role' => (string) ($account['role'] ?? 'user'),
                ];
                header('Location: index.php');
                exit;
            }
        } catch (PDOException $exception) {
            $error = 'Database tidak dapat diakses. Periksa konfigurasi koneksi.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Jurusan TKR</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark: #07131c;
            --dark-soft: #10232e;
            --red: #e51b23;
            --text: #101820;
            --muted: #68747b;
            --border: #dce2e5;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            align-items: center;
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark-soft) 55%, #f5f6f7 55%, #f5f6f7 100%);
            color: var(--text);
            display: flex;
            font-family: "Poppins", sans-serif;
            justify-content: center;
            min-height: 100vh;
            padding: 24px;
        }

        .login-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 24px 60px rgba(7, 19, 28, .2);
            display: grid;
            grid-template-columns: minmax(230px, .75fr) minmax(320px, 1.25fr);
            max-width: 860px;
            overflow: hidden;
            width: 100%;
        }

        .login-intro {
            background: var(--dark);
            color: #fff;
            padding: 48px 38px;
        }

        .brand {
            align-items: center;
            display: flex;
            gap: 12px;
            margin-bottom: 78px;
        }

        .brand img {
            background: #fff;
            border-radius: 8px;
            height: 48px;
            object-fit: contain;
            padding: 3px;
            width: 48px;
        }

        .brand strong {
            font-size: 19px;
            line-height: 1.1;
        }

        .brand small {
            color: #aeb8bd;
            display: block;
            font-size: 9px;
            letter-spacing: 1.5px;
            margin-top: 4px;
        }

        .login-intro h1 {
            font-size: clamp(29px, 4vw, 42px);
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .login-intro h1 span {
            color: var(--red);
            display: block;
        }

        .login-intro p {
            color: #bfc9ce;
            font-size: 13px;
            line-height: 1.8;
            max-width: 250px;
        }

        .login-form {
            padding: 42px clamp(28px, 6vw, 64px);
        }

        .login-form h2 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 22px;
        }

        .alert {
            background: #fff0f0;
            border-left: 4px solid var(--red);
            color: #a9151b;
            font-size: 12px;
            margin-bottom: 18px;
            padding: 11px 13px;
        }

        .field {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input {
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font: inherit;
            font-size: 13px;
            outline: none;
            padding: 11px 14px;
            width: 100%;
        }

        input:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 3px rgba(229, 27, 35, .12);
        }

        .form-options {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin: 2px 0 14px;
        }

        .remember {
            align-items: center;
            color: var(--muted);
            display: flex;
            font-size: 11px;
            gap: 7px;
        }

        .remember input {
            accent-color: var(--red);
            height: 15px;
            width: 15px;
        }

        .forgot {
            color: var(--red);
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
        }

        .submit-button {
            background: var(--red);
            border: 0;
            border-radius: 8px;
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-size: 13px;
            font-weight: 600;
            margin-top: 7px;
            padding: 13px;
            width: 100%;
        }

        .submit-button:hover {
            background: #c9151d;
        }

        .back-link {
            color: var(--muted);
            display: block;
            font-size: 12px;
            margin-top: 22px;
            text-align: center;
            text-decoration: none;
        }

        .back-link:hover,
        .forgot:hover {
            text-decoration: underline;
        }

        @media (max-width: 650px) {
            body {
                background: var(--dark);
            }

            .login-card {
                display: block;
            }

            .login-intro {
                padding: 28px;
            }

            .brand {
                margin-bottom: 38px;
            }

            .login-intro p {
                display: none;
            }

            .login-form {
                padding: 32px 28px;
            }
        }
    </style>
</head>

<body>
    <main class="login-card">
        <section class="login-intro" aria-label="Informasi jurusan">
            <div class="brand">
                <img src="smk.png" alt="Logo SMK">
                <div>
                    <strong>JURUSAN TKR</strong>
                    <small>TEKNIK KENDARAAN RINGAN</small>
                </div>
            </div>

            <h1>Selamat<br><span>Datang.</span></h1>
            <p>Masuk untuk mengakses informasi dan layanan Jurusan Teknik Kendaraan Ringan.</p>
        </section>

        <section class="login-form" aria-labelledby="login-title">
            <h2 id="login-title">Masuk ke Akun</h2>
            <p class="subtitle">Silakan masukkan data akun Anda.</p>

            <?php if ($error !== ''): ?>
                <p class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form method="post" action="login.php">
                <div class="field">
                    <label for="username">Username</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="Masukkan username"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="Masukkan email"
                        autocomplete="email"
                        required
                    >
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Ingat saya
                    </label>
                    <a class="forgot" href="mailto:admin@jurusantkr.sch.id">Lupa password?</a>
                </div>

                <button class="submit-button" type="submit">Masuk</button>
            </form>

            <a class="back-link" href="index.php">← Kembali ke halaman utama</a>
        </section>
    </main>
</body>

</html>