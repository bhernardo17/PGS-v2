<?php

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

// foreach($gdb->gs['IDCONTRATO'] as $i=>$value){ ?>

<form action="editarnew.php" method="POST">
        <input class="titulo" name="nomeUsual" value="<?=$gdb->gs['NOMEUSUAL'][0]; ?>" style="width: 100%; box-sizing: border-box;">



        <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {?>
        <input type="text" name="idContrato" value="<?=$gdb->gs['IDCONTRATO'][$i];?>" style="display: none;">
        <?php }?>

        <div class="container3">
        <div class="left2">
                <div class="input-group">

                <p class="paragraph2"><strong>InicioVigência:</strong></p>
                <input name="vigenciaInicial" type="date" class="exemplo_txt2" value="<?= $gdb->gs['VIGENCIAINICIAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>FimVigência:</strong></p>
                <input name="vigenciaFinal" type="date" class="exemplo_txt2" value="<?= $gdb->gs['VIGENCIAFINAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Fornecedor:</strong></p>
                <input name="fornecedor" type="text" class="exemplo_txt2" value="<?=$gdb->gs['FORNECEDOR'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Nome Comercial:</strong></p>
                <input name="nomeComercial" type="text" class="exemplo_txt2" value="<?=$gdb->gs['NOMECOMERCIAL'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Info.Contratuais:</strong></p>
                <input name="infoContratuais" type="text" class="exemplo_txt2" value="<?=$gdb->gs['INFOCONTRATUAIS'][0]; ?>">
                </div>

                <div class="input-group">
                <p class="paragraph2"><strong>Valor Anual:</strong></p>
                <input name="custoAnual" type="text" class="exemplo_txt2" value="<?=$gdb->gs['CUSTOANUAL'][0]; ?>">
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
                <p class="paragraph2"><strong>Administrador do Sistema:</strong></p>
                <input name="admSuporte" type="text" class="exemplo_txt2" value="<?=$gdb->gs['ADMSUPORTE'][0]; ?>">
                </div>

                <?php foreach($gdb->gs['IDCONTRATO'] as $i=>$value) {?>
                <div class="input-group">
                <p class="paragraph2"><strong>Fiscal e-Gov:</strong></p>
                <input name="superEgov" type="text" class="exemplo_txt2" value="<?=$gdb->gs['SUPERVISOR'][$i]; ?>">
                </div>
                
                <?php }?>

        </div>
        <div class="right2">
                <p class="paragraph3"><strong>Objeto:</strong></p>
                <textarea name="objetoContrato" class="tamanhoFonte2" rows="6" cols="50"><?=trim($gdb->gs['OBJETOCONTRATO'][0]); ?></textarea>
                
                <p class="paragraph3"><strong>Detalhes e Observações:</strong></p>
                <textarea name="observacoesContrato" class="tamanhoFonte2" rows="6" cols="50"><?=trim($gdb->gs['OBSERVACAOCONTRATO'][0]); ?></textarea>

                <p class="paragraph3"><strong>Link Externo</strong></p>
                <textarea name="link" class="tamanhoFonte2" rows="6" cols="50"><?=$gdb->gs['LINKS'][$i]; ?></textarea>

                
        </div>
        </div>

        <?php foreach($gdbGestor->gs['IDCONTRATO'] as $i=>$value) {
                if ($i == 0){
                        $supervisor_nomeG =$gdbGestor->gs['SUPERVISOR'][$i];

                } else {
                        $supervisor_nomeG .= ", ".$gdbGestor->gs['SUPERVISOR'][$i];
                }
                
                 }?>
        <div class="bottom_Form">
        <div>
                <div>
                        <div class="parte_inferior">
                                <p class="tituloInput"><strong>Gestores:</strong></p>
                                <textarea name="superGestor" class="inputBottom"><?=trim($supervisor_nomeG);?></textarea>    
                        </div>
                        <div class="eita">

                        <?php foreach($gdbGestor->gs['IDCONTRATO'] as $i=>$value) {
                                if ($i == 0){
                                        $supervisor_nomeF =$gdbFiscal->gs['SUPERVISOR'][$i];

                                } else {
                                        $supervisor_nomeF .= ", ".$gdbFiscal->gs['SUPERVISOR'][$i];
                                }
                                
                                }?>
                                <p class="tituloInput"><strong>Fiscais:</strong></p>
                                <textarea name="superFiscal" class="inputBottom"><?=trim($supervisor_nomeF);?></textarea>    
                        </div>
                                
                </div>
        </div>   



        

        <div class="form-group2">
                <label for="documentos" class="file-upload-label btn btn-primary">Anexe aqui</label>
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
        <div> 
                <div>
                        <div>
                                <div>
                                        <p class="tituloInput"><strong>Secretaria:</strong></p>
                                        <textarea name="secretaria" class="inputBottom"><?=trim($secretarias_nomes);?></textarea>    
                                </div>
                                <div>
                                        <p class="tituloInput"><strong>Categoria:</strong></p>
                                        <input name="categoria" type="text" class="inputBottom" value="<?=$gdb->gs['CLASSIFICACAOCONTRATO'][0]; ?>">
                                </div>

                        </div>   
                </div>
        </div>  
        </div>        
        

        <div class="row justify-content-between">
        <div class="salvar">
                <button type="buttonB" onclick="salvar()" class="button_save">Salvar</button>
        </div>     
        </div>
</form>


<?php 


?>