<?php
include '../db/connect.php';  // Inclui o arquivo de conexão ao banco de dados

ob_start();
// Array para armazenar os dados dos contratos
$data = [];

// Busca os contratos não arquivados
$query = $conn->query("
    SELECT DISTINCT usu.*, 
        sec.nomeSecretaria AS secretaria
    FROM usuario usu
    LEFT JOIN secretarias sec
        ON sec.idSecretaria = usu.idSecretaria
    ORDER BY usu.nomeUsuario ASC
    ");
while ($row = $query->fetch_assoc()) {
    $data[] = [
        'idUsuario' => $row['idUsuario'],
        'idSecretaria' => $row['idSecretaria'],
        'secretaria' => $row['secretaria'],
        'nomeUsuario' => $row['nomeUsuario'],
        'matriculaUsuario' => $row['matriculaUsuario'],
        'acessoUsuario' => $row['acessoUsuario'],
        'permissaoUsuario' => $row['permissaoUsuario'],
        'telefone' => $row['telefone'],
        'emailUsuario' => $row['emailUsuario']
    ];
}

// Retorna os dados em formato JSON
ob_clean(); // Limpa qualquer saída antes desta linha
header('Content-Type: application/json');
echo json_encode($data);


?>
