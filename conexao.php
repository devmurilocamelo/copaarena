<?php
$host    = 'localhost';
$usuario = 'root';
$senha   = '';
$banco   = 'copa_arena';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $usuario, $senha, $banco);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    die('Não foi possível conectar ao banco: ' . $e->getMessage());
}
