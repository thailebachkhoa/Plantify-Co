<?php
echo "BTL Framework Console Tool\n";
echo "===========================\n";

$command = $argv[1] ?? null;

if ($command === 'migrate') {
    require_once __DIR__ . '/app/Core/Env.php';
    Env::load(__DIR__ . '/.env');

    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $port = $_ENV['DB_PORT'] ?? '3306';
    $username = $_ENV['DB_USERNAME'] ?? 'root';
    $password = $_ENV['DB_PASSWORD'] ?? '';

    echo "[!] Dang thuc hien connect len server MySQL ({$host}:{$port})...\n";
    try {
        $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $sqlFile = __DIR__ . '/database/migrations/schema.sql';
        if (!file_exists($sqlFile)) {
            die("[-] Khong tim thay file schema.sql!\n");
        }

        $sql = file_get_contents($sqlFile);
        $pdo->exec($sql);

        echo "[+] Thanh cong! Co so du lieu va cac bang da duoc tao (hoac cap nhat).\n";
        echo "[+] Tài khoản Test: admin (Pass: 123456) | thanhvien (Pass: 123456)\n";
    } catch (PDOException $e) {
        echo "[-] Loi trang thai: " . $e->getMessage() . "\n";
        if (strpos($e->getMessage(), 'Access denied') !== false) {
            echo "(!) Vui long kiem tra file .env, co the thong tin user/pass sai.\n";
        }
    }
} else {
    echo "Su dung: php console.php migrate\n";
}
