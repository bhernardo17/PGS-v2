<?php
include_once('../db/gdb_mysql.php');

$gdb = new gdb();

$query = "
    SELECT 
        c.nomeUsual, 
        SUM(c.custoAnual) AS custoAnual, 
        SUM(c.custoMensal) AS custoMensal, 
        MIN(c.vigenciaInicial) AS vigenciaInicial, 
        MAX(c.vigenciaFinal) AS vigenciaFinal, 
        f.nomeFornecedor, 
        c.infoContratuais, 
        c.objetoContrato, 
        GROUP_CONCAT(DISTINCT s.nomeSupervisor SEPARATOR ', ') AS gestores, 
        sec.nomeSecretaria, 
        c.classificacaoContrato
    FROM contratos c
    JOIN fornecedor f ON c.idFornecedor = f.idFornecedor
    JOIN contratoXsecretaria cs ON c.idContrato = cs.idContrato
    JOIN secretarias sec ON cs.idSecretaria = sec.idSecretaria
    JOIN contratoXsupervisor cxs ON c.idContrato = cxs.idContrato
    JOIN supervisores s ON cxs.idSupervisor = s.idSupervisor
    WHERE c.arquivado = 0
    GROUP BY c.idContrato, f.nomeFornecedor, c.infoContratuais, c.objetoContrato, sec.nomeSecretaria, c.classificacaoContrato";

$gdb->open($query);

// Exemplo de dados retornados para correspondência com a estrutura esperada
$dados = array();
while ($row = $gdb->gs->fetch_assoc()) {
    $dados[] = $row;
}

header('Content-Type: application/json');
echo json_encode($dados);
?>
