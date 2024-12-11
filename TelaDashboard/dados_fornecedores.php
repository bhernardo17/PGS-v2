<?php
require 'gdb_mysql.php'; // Inclua a conexão com o banco de dados

$secretaria = $_GET['secretaria'];

// Consulta SQL para obter fornecedores e valores
$query = "SELECT
              f.idFornecedor,
              f.nomeFornecedor,
              SUM(c.custoAnual) AS valorTotalAnual,
              GROUP_CONCAT(CONCAT(c.nomeUsual) ORDER BY c.idContrato ASC SEPARATOR '; ') AS contratos
          FROM
              fornecedor f
          JOIN
              contratos c ON f.idFornecedor = c.idFornecedor
          JOIN
              contratoXsecretaria cxsec ON c.idContrato = cxsec.idContrato
          WHERE
              cxsec.idSecretaria = ?
              AND c.arquivado <> 1
              AND CURDATE() BETWEEN c.vigenciaInicial AND c.vigenciaFinal
          GROUP BY
              f.idFornecedor, f.nomeFornecedor";
$stmt = $pdo->prepare($query);
$stmt->execute([$secretaria]);
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($fornecedores);
