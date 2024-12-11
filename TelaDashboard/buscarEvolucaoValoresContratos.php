<?php
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

// Obter o ano atual
$anoAtual = date('Y');

$anoAnterior = $anoAtual - 1;

// Construir a consulta SQL
$query = "
SELECT 
    YEAR(dt_referencia) AS ano,
    MONTH(dt_referencia) AS mes,
    SUM(
        IF(
            dt_referencia BETWEEN vigenciaInicial AND vigenciaFinal, 
            custoMensal, 
            0
        )
    ) AS totalValorMensal,
    COUNT(DISTINCT contratos.idContrato) AS qtdContratos
FROM (
    SELECT LAST_DAY(CONCAT('$anoAtual-01-01')) AS dt_referencia
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-02-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-03-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-04-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-05-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-06-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-07-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-08-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-09-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-10-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-11-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-12-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-01-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-02-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-03-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-04-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-05-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-06-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-07-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-08-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-09-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-10-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-11-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAnterior-12-01'))
) AS datas_referencia
LEFT JOIN contratos
ON dt_referencia BETWEEN vigenciaInicial AND vigenciaFinal
WHERE 
    (YEAR(vigenciaInicial) <= $anoAtual AND YEAR(vigenciaFinal) >= $anoAnterior)
GROUP BY 
    YEAR(dt_referencia), MONTH(dt_referencia)
ORDER BY 
    ano, mes;
";

// Executar a consulta
$gdb->open($query);

// Preparar o resultado para ser enviado como JSON
$data = [];
if ($gdb->linhas > 0) {
    foreach ($gdb->gs['ANO'] as $i => $ano) {
        $mes = $gdb->gs['MES'][$i];
        $totalValorMensal = $gdb->gs['TOTALVALORMENSAL'][$i];
        $qtdContratos = $gdb->gs['QTDCONTRATOS'][$i];
        $data[] = [
            'ano' => $ano,
            'mes' => $mes,
            'totalValorMensal' => $totalValorMensal,
            'qtdContratos' => $qtdContratos
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($data);

error_log(print_r($data, true));
?>
