<?php
include '../db/connect.php';  // Inclui o arquivo de conexão ao banco de dados

ob_start();
// Array para armazenar os dados dos contratos
$data = [];

// Busca os contratos não arquivados
$query = $conn->query("SELECT * FROM contratos WHERE arquivado = 1 ORDER BY nomeUsual ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = [
        'idContrato' => $row['idContrato'],
        'nomeUsual' => $row['nomeUsual'],
        'nomeComercial' => $row['nomeComercial']
    ];
}

// Retorna os dados em formato JSON
ob_clean(); // Limpa qualquer saída antes desta linha
header('Content-Type: application/json');
echo json_encode($data);


?>
