<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();
$gdbGestor = new gdb();
$gdbFiscal = new gdb();

$idContrato = $_POST['codigo'];

$gdb->open("select distinct con.*, 
	forn.nomeFornecedor as fornecedor, 
	sup.nomeSupervisor as supervisor, 
	cxs.tipoSupervisor as tipo,
	sec.nomeSecretaria as secretaria,
	sec.siglaSecretaria as sigla,
        con.nomeUsual as nomeusual
	from contratos con 

	left join fornecedor forn 
	on forn.idfornecedor = con.idfornecedor 

	left join contratoXsupervisor cxs 
	on cxs.idContrato = con.idContrato 

	left join supervisores sup 
	on sup.idSupervisor = cxs.idSupervisor 

	left join contratoXsecretaria conxsec
	on conxsec.idContrato = con.idContrato

	left join secretarias sec
	on conxsec.idSecretaria = sec.idSecretaria

	where con.idcontrato = '$idContrato' and arquivado = 0;"); 

$gdbGestor ->open("select distinct con.*, 
                forn.nomeFornecedor as fornecedor, 
                sup.nomeSupervisor as supervisor, 
                cxs.tipoSupervisor as tipo 
                from contratos con 

                left join fornecedor forn 
                on forn.idfornecedor = con.idfornecedor 

                left join contratoXsupervisor cxs 
                on cxs.idContrato = con.idContrato 
                and cxs.tipoSupervisor = 'Gestor'

                left join supervisores sup 
                on sup.idSupervisor = cxs.idSupervisor 

                where con.idcontrato = '$idContrato' and arquivado = 0 ");

$gdbFiscal->open("select distinct con.*, 
                forn.nomeFornecedor as fornecedor, 
                sup.nomeSupervisor as supervisor, 
                cxs.tipoSupervisor as tipo 
                from contratos con 

                left join fornecedor forn 
                on forn.idfornecedor = con.idfornecedor 

                left join contratoXsupervisor cxs 
                on cxs.idContrato = con.idContrato 
                and cxs.tipoSupervisor = 'Fiscal'

                left join supervisores sup 
                on sup.idSupervisor = cxs.idSupervisor 

                where con.idcontrato = '$idContrato' and arquivado = 0 ");

// foreach($gdb->gs['IDCONTRATO'] as $i=>$value){ ?>

<form action="editarnew.php" method="POST" id="mainForm">
        <input class="titulo" name="nomeUsual" value="<?=$gdb->gs['NOMEUSUAL'][0]; ?>" style="width: 100%; box-sizing: border-box;">

        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {?>
        <input type="text" name="idContrato" value="<?=$gdb->gs['IDCONTRATO'][$i];?>" style="display: none;">
        <?php }?>

        <div class="container3">
        <div class="left2">
                <div class="input-group">

                <p class="paragraph2"><strong>Inicio da Vigência:</strong></p>
                <input name="vigenciaInicial" type="date" class="exemplo_txt2" required value="<?= $gdb->gs['VIGENCIAINICIAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Fim da Vigência:</strong></p>
                <input name="vigenciaFinal" type="date" class="exemplo_txt2" required value="<?= $gdb->gs['VIGENCIAFINAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Fornecedor:</strong></p>
                <input name="fornecedor" type="text" class="exemplo_txt2" required value="<?=$gdb->gs['FORNECEDOR'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Nome Comercial:</strong></p>
                <input name="nomeComercial" type="text" class="exemplo_txt2" value="<?=$gdb->gs['NOMECOMERCIAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Info.Contratuais:</strong></p>
                <input name="infoContratuais" type="text" class="exemplo_txt2" required value="<?=$gdb->gs['INFOCONTRATUAIS'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Valor Anual:</strong></p>
                <input name="custoAnual" type="text" class="exemplo_txt2" required value="<?=$gdb->gs['CUSTOANUAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Valor Mensal:</strong></p>
                <input name="custoMensal" type="text" class="exemplo_txt2" value="<?=$gdb->gs['CUSTOMENSAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Dotação Orçamentária:</strong></p>
                <input name="dotacao" type="text" class="exemplo_txt2" value="<?=$gdb->gs['DOTACAO'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Adiminstrador do Sistema:</strong></p>
                <input name="admSuporte" type="text" class="exemplo_txt2" value="<?=$gdb->gs['ADMSUPORTE'][0]; ?>">
                </div>

                <p class="paragraph3"><strong>Situação do Contrato:</strong></p>
                <select name="situacaoContrato" class="tamanhoFonte2">
                        <option value="Ativo" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Ativo') ? 'selected' : ''; ?>>Ativo</option>
                        <option value="Inativo" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Inativo') ? 'selected' : ''; ?>>Inativo</option>
                        <option value="Suspenso" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Suspenso') ? 'selected' : ''; ?>>Suspenso</option>
                        <option value="Finalizado" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Finalizado') ? 'selected' : ''; ?>>Finalizado</option>
                        <option value="Doação" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Doação') ? 'selected' : ''; ?>>Doação</option>
                        <option value="Aguardando Processo" <?= ($gdb->gs['SITUACAOCONTRATO'][0] == 'Aguardando Processo') ? 'selected' : ''; ?>>Aguardando Processo</option>
                </select>

<!-- 
                <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {?>
                <div class="input-group">
                <p class="paragraph2"><strong>Fiscal e-Gov:</strong></p>
                <input name="superEgov" type="text" class="exemplo_txt2" value="<?=$gdb->gs['SUPERVISOR'][$i]; ?>">
                </div>
                
                <?php }?> -->

        </div>
        <div class="right2">
                <p class="paragraph3"><strong>Objeto:</strong></p>
                <textarea name="objetoContrato" class="tamanhoFonte2" rows="6" cols="50"><?=trim($gdb->gs['OBJETOCONTRATO'][0]); ?></textarea>
                
                <p class="paragraph3"><strong>Detalhes e Observações:</strong></p>
                <textarea name="observacoesContrato" class="tamanhoFonte2" rows="6" cols="50"><?=trim($gdb->gs['OBSERVACAOCONTRATO'][0]); ?></textarea>

                <p class="paragraph3"><strong>Link Externo</strong></p>
                <textarea name="link" class="tamanhoFonte2" rows="6" cols="50"><?=$gdb->gs['LINKS'][$i]; ?></textarea>

                



                <p class="paragraph3"><strong>Documentos Anexos</strong></p>

                <?php 
                        $gdbAnexos = new gdb();
                        $gdbAnexos->open("SELECT caminhoDocumento FROM documentos WHERE idContrato = $idContrato");
                        $resultados = $gdbAnexos->gs;

                        if ($resultados) {
                        foreach ($resultados as $documento) {
                                echo '<p>' . $documento['caminhoDocumento'] . '</p>';
                        }
                        } else {
                        echo '<p>Nenhum documento encontrado.</p>';
                        }
                ?>

                <div class="supervisores-section">
                                <p class="paragraph3"><strong>Fiscal/Gestor</strong></p>
                                <table name="tabelaSupervisores" id="tabelaSupervisores">
                                <?php if (isset($gdb->gs['IDCONTRATO']) && !empty($gdb->gs['IDCONTRATO'])) { 
                                        foreach ($gdb->gs['IDCONTRATO'] as $i => $value) { ?>
                                        <tr>
                                        <td>
                                                <input type="text" name="supResponsavel[]" class="form-control" value="<?= htmlspecialchars($gdb->gs['SUPERVISOR'][$i]); ?>" placeholder="Responsável">
                                        </td>
                                        <td>
                                                <select class="form-control" name="supStatus[]">
                                                <option disabled <?= ($gdb->gs['TIPO'][$i] == '') ? 'selected' : ''; ?>>Tipo</option>
                                                <option value="Fiscal-Egov" <?= ($gdb->gs['TIPO'][$i] == 'Fiscal-Egov') ? 'selected' : ''; ?>>Fiscal-Egov</option>
                                                <option value="Fiscal" <?= ($gdb->gs['TIPO'][$i] == 'Fiscal') ? 'selected' : ''; ?>>Fiscal</option>
                                                <option value="Gestor" <?= ($gdb->gs['TIPO'][$i] == 'Gestor') ? 'selected' : ''; ?>>Gestor</option>
                                                </select>
                                        </td>
                                        <td>
                                                <?php if ($i == count($gdb->gs['IDCONTRATO']) - 1) { ?>
                                                <input type="button" class="btn btn-success btn-sm" onclick="adicionarSupervisores()" value="+">
                                                <?php } ?>
                                                <input type="button" class="btn btn-danger btn-sm" onclick="excluirLinhaSupervisores(this)" value="-">
                                        </td>
                                        </tr>
                                <?php } 
                                } else { ?>
                                        <tr>
                                        <td>
                                                <input type="text" id="supResponsavel" name="supResponsavel[]" class="form-control supResponsavel" placeholder="Responsável">
                                        </td>
                                        <td>
                                                <select class="form-control" name="supStatus[]">
                                                <option disabled selected>Tipo</option>
                                                <option value="Fiscal-Egov">Fiscal-Egov</option>
                                                <option value="Fiscal">Fiscal</option>
                                                <option value="Gestor">Gestor</option>
                                                </select>
                                        </td>
                                        <td>
                                                <input type="button" class="btn btn-success btn-sm" onclick="adicionarSupervisores()" value="+">
                                        </td>
                                        </tr>
                                <?php } ?>
                                </table>
                                </div>
        </div>
        </div>

        <?php foreach($gdbGestor->gs['IDCONTRATO'] as $i=>$value) {
                if ($i == 0){
                        $supervisor_nome =$gdbGestor->gs['SUPERVISOR'][$i];

                } else {
                        $supervisor_nome .= ", ".$gdbGestor->gs['SUPERVISOR'][$i];
                }
                
                 }?>
        <div class="section1">
        <div class="direcao">
                <div class="tamanho_e_direcao">
                        <div class="direcao2">
                                <!-- <p class="tituloInput"><strong>Gestores:</strong></p>
                                <textarea name="superGestor" class="inputBottom"><?=trim($supervisor_nome);?></textarea>     -->

                                <!-- <div class="supervisores-section">
                                        <p>Fiscal/Gestor</p>
                                        <table name="tabelaSupervisores" id="tabelaSupervisores">
                                                <tr>
                                                        <td>
                                                                <input type="text" id="supResponsavel" name="supResponsavel[]" class="form-control" placeholder="Responsável">
                                                        </td>
                                                        <td>
                                                                <select name="supStatus[]" id="supStatus" class="form-control">
                                                                        <option disabled selected>Tipo</option>
                                                                        <option value="Fiscal-Egov">Fiscal-Egov</option>
                                                                        <option value="Fiscal">Fiscal</option>
                                                                        <option value="Gestor">Gestor</option>
                                                                </select>
                                                        </td>
                                                        <td>
                                                                <input type="button" class="btn btn-success btn-sm" id="btnAddSup" onclick="adicionarSupervisores();" value="+">
                                                        </td>
                                                </tr>
                                        </table>
                                </div>
                        </div> -->
                        

                        <!-- <div class="direcao2">
                        <?php foreach($gdbGestor->gs['IDCONTRATO'] as $i=>$value) {
                                if ($i == 0){
                                        $supervisor_nomeF =$gdbFiscal->gs['SUPERVISOR'][$i];

                                } else {
                                        $supervisor_nomeF .= ", ".$gdbFiscal->gs['SUPERVISOR'][$i];
                                }
                                
                                }?>

                                <p class="tituloInput"><strong>Fiscais:</strong></p>
                                <textarea name="superFiscal" class="inputBottom"><?=trim($supervisor_nomeF);?></textarea>    
                        </div> -->
                                
                </div>
        </div>   



        

        <div class="form-group2">
                <label for="documentos" class="file-upload-label btn btn-primary">Anexe documentos</label>
                <input type="file" name="documentos[]" id="documentos" multiple class="form-control visually-hidden">
                <div id="fileList"></div>
        </div>        
        
               
        

        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {
                if ($i == 0){
                        $secretarias_nomes =$gdb->gs['SECRETARIA'][$i];

                } else {
                        $secretarias_nomes .= ", ".$gdb->gs['SECRETARIA'][$i];
                }
                
                 }?>
        <div class="direcao"> 
                <div class="direcao">
                        <div class="tamanho_e_direcao">
                                <div class="direcao2">
                                        <p class="tituloInput"><strong>Secretaria:</strong></p>
                                        <input name="secretaria" class="inputBottom" value="<?=trim($secretarias_nomes);?>" required>  
                                </div>
                                <div class="direcao2">
                                        <p class="tituloInput"><strong>Categoria:</strong></p>
                                        <input name="categoria" type="text" class="inputBottom" value="<?=$gdb->gs['CLASSIFICACAOCONTRATO'][0]; ?>"/>
                                </div>

                        </div>   
                </div>
        </div>  
        </div>        
        

        <div class="row justify-content-between">
        <div class="salvar">
                <button type="buttonB" onclick="salvar()" class="btn btn-custom btn-lg" style="margin-left: 45%;">Salvar</button>
        </div>     
        </div>
        </form>
        

        <script>
                document.addEventListener("DOMContentLoaded", () => {
                const fileInput = document.getElementById('documentos');
                const fileList = document.getElementById('fileList');

                fileInput.addEventListener('change', (event) => {
                        fileList.innerHTML = '';

                        const files = event.target.files;

                        if (files.length > 0) {
                        const ul = document.createElement('ul');

                        for (let i = 0; i < files.length; i++) {
                                const li = document.createElement('li');
                                li.textContent = files[i].name;
                                ul.appendChild(li);
                        }

                        fileList.appendChild(ul);
                        } else {
                        fileList.textContent = 'Nenhum arquivo selecionado.';
                        }
                });
                });

                document.getElementById('mainForm').addEventListener('submit', function(event) {
                        event.preventDefault(); // Impede o envio padrão do formulário

                        const form = event.target;
                        const formData = new FormData(form);

                        fetch('editarnew.php', {
                                method: 'POST',
                                body: formData
                        })
                        .then(response => response.text()) // ou .json() se o seu servidor retornar JSON
                        .then(result => {
                                console.log(result); // Pode substituir isso para mostrar uma mensagem ao usuário
                        })
                        .catch(error => {
                                console.error('Erro:', error);
                        });
                });
        </script>


<?php 


?>