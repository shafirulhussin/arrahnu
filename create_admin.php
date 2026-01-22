<?php
require __DIR__ . '/db.php';
$pdo->exec("CREATE TABLE IF NOT EXISTS roles (id INT AUTO_INCREMENT PRIMARY KEY, role_name VARCHAR(100) NOT NULL UNIQUE)");
$check = $pdo->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role_id'")->fetchColumn();
if (!$check) {
    $pdo->exec("ALTER TABLE users ADD COLUMN role_id INT NULL, ADD COLUMN status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active', ADD COLUMN last_login DATETIME NULL");
    $pdo->exec("ALTER TABLE users ADD CONSTRAINT fk_users_roles FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE SET NULL ON UPDATE CASCADE");
}
$nama = 'admin';
$ic = '000000-00-0000';
$no = '0000000000';
$hash = password_hash('admin123', PASSWORD_BCRYPT);
$roleStmt = $pdo->prepare("SELECT id FROM roles WHERE role_name = ?");
$roleStmt->execute(['Super Admin']);
$roleId = $roleStmt->fetchColumn();
if (!$roleId) {
    $pdo->prepare("INSERT INTO roles (role_name) VALUES (?)")->execute(['Super Admin']);
    $roleId = $pdo->lastInsertId();
}
$exists = $pdo->prepare("SELECT id FROM users WHERE nama = ? LIMIT 1");
$exists->execute([$nama]);
$id = $exists->fetchColumn();
if (!$id) {
    $ins = $pdo->prepare("INSERT INTO users (nama, ic, no_telefon, kata_laluan, role_id, status, last_login) VALUES (?, ?, ?, ?, ?, 'Active', NULL)");
    $ins->execute([$nama, $ic, $no, $hash, $roleId]);
    echo "User 'admin' created.";
} else {
    echo "User 'admin' already exists.";
}
