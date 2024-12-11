<?php
include '../db/connect.php'; 

if (!$conn) {
    die("Erro de conexão: " . mysqli_connect_error());
}

$data = [];

$query = $conn->query("
    SELECT DISTINCT sup.nomeSupervisor 
    FROM supervisores sup
    ORDER BY sup.nomeSupervisor ASC
");

if ($query) {
    while ($row = $query->fetch_assoc()) {
        $data[] = [
            'nomeSupervisor' => $row['nomeSupervisor']
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Erro na consulta: ' . $conn->error]);
}
?>
