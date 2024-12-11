<?php 
include_once ('../db/gdb_mysql.php');

// Recebe o ID da secretaria via parâmetro POST
$idSecretaria = isset($_POST['idSecretaria']) ? intval($_POST['idSecretaria']) : 0;

$gdb = new gdb();

$gdb->open('SELECT 
    f.idFornecedor AS IDFORNECEDOR,
    f.nomeFornecedor AS NOMEFORNECEDOR,
    sec.nomeSecretaria AS NOMESECRETARIA,
    SUM(c.custoAnual) AS VALORTOTALANUAL,
    GROUP_CONCAT(CONCAT(c.nomeUsual, \' - R$ \', FORMAT(c.custoAnual, 2)) ORDER BY c.idContrato ASC SEPARATOR \'; \') AS CONTRATOS
FROM 
    fornecedor f
JOIN 
    contratos c ON f.idFornecedor = c.idFornecedor
JOIN 
    contratoXsecretaria cxsec ON c.idContrato = cxsec.idContrato
JOIN 
    secretarias sec ON sec.idSecretaria = cxsec.idSecretaria
WHERE 
    cxsec.idSecretaria = ' . $idSecretaria . ' 
    AND c.arquivado <> 1
    AND CURDATE() BETWEEN c.vigenciaInicial AND c.vigenciaFinal
GROUP BY 
    f.idFornecedor, f.nomeFornecedor');

$result = $gdb->gs;
echo json_encode($result);
?>
