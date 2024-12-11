<?php
include_once('../db/connect.php');
include_once('../db/gdb_mysql.php');

$gdb = new gdb();

$vigenciaInicial = $_POST['vigenciaInicial'];
$vigenciaFinal = $_POST['vigenciaFinal'];
$custoAnual = $_POST['custoAnual'];
$custoMensal = $_POST['custoMensal'];
$infoContratuais = $_POST['infoContratuais']; 
$observacao = $_POST['observacoesContrato'];
$objeto = $_POST['objetoContrato'];
$idContrato = $_POST['idContrato'];
$nomeComercial = $_POST['nomeComercial'];
$nomeUsual = $_POST['nomeUsual'];
$categoria = $_POST['categoria'];
$link = $_POST['link'];
$dotacao = $_POST['dotacao'];
$admSuporte = $_POST['admSuporte'];

$secretaria = $_POST['secretaria'];
$arraySecretarias = array_map('trim', explode(',', $secretaria));

$superEgov = $_POST['superEgov'];
$arraySuperEgov = array_map('trim', explode(',', $superEgov));

$superFiscal = $_POST['superFiscal'];
$arraySuperFiscal = array_map('trim', explode(',', $superFiscal));

$superGestor = $_POST['superGestor'];
$arraySuperGestor = array_map('trim', explode(',', $superGestor));

if (!isset($_SESSION)) {
    session_start();
}

function editarSupervisores($arraySupervisores, $tipo, $gdb, $idContrato) {
    //deleta superv
    $deleteQuery = "DELETE FROM contratoXsupervisor WHERE idContrato = $idContrato AND tipoSupervisor = '$tipo'";
    $gdb->open($deleteQuery);

    // insert  os novos
    if (!empty($arraySupervisores)) {
        foreach ($arraySupervisores as $nomeSupervisor) {
            $gdb->open("SELECT idSupervisor FROM supervisores WHERE upper(nomeSupervisor) = upper('$nomeSupervisor') OR matriculaSupervisor = '$nomeSupervisor'");
            if ($gdb->linhas == 1) {
                echo "Cheogu Aqui";
                $idSupervisor = $gdb->gs['IDSUPERVISOR'][0];
                $sql3 = "INSERT INTO contratoXsupervisor (idSupervisor, idContrato, tipoSupervisor) VALUES ($idSupervisor, $idContrato, '$tipo')";
                $editarSupervisores = $gdb->open($sql3);
                if (!$editarSupervisores) {
                    throw new Exception("Erro ao editar supervisor: $nomeSupervisor");
                }
                //Esse elseif pode ser removido, ele so ta servindo para poder enviar supervisor nulo
            } elseif  ($gdb->linhas != 1 && $nomeSupervisor){
                throw new Exception("Supervisor não encontrado: $nomeSupervisor");
            }
        }
    }
}

function editarSecretarias($arraySecretarias, $gdb, $idContrato) {
    // delet secretarias
    $deleteQuery = "DELETE FROM contratoXsecretaria WHERE idContrato = $idContrato";
    $gdb->open($deleteQuery);

    // inseert na nova secretaria
    foreach ($arraySecretarias as $nomeSecretaria) {
        $gdb->open("SELECT idSecretaria FROM secretarias WHERE upper(nomeSecretaria) = upper('$nomeSecretaria') OR upper(siglaSecretaria) = upper('$nomeSecretaria')");
        if ($gdb->linhas == 1) {
            $idSecretaria = $gdb->gs['IDSECRETARIA'][0];
            $sql4 = "INSERT INTO contratoXsecretaria (idSecretaria, idContrato) VALUES ($idSecretaria, $idContrato)";
            if (!$gdb->open($sql4)) {
                throw new Exception("Erro ao editar secretaria: $nomeSecretaria");
            }
        }
    }
}

try {
    $gdb->open("START TRANSACTION");

    $sql = "UPDATE contratos 
            SET vigenciaInicial = '$vigenciaInicial',
                vigenciaFinal = '$vigenciaFinal',
                custoAnual = '$custoAnual',
                custoMensal = '$custoMensal',
                infoContratuais = '$infoContratuais',
                observacaoContrato = '$observacao',
                objetoContrato = '$objeto',
                nomeComercial = '$nomeComercial',
                nomeUsual = '$nomeUsual',
                classificacaoContrato = '$categoria',
                links = '$link',
                dotacao = '$dotacao',
                admSuporte = '$admSuporte'
            WHERE idContrato = $idContrato";

    $edicaoContrato = $gdb->open($sql);

    if (!$edicaoContrato) {
        throw new Exception("Erro ao editar contrato");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['documentos']) && !empty($_FILES['documentos']['name'][0])) {
        $uploadDirectory = "/var/www/sistemas/pgs/CadastroContratos/documentos/";

        foreach ($_FILES['documentos']['name'] as $key => $filename) {
            $fileTmpPath = $_FILES['documentos']['tmp_name'][$key];
            $fileId = bin2hex(random_bytes(16));
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $filePath = $uploadDirectory . $fileId . '.' . $extension;

            if ($_FILES['documentos']['error'][$key] == 0 && move_uploaded_file($fileTmpPath, $filePath)) {
                echo "Arquivo $filename enviado com sucesso!<br>";

                $sql2 = "INSERT INTO documentos (idContrato, caminhoDocumento, nomeDocumento, nomeAntigo)
                         VALUES ('$idContrato', '$filePath', '$fileId', '$filename')";

                $CadastroDocumentos = $gdb->open($sql2);

                if (!$CadastroDocumentos) {
                    throw new Exception("Erro ao cadastrar documentos");
                }
            } else {
                throw new Exception("Erro ao mover arquivo $filename");
            }
        }
    }

    editarSupervisores($arraySuperFiscal, "Fiscal", $gdb, $idContrato);
    editarSupervisores($arraySuperGestor, "Gestor", $gdb, $idContrato);
    editarSupervisores($arraySuperEgov, "Fiscal E-Gov", $gdb, $idContrato);
    editarSecretarias($arraySecretarias, $gdb, $idContrato);

    $idUsuario = $_SESSION["idUsuario"];
    $current_time = date('d-m-Y H:i:s');

    $auditoriaSql = "INSERT INTO auditoria (tipoInteracao, idUsuario, horaAuditoria, nomeDoAlvo)
                     VALUES ('Editou o Contrato Arquivado', '$idUsuario', '$current_time', '$nomeUsual')";

    if (!$gdb->open($auditoriaSql)) {
        echo "<script>alert('Edição realizada com sucesso, mas houve um erro ao registrar a auditoria'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaArquivados/#';</script>";
    } else {
        echo "<script>alert('Edição realizada com sucesso e auditoria registrada!'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaArquivados/#';</script>";
    }

    $gdb->open("COMMIT");
} catch (Exception $e) {
    $gdb->open("ROLLBACK");
    echo "<script>alert('" . $e->getMessage() . "'); window.location.href = 'https://pgs.pmf.sc.gov.br/TelaArquivados/#';</script>";
}
?>
