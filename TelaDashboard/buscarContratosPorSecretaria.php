<?php
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$query = 'SELECT COALESCE(s.siglaSecretaria, "Desconhecido") AS siglaSecretaria,
                 COUNT(DISTINCT c.idContrato) AS quantidadeContratos,
                 GROUP_CONCAT(c.nomeUsual ORDER BY c.nomeUsual SEPARATOR "|") AS nomesContratos
          FROM contratos c
          LEFT JOIN (
              SELECT DISTINCT idContrato, idSecretaria
              FROM contratoXsecretaria
          ) cs ON c.idContrato = cs.idContrato
          LEFT JOIN secretarias s ON cs.idSecretaria = s.idSecretaria
          WHERE c.arquivado = 0
            AND NOW() BETWEEN c.vigenciaInicial AND c.vigenciaFinal
          GROUP BY siglaSecretaria';


$gdb->open($query);

$json = json_encode($gdb->gs);
echo $json;
?>
