<?php 
include_once ('../db/gdb_mysql.php');

$gdb = new gdb();

$query = 'SELECT forn.nomeFornecedor AS nome, SUM(con.custoAnual) AS valor 
          FROM contratos con 
          JOIN fornecedor forn ON con.idFornecedor = forn.idFornecedor
          WHERE NOW() BETWEEN vigenciaInicial AND vigenciaFinal
          GROUP BY forn.nomeFornecedor
          ORDER BY forn.nomeFornecedor';

$gdb->open($query);

if (isset($gdb->gs) && !empty($gdb->gs)) {
    $json = json_encode($gdb->gs);
    echo $json; 
} else {
    echo json_encode([]);
}
?>
