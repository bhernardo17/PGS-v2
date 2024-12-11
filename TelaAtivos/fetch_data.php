<?php
include '../db/connect.php';  // Inclui o arquivo de conexão ao banco de dados

ob_start();
// Array para armazenar os dados dos contratos
$data = [];

// Busca os contratos não arquivados
$query = $conn->query(" SELECT DISTINCT con.*,
                        forn.nomeFornecedor as fornecedor
                        FROM contratos con
                        LEFT JOIN fornecedor forn
                            ON forn.idFornecedor = con.idFornecedor   
                        WHERE con.arquivado = 0 
                        ORDER BY con.nomeUsual ASC
                    ");

while ($row = $query->fetch_assoc()) {
    $data[] = [
        'idContrato' => $row['idContrato'],
        'vigenciaInicial' => $row['vigenciaInicial'],
        'vigenciaFinal' => $row['vigenciaFinal'],
        'custoAnual' => $row['custoAnual'],
        'custoMensal' => $row['custoMensal'],
        'infoContratuais' => $row['infoContratuais'],
        'observacaoContrato' => $row['observacaoContrato'],
        'objetoContrato' => $row['objetoContrato'],
        'nomeUsual' => $row['nomeUsual'],
        'nomeComercial' => $row['nomeComercial'],
        'classificacaoContrato' => $row['classificacaoContrato'],
        'idFornecedor' => $row['idFornecedor'],
        'fornecedor' => $row['fornecedor'],
        'dotacao' => $row['dotacao']
    ];
}

// Retorna os dados em formato JSON
ob_clean(); // Limpa qualquer saída antes desta linha
header('Content-Type: application/json');
echo json_encode($data);


?>
