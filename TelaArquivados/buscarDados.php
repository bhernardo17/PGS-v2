<?php

include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();
$gdbGestor = new gdb();
$gdbFiscal = new gdb();

$idContrato = $_POST['codigo'];

$gdb->open("select distinct con.*, 
	forn.nomeFornecedor as fornecedor, 
        forn.cnpjFornecedor as cnpj,
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
	and cxs.tipoSupervisor = 'Fiscal E-Gov'

	left join supervisores sup 
	on sup.idSupervisor = cxs.idSupervisor 

	left join contratoXsecretaria conxsec
	on conxsec.idContrato = con.idContrato

	left join secretarias sec
	on conxsec.idSecretaria = sec.idSecretaria

	where con.idcontrato = '$idContrato' and arquivado = 1;"); 

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

                where con.idcontrato = '$idContrato' and arquivado = 1 ");

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

                where con.idcontrato = '$idContrato' and arquivado = 1 ");

foreach($gdb->gs['IDCONTRATO'] as $i=>$value){ ?>

        <form class="form-container">
                <div class="container">
                <h1><?=$gdb->gs['NOMEUSUAL'][$i]; ?></h1>
                <button type="button" class="btnedit" style="margin-left: 63%;" onclick="trocarDisplayModal(<?=$gdb->gs['IDCONTRATO'][$i]; ?>)"><span class="material-symbols-outlined">
                        border_color
                        </span>Editar</button>
                        
                        <button type="button" class="btnedit2" onclick="confirmarApagarContrato(<?=$gdb->gs['IDCONTRATO'][$i];?>);"><span class="material-symbols-outlined">
                        delete
                        </span>Excluir</button>


                
                </div>

                <div class="container2">
                        <div class="left">
                                <p class="paragraph"><strong>Inicio da vigência: </strong><span class="exemplo_txt"><?= date('d/m/Y', strtotime($gdb->gs['VIGENCIAINICIAL'][0])); ?></span></p>

                                <p class="paragraph"><strong>Fim da Vigência:</strong><span class="exemplo_txt"><?= date('d/m/Y', strtotime($gdb->gs['VIGENCIAFINAL'][0])); ?></span></p>

                                <p class="paragraph"><strong>Fornecedor:</strong><span class="exemplo_txt"><?=$gdb->gs['FORNECEDOR'][$i]; ?></span></p>

                                <p class="paragraph"><strong>CNPJ:</strong><span class="exemplo_txt"><?=$gdb->gs['CNPJ'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Sistema:</strong><span class="exemplo_txt"><?=$gdb->gs['NOMEUSUAL'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Info.Contratuais:</strong><span class="exemplo_txt"><?=$gdb->gs['INFOCONTRATUAIS'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Valor Anual:</strong><span class="exemplo_txt"><?=$gdb->gs['CUSTOANUAL'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Valor Mensal:</strong><span class="exemplo_txt"><?=$gdb->gs['CUSTOMENSAL'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Dotação:</strong><span class="exemplo_txt"><?=$gdb->gs['DOTACAO'][$i]; ?></span></p>

                                <p class="paragraph"><strong>Administrador de Sistema:</strong><span class="exemplo_txt"><?=$gdb->gs['ADMSUPORTE'][$i]; ?></span></p>


                                <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {
                                        if ($i == 0){
                                                $supervisor_nome =$gdb->gs['SUPERVISOR'][$i];

                                        } else {
                                                $supervisor_nome .= ", ".$gdb->gs['SUPERVISOR'][$i];
                                        }
                                        
                                        }?>
                                <p class="paragraph"><strong>Fiscal e-Gov: </strong><span class="exemplo_txt"><?=trim($supervisor_nome);?></span></p>

                        </div>

                        <div class="right"> 
                                <p class="paragraph"><strong>Objeto</strong></p>
                                <p class="tamanhoFonte"><?=trim($gdb->gs['OBJETOCONTRATO'][0]); ?>
                                </p>
                                <p class="paragraph"><strong>Detalhes e Observações</strong></p>
                                <p class="tamanhoFonte"><?=trim($gdb->gs['OBSERVACAOCONTRATO'][0]); ?>
                                </p>
                                <p class="paragraph"><strong><a href="<?=$gdb->gs['LINKS'][$i]; ?>" target="_blank">Link Portal da Transparência </a> </strong></p></p>

                        
                                </p>
                                
                        </div>
                </div>

                <div class="bottom">
                        <div class="bottom-left">
                        <?php foreach($gdbGestor->gs['IDCONTRATO'] as $i=>$value) {
                                if ($i == 0){
                                        $supervisor_nomeG =$gdbGestor->gs['SUPERVISOR'][$i];

                                } else {
                                        $supervisor_nomeG .= ", ".$gdbGestor->gs['SUPERVISOR'][$i];
                                }
                                
                                }?>
                                <p class="tituloBottom"><strong>Gestores:</strong></p>
                                <p class="infoBottom"><?=trim($supervisor_nomeG);?></p>
                        </div>
                        <div class="bottom-right">
                        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {
                                if ($i == 0){
                                        $secretarias_nomes =$gdb->gs['SECRETARIA'][$i];

                                } else {
                                        $secretarias_nomes .= ", ".$gdb->gs['SECRETARIA'][$i];
                                }
                                
                                }?>
                                <p class="tituloBottom"><strong>Secretaria:</strong></p>
                                <p class="infoBottom"><?=trim($secretarias_nomes);?></p>
                        </div>
                </div>

                <!-- <div class="form-group">
                        <span class="doc_contrato"><strong>Documentos do Contrato</strong></span>
                        <button type="submit" class="btn_anexo">Anexe Aqui</button>
                </div> -->

                <div class="bottom">
                        <div class="bottom-left">
                        <?php foreach($gdbFiscal->gs['IDCONTRATO'] as $i=>$value) {
                                if ($i == 0){
                                        $supervisor_nomeF =$gdbFiscal->gs['SUPERVISOR'][$i];

                                } else {
                                        $supervisor_nomeF .= ", ".$gdbFiscal->gs['SUPERVISOR'][$i];
                                }
                                
                                }?>
                                <p class="tituloBottom"><strong>Fiscais:</strong></p>
                                <p class="infoBottom"><?=trim($supervisor_nomeF);?></p>
                        </div>
                        
                        <!-- <div class="bottom-right">
                                <p class="tituloBottom"><strong>Nome Comercial:</strong></p>
                                <p class="infoBottom">Exemplo</p>
                        </div> -->
                </div>
        </form>

        <script src="script.js"></script>

<?php 
}
?>


