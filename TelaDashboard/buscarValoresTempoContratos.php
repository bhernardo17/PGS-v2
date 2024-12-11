<?php
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$gdb->open('SELECT c.idContrato, c.vigenciaInicial, c.vigenciaFinal, c.custoAnual
            FROM contratos c');

$result = $gdb->gs;

$data = [];
foreach ($result as $row) {
    $idContrato = $row['idContrato'];
    $vigenciaInicial = $row['vigenciaInicial'];
    $vigenciaFinal = $row['vigenciaFinal'];
    $custoAnual = $row['custoAnual'];

    // Calcular a duração do contrato em dias
    $duration = (strtotime($vigenciaFinal) - strtotime($vigenciaInicial)) / (60 * 60 * 24);

    $data[] = [
        'idContrato' => $idContrato,
        'vigenciaInicial' => $vigenciaInicial,
        'vigenciaFinal' => $vigenciaFinal,
        'custoAnual' => $custoAnual,
        'duration' => $duration
    ];
}

echo json_encode($data);
?>
