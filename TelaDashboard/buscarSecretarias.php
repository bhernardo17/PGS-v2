<?php
// Inclua o arquivo de conexão com o banco de dados
include_once('../db/gdb_mysql.php');

// Instancie a classe de conexão com o banco de dados
$gdb = new gdb();

// Consulta SQL para buscar as secretarias
$gdb->open('SELECT idSecretaria, siglaSecretaria FROM secretarias');

// Inicializa um array para armazenar as secretarias
$secretarias = array();

// Loop para iterar sobre os resultados da consulta e armazenar no array
while ($row = $gdb->fetch_assoc()) {
    $secretarias[] = $row;
}

// Retorna as secretarias em formato JSON
echo json_encode($secretarias);
?>
