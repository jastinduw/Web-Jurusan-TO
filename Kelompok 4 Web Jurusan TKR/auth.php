<?php
declare(strict_types=1);

session_start();

const DB_HOST = '127.0.0.1';
const DB_NAME = 'db_website_jurusan_to';
const DB_USER = 'root';
const DB_PASSWORD = '';

function database(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $connection = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    $columnCheck = $connection->prepare(
        'SELECT COUNT(*)
         FROM INFORMATION_SCHEMA.COLUMNS
         WHERE TABLE_SCHEMA = :database
           AND TABLE_NAME = :table
           AND COLUMN_NAME = :column'
    );
    $columnCheck->execute([
        'database' => DB_NAME,
        'table' => 'akun_admin',
        'column' => 'role',
    ]);

    if ((int) $columnCheck->fetchColumn() === 0) {
        $connection->exec(
            "ALTER TABLE `akun_admin`
             ADD COLUMN `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user'
             AFTER `Password`"
        );
    }

    return $connection;
}

function currentUser(): ?array
{
    return isset($_SESSION['user']) && is_array($_SESSION['user'])
        ? $_SESSION['user']
        : null;
}

function findUser(string $username, string $email): ?array
{
    $statement = database()->prepare(
        'SELECT `Nama_Lengkap`, `username`, `Email`, `Password`, `role`
         FROM `akun_admin`
         WHERE `username` = :username AND `Email` = :email
         LIMIT 1'
    );
    $statement->execute(['username' => $username, 'email' => $email]);
    $user = $statement->fetch();

    return $user === false ? null : $user;
}

function usernameOrEmailExists(string $username, string $email): bool
{
    $statement = database()->prepare(
        'SELECT 1
         FROM `akun_admin`
         WHERE `username` = :username OR `Email` = :email
         LIMIT 1'
    );
    $statement->execute(['username' => $username, 'email' => $email]);

    return $statement->fetchColumn() !== false;
}

function createUser(string $name, string $username, string $email, string $password): void
{
    $statement = database()->prepare(
        'INSERT INTO `akun_admin` (`Nama_Lengkap`, `username`, `Email`, `Password`, `role`)
         VALUES (:name, :username, :email, :password, :role)'
    );
    $statement->execute([
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => 'user',
    ]);
}

function isAdmin(): bool
{
    $user = currentUser();
    return $user !== null && currentRole() === 'admin';
}

function currentRole(): string
{
    $user = currentUser();
    return $user !== null && ($user['role'] ?? '') === 'admin'
        ? 'admin'
        : 'user';
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: index.php');
        exit;
    }
}

function getAdminUsers(): array
{
    $statement = database()->query(
        'SELECT `Nama_Lengkap`, `username`, `Email`, `role`
         FROM `akun_admin`
         ORDER BY `Nama_Lengkap` ASC'
    );

    return $statement->fetchAll();
}

function updateUserRole(string $username, string $role): void
{
    if (!in_array($role, ['admin', 'user'], true)) {
        throw new InvalidArgumentException('Role tidak valid.');
    }

    $statement = database()->prepare(
        'UPDATE `akun_admin` SET `role` = :role WHERE `username` = :username'
    );
    $statement->execute(['role' => $role, 'username' => $username]);
}
