<?php
session_start();
require __DIR__ . '/db.php';
header('Content-Type: application/json');
$ic = isset($_POST['ic']) ? trim($_POST['ic']) : '';
if ($ic === '') { echo json_encode(['exists'=>false]); exit; }
$stmt = $pdo->prepare('SELECT id FROM customers WHERE ic = ? LIMIT 1');
$stmt->execute([$ic]);
$exists = $stmt->fetchColumn() ? true : false;
echo json_encode(['exists'=>$exists]);

