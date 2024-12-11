<?php
include '../../db/connect.php'; 
$data = [];

$query = $conn->query("
    SELECT 
    supervisores.nomeSupervisor, 
    supervisores.emailSupervisor, 
    supervisores.matriculaSupervisor, 
    supervisores.idSecretaria, 
    supervisores.telefoneSupervisor,
    secretarias.nomeSecretaria,
    supervisores.idSupervisor
FROM 
    supervisores
JOIN 
    secretarias ON supervisores.idSecretaria = secretarias.idSecretaria
ORDER BY 
    supervisores.nomeSupervisor ASC;
");

while ($row = $query->fetch_assoc()) {
    $data['supervisores'][] = [
        'nomeSupervisor' => $row['nomeSupervisor'],
        'emailSupervisor' => $row['emailSupervisor'],
        'matriculaSupervisor' => $row['matriculaSupervisor'],
        'idSecretaria' => $row['idSecretaria'],
        'telefoneSupervisor' => $row['telefoneSupervisor'],
        'nomeSecretaria' => $row['nomeSecretaria'],
        'idSupervisor' => $row['idSupervisor']
    ];
}

$query = $conn->query("
    SELECT 
        fornecedor.nomeFornecedor,
        fornecedor.razaoFornecedor,
        fornecedor.cnpjFornecedor,
        fornecedor.idFornecedor,
        fornecedor.suporteFornecedor,
        fornecedor.emailFornecedor
    FROM 
        fornecedor
    ORDER BY
        fornecedor.nomeFornecedor ASC;
");

while ($row = $query->fetch_assoc()) {
    $data['fornecedor'][] =[
        'nomeFornecedor' => $row['nomeFornecedor'],
        'razaoFornecedor'  => $row['razaoFornecedor'],
        'cnpjFornecedor' => $row['cnpjFornecedor'],
        'idFornecedor' => $row['idFornecedor'],
        'suporteFornecedor' => $row['suporteFornecedor'],
        'emailFornecedor' => $row['emailFornecedor']
    ];
}

$query = $conn->query("
    SELECT 
    secretarias.nomeSecretaria,
    secretarias.siglaSecretaria,
    secretarias.enderecoSecretaria,
    secretarias.telefoneSecretaria, 
    secretarias.idSecretaria
FROM 
    secretarias
ORDER BY 
    secretarias.nomeSecretaria ASC;
");

while ($row = $query->fetch_assoc()) {
    $data['secretarias'][] = [
        'nomeSecretaria' => $row['nomeSecretaria'],
        'siglaSecretaria'=> $row['siglaSecretaria'],
        'enderecoSecretaria'=> $row['enderecoSecretaria'],
        'telefoneSecretaria'=> $row['telefoneSecretaria'],
        'idSecretaria' => $row['idSecretaria']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
