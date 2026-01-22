<?php
session_start();
require __DIR__ . '/db.php';
$ic = isset($_POST['ic']) ? trim($_POST['ic']) : '';
$password = isset($_POST['kata_laluan']) ? $_POST['kata_laluan'] : '';
if ($ic === '' || $password === '') {
    header('Location: login.php?error=Ruangan tidak lengkap');
    exit;
}
$stmt = $pdo->prepare('SELECT u.id,u.nama,u.ic,u.kata_laluan,u.role_id,u.status,r.role_name FROM users u LEFT JOIN roles r ON r.id=u.role_id WHERE u.ic=? LIMIT 1');
$stmt->execute([$ic]);
$user = $stmt->fetch();
if (!$user) {
    header('Location: login.php?error=Pengguna tidak wujud');
    exit;
}
if ($user['status'] !== 'Active') {
    header('Location: login.php?error=Akaun tidak aktif');
    exit;
}
if (!password_verify($password, $user['kata_laluan'])) {
    header('Location: login.php?error=Kata laluan salah');
    exit;
}
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['nama'] = $user['nama'];
$_SESSION['role_id'] = $user['role_id'];
$_SESSION['role_name'] = $user['role_name'];
$pdo->prepare('UPDATE users SET last_login = NOW() WHERE id=?')->execute([$user['id']]);
header('Location: dashboard.php');
exit;

