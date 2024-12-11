<?php

include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$idContrato = $_POST['codigo'];

$gdb->open("select distinct con.*, 
                forn.nomeFornecedor as fornecedor,
                forn.cnpjFornecedor as cnpj, 
                sup.nomeSupervisor as supervisor, 
                cxs.tipoSupervisor as tipo,
                sec.siglaSecretaria as secretaria
                from contratos con 

                left join fornecedor forn 
                on forn.idfornecedor = con.idfornecedor 

                left join contratoXsupervisor cxs 
                on cxs.idContrato = con.idContrato 
                and cxs.tipoSupervisor = 'Fiscal E-Gov'

                left join supervisores sup 
                on sup.idSupervisor = cxs.idSupervisor
                
                left join contratoXsecretaria conXsec
                on conXsec.idContrato = con.idContrato

                left join secretarias sec
                on sec.idSecretaria = conXsec.idSecretaria

                where con.idcontrato = '$idContrato' and arquivado = 0 "); 

foreach($gdb->gs['IDCONTRATO'] as $i=>$value){ ?>

        <p class="paragraph_selecionado"><strong>Sistema: <?=$gdb->gs['NOMEUSUAL'][$i]; ?> </strong></p>
        <p class="paragraph"><strong>Vigência:</strong> <?= date('d/m/Y', strtotime($gdb->gs['VIGENCIAINICIAL'][0])); ?> a <?= date('d/m/Y', strtotime($gdb->gs['VIGENCIAFINAL'][0])); ?></p>
        <p class="paragraph"><strong>Fornecedor:</strong> <?=$gdb->gs['FORNECEDOR'][$i]; ?> </p>
        <p class="paragraph"><strong>CNPJ:</strong> <?=$gdb->gs['CNPJ'][$i]; ?> </p>
        <p class="paragraph"><strong>Info.Contratuais:</strong> <?=$gdb->gs['INFOCONTRATUAIS'][$i]; ?> </p>
        <p class="paragraph"><strong>Valor Anual:</strong> <?= 'R$ ' . number_format($gdb->gs['CUSTOANUAL'][$i], 2, ',', '.'); ?></p>
        <p class="paragraph"><strong>Valor Mensal:</strong> <?= 'R$ ' . number_format($gdb->gs['CUSTOMENSAL'][$i], 2, ',', '.'); ?></p>

        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {
                if ($i == 0){
                        $fiscalEgov =$gdb->gs['SUPERVISOR'][$i];

                } else {
                        $fiscalEgov .= ", ".$gdb->gs['SUPERVISOR'][$i];
                }
                
                 }?>

        <p class="paragraph"><strong>Fiscal e-Gov:</strong> <?=trim($fiscalEgov);?> </p>


        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {
                if ($i == 0){
                        $secretariaaaa =$gdb->gs['SECRETARIA'][$i];

                } else {
                        $secretariaaaa .= ", ".$gdb->gs['SECRETARIA'][$i];
                }
                
                 }?>
        <p class="paragraph"><strong>Secretaria</strong> <?=trim($secretariaaaa);?> </p>
        <p class="paragraph"><strong><a href="<?=$gdb->gs['LINKS'][$i]; ?>" target="_blank">Link Portal da Transparência </a> </strong></p>                   

        <div class="baixo">
        <button class="btnarqui" onclick="arquivarContrato('<?=$gdb->gs['IDCONTRATO'][$i]; ?>')"><span class="material-symbols-outlined">inventory_2</span>Arquivar</button>
        <button id="editarBtn" class="btnedit" onclick="trocarDisplayModal(<?=$gdb->gs['IDCONTRATO'][$i]; ?>)" ><span class="material-symbols-outlined">border_color</span>Editar</button>
        <button id="adtBtn" class="" onclick="aditivarJS('<?=$gdb->gs['IDCONTRATO'][$i]; ?>')">Aditivar</button>
        </div>  

        <script src="script.js"></script>

<?php 

}

?>
