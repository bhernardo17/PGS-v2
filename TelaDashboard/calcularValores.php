<?php
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

// Obter o ano atual
$anoAtual = date('Y');

// Executar a consulta ajustada
$query = "
SELECT 
    YEAR(dt_referencia) AS ano,
    MONTH(dt_referencia) AS mes,
    SUM(
        CASE
            WHEN vigenciaInicial <= LAST_DAY(dt_referencia) 
                 AND vigenciaFinal >= FIRST_DAY(dt_referencia)
            THEN
                (DATEDIFF(LEAST(vigenciaFinal, LAST_DAY(dt_referencia)), GREATEST(vigenciaInicial, FIRST_DAY(dt_referencia))) + 1) / DATEDIFF(vigenciaFinal, vigenciaInicial) * custoAnual
            ELSE 0
        END
    ) AS valorMensal
FROM (
    SELECT 
        LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()), 2, '0'), '-01')) AS dt_referencia
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 1, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 2, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 3, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 4, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 5, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 6, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 7, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 8, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 9, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 10, 2, '0'), '-01'))
    UNION ALL SELECT LAST_DAY(CONCAT('$anoAtual-', LPAD(MONTH(NOW()) + 11, 2, '0'), '-01'))
) AS datas_referencia
LEFT JOIN contratos
ON dt_referencia BETWEEN vigenciaInicial AND vigenciaFinal
WHERE 
    contratos.arquivado = 0
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
        $valorMensal = $gdb->gs['VALORMENSAL'][$i];
        $data[] = [
            'ano' => $ano,
            'mes' => $mes,
            'valorMensal' => $valorMensal
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
