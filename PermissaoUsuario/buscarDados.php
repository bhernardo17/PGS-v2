<?php

include_once ('../db/connect.php');
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$idUsuario = $_POST['codigo'];

$gdb->open("select distinct usu.*, 
                sec.nomeSecretaria as secretaria,
                sec.siglaSecretaria as sigla,
                from usuario usu 

                left join secretarias sec
                on sec.idSecretaria = usu.idSecretaria 

                where usu.idUsuario = '$idUsuario'"
        )
; 



foreach($gdb->gs['IDUSUARIO'] as $i=>$value){ ?>

        <form action="" method="POST">
                <label for="nomeUsuario">Nome do Usuario</label>
                <input type="text" name="nomeUsuario" value="<?=$gdb->gs['NOMEUSUARIO'][$i]; ?>">

                <label for="nomeSecretaria">Secretaria</label>
                <input type="text" name="nomeSecretaria" value="<?=$gdb->gs['SECRETARIA'][$i]; ?>">

                <label for="matriculaUsuario">Matrícula</label>
                <input type="number" name="matriculaUsuario" value="<?=$gdb->gs['MATRICULAUSUARIO'][$i]; ?>">

                <label for="senhaUsuario">Nova Senha</label>
                <input type="text" name="senhaUsuario">

                <label for="senhaUsuario2">Confirme a Nova Senha</label>
                <input type="text" name="senhaUsuario2">

                <label for="acesso">Acesso</label>
                <input type="number" name="acesso" value="<?=$gdb->gs['ACESSOUSUARIO'][$i]; ?>">
        </form>

<?php

}

?>