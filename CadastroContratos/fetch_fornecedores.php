<?php
include '../db/connect.php'; 

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$data = [];

$query = $conn->query("
    SELECT DISTINCT nomeFornecedor 
    FROM fornecedor
    ORDER BY nomeFornecedor ASC
");

if ($query) {
    while ($row = $query->fetch_assoc()) {
        $data[] = [
            'nomeFornecedor' => $row['nomeFornecedor']
        ];
    }
} else {
    echo "Erro na consulta: " . $conn->error;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
