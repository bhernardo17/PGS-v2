<?php

include_once('../db/connect.php');
include_once('../db/gdb_mysql.php');
if (!isset($_SESSION)) {
    session_start();
}

$gdb = new gdb();
$idContrato = $_POST['codigo'];
ob_start(); 

try {
    $gdb->open("START TRANSACTION");

    $data = [];

    $query = $conn->query("SELECT DISTINCT con.*,
                            forn.nomeFornecedor as fornecedor,
                            CXSE.idSecretaria,
                            CXSU.idSupervisor, 
                            CXSU.tipoSupervisor
                            FROM contratos con
                            LEFT JOIN fornecedor forn
                                ON forn.idFornecedor = con.idFornecedor  
                            LEFT JOIN contratoXsecretaria CXSE
                                ON CXSE.idContrato = con.idContrato 
                            LEFT JOIN contratoXsupervisor CXSU
                                ON CXSU.idContrato = con.idContrato
                            WHERE con.idContrato = $idContrato
    ");

    while ($row = $query->fetch_assoc()) {
        $idContrato = $row['idContrato'];

        if (!isset($data[$idContrato])) {
            $data[$idContrato] = [
                'idContrato' => $row['idContrato'],
                'vigenciaInicial' => $row['vigenciaInicial'],
                'vigenciaFinal' => $row['vigenciaFinal'],
                'custoAnual' => $row['custoAnual'],
                'custoMensal' => $row['custoMensal'],
                'infoContratuais' => $row['infoContratuais'],
                'observacaoContrato' => $row['observacaoContrato'],
                'objetoContrato' => $row['objetoContrato'],
                'nomeUsual' => $row['nomeUsual'],
                'nomeComercial' => $row['nomeComercial'],
                'classificacaoContrato' => $row['classificacaoContrato'],
                'idFornecedor' => $row['idFornecedor'],
                'fornecedor' => $row['fornecedor'],
                'arquivado' => $row['arquivado'],
                'dotacao' => $row['dotacao'],
                'admSuporte' => $row['admSuporte'],
                'situacaoContrato' => $row['situacaoContrato'],
                'aditivo' => $row['aditivo'],
                'secretarias' => [],
                'supervisores' => []
            ];
        }

        if (!in_array($row['idSecretaria'], $data[$idContrato]['secretarias']) && !empty($row['idSecretaria'])) {
            $data[$idContrato]['secretarias'][] = $row['idSecretaria'];
        }

        $supervisorData = [
            'idSupervisor' => $row['idSupervisor'],
            'tipoSupervisor' => $row['tipoSupervisor']
        ];
        if (!in_array($supervisorData, $data[$idContrato]['supervisores']) && !empty($row['idSupervisor'])) {
            $data[$idContrato]['supervisores'][] = $supervisorData;
        }
    }

    $infoContratualTEMP = $data[$idContrato]['infoContratuais']."TEMP";
    $sql = "INSERT INTO contratos (vigenciaInicial, 
                                   vigenciaFinal, 
                                   custoAnual, 
                                   custoMensal, 
                                   infoContratuais, 
                                   observacaoContrato, 
                                   objetoContrato, 
                                   nomeUsual, 
                                   nomeComercial, 
                                   classificacaoContrato, 
                                   idFornecedor, 
                                   dotacao, 
                                   admSuporte,
                                   aditivo)
            VALUES ('{$data[$idContrato]['vigenciaInicial']}', 
                    '{$data[$idContrato]['vigenciaFinal']}', 
                    '{$data[$idContrato]['custoAnual']}', 
                    '{$data[$idContrato]['custoMensal']}', 
                    '$infoContratualTEMP', 
                    '{$data[$idContrato]['observacaoContrato']}', 
                    '{$data[$idContrato]['objetoContrato']}', 
                    '{$data[$idContrato]['nomeUsual']}', 
                    '{$data[$idContrato]['nomeComercial']}', 
                    '{$data[$idContrato]['classificacaoContrato']}', 
                    '{$data[$idContrato]['idFornecedor']}', 
                    '{$data[$idContrato]['dotacao']}', 
                    '{$data[$idContrato]['admSuporte']}',
                    '{$data[$idContrato]['aditivo']}')";

    if (!$gdb->open($sql)) {
        throw new Exception($sql);
    }

    $gdb->open("COMMIT");

    // pega o ID do novo contrato
    $gdb->open("SELECT idContrato FROM contratos WHERE upper(infoContratuais) = upper('$infoContratualTEMP')", 1);
    $idContrato2 = $gdb->gs['IDCONTRATO'][0] ?? null;

    if (!$idContrato2) {
        throw new Exception("ID do contrato não encontrado");
    }

    // secretarias X contrato
    foreach ($data[$idContrato]['secretarias'] as $idSecretaria) {
        $sql4 = "INSERT INTO contratoXsecretaria (idSecretaria, idContrato) VALUES ('$idSecretaria', '$idContrato2')";
        if (!$gdb->open($sql4)) {
            throw new Exception("Erro ao cadastrar secretaria: $idSecretaria");
        }
    }

    // supervisores X contrato
    foreach ($data[$idContrato]['supervisores'] as $supervisorData) {
        $idSupervisor = $conn->real_escape_string($supervisorData['idSupervisor']);
        $tipoSupervisor = $conn->real_escape_string($supervisorData['tipoSupervisor']);
        $supervisoresSQL = "INSERT INTO contratoXsupervisor (idContrato, idSupervisor, tipoSupervisor) 
                            VALUES ('$idContrato2', '$idSupervisor', '$tipoSupervisor')";
        if (!$gdb->open($supervisoresSQL)) {
            throw new Exception("Erro ao cadastrar supervisor ID $idSupervisor");
        }
    }

    $selectAditivo = "SELECT aditivo FROM contratos WHERE idContrato = $idContrato2";
        if(!$gdb->open($selectAditivo)) {
            throw new Exception("Erro ao calcular Aditivo");
        }else {
            $aditivo = $gdb->gs['ADITIVO'][0];
            $aditivoPlus = $aditivo +1;
            $alterAditivo = "UPDATE contratos SET aditivo = $aditivoPlus WHERE idContrato = $idContrato2";

            if(!$gdb->open($alterAditivo)) {
                throw new Exception("Erro ao alterar Número do Aditivo");
            } else {
                $infoContratuaisBase = preg_replace('/\(Adt \d+\)/', '', $data[$idContrato]["infoContratuais"]);
                $nomeUsualBase = preg_replace('/\(Adt \d+\)/', '', $data[$idContrato]["nomeUsual"]);
                
                $infoContratuaisAdt = trim($infoContratuaisBase) . " (Adt " . $aditivoPlus . ")";
                $alterInfoContratuais = "UPDATE contratos SET infoContratuais = '$infoContratuaisAdt' WHERE idContrato = $idContrato2";
                if (!$gdb->open($alterInfoContratuais)) {
                    throw new Exception("Erro ao alterar Info Contratuais do Aditivo");
                }
        
                $nomeUsualAdt = trim($nomeUsualBase) . " (Adt " . $aditivoPlus . ")";
                $alterNomeUsual = "UPDATE contratos SET nomeUsual = '$nomeUsualAdt' WHERE idContrato = $idContrato2";
                if (!$gdb->open($alterNomeUsual)) {
                    throw new Exception("Erro ao alterar Nome do Aditivo");
                }
            }
    }

    // registro de auditoria
    $idUsuario = $_SESSION["idUsuario"];
    date_default_timezone_set('America/Sao_Paulo');
    $current_time = date('d-m-Y H:i:s');
    $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                     VALUES ('Aditivou o Contrato', '$idUsuario', '$current_time', '{$data[$idContrato]['nomeUsual']}')";

    ob_clean(); 

    if (!$gdb->open($auditoriaSql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Cadastro realizado com sucesso, mas houve um erro ao registrar a auditoria.'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'Cadastro realizado com sucesso e auditoria registrada!'
        ]);
    }

    $gdb->open("UPDATE contratos SET arquivado = 1 WHERE idContrato = $idContrato");

} catch (Exception $e) {
    $gdb->open("ROLLBACK");
    ob_clean();
    echo json_encode(['error' => $e->getMessage()]);
}

exit;
?>