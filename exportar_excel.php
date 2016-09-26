<?php
include "conecta_mysql.inc";
include "valida_sessao.inc";
require "planilha.php";

$nomeMes = $meses[$mes-1];

$arquivo = "receitas_despesas".$nomeMes.".xls";

// Força o Download do Arquivo Gerado
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: application/x-msexcel');
header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
mysql_close($con);
?>