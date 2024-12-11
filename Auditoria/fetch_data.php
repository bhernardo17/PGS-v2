<?php
include '../db/connect.php';  // Inclui o arquivo de conexão ao banco de dados

ob_start();
// Array para armazenar os dados dos contratos
$data = [];

// Busca os contratos não arquivados
$query = $conn->query("
    SELECT DISTINCT aud.*,
        usu.nomeUsuario as usuario
    FROM auditoria aud
    LEFT JOIN usuario usu
        ON aud.idUsuario = usu.idUsuario
    ORDER BY aud.idInteracao DESC
    ");
while ($row = $query->fetch_assoc()) {
    $data[] = [
        'idUsuario' => $row['idUsuario'],
        'idInteracao' => $row['idInteracao'],
        'usuario' => $row['usuario'],
        'tipoInteracao' => $row['tipoInteracao'],
        'horaAuditoria' => $row['horaAuditoria'],
        'nomeDoAlvo' => $row['nomeDoAlvo']
    ];
}

// Retorna os dados em formato JSON
ob_clean(); // Limpa qualquer saída antes desta linha
header('Content-Type: application/json');
echo json_encode($data);


?>
