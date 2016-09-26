<?php
include "valida_sessao.inc";
include "conecta_mysql.inc";
$nome_usuario = $_SESSION["nome_usuario"];
$id_usuario = $_SESSION["id_usuario"];
if(isset($_GET["mes"])){
	$mes = $_GET["mes"];
	$meses = array("Janeiro","Fevereiro","Marco","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
}
mysql_close($con);
?>
<html>
<head>
<title>Controle de Finanças Empresarial</title>
<meta charset="utf-8">
</head>
<body>
<form method="GET" name="fmes" action="saldosMensaisPlan.php">
<center>
<img src="dinheiro.png"/>
<h1>Sistema de Controle de Finanças Empresarial</h1>
<hr width="700px"/><br/>
<p>Favor, escolha o mês que deseja visualizar:
<select name="mes">
<option value="null">Escolha um mês</option>
<option value="1" onclick="javascript:document.fmes.submit();">Janeiro</option>
<option value="2" onclick="javascript:document.fmes.submit();">Fevereiro</option>
<option value="3" onclick="javascript:document.fmes.submit();">Março</option>
<option value="4" onclick="javascript:document.fmes.submit();">Abril</option>
<option value="5" onclick="javascript:document.fmes.submit();">Maio</option>
<option value="6" onclick="javascript:document.fmes.submit();">Junho</option>
<option value="7" onclick="javascript:document.fmes.submit();">Julho</option>
<option value="8" onclick="javascript:document.fmes.submit();">Agosto</option>
<option value="9" onclick="javascript:document.fmes.submit();">Setembro</option>
<option value="10" onclick="javascript:document.fmes.submit();">Outubro</option>
<option value="11" onclick="javascript:document.fmes.submit();">Novembro</option>
<option value="12" onclick="javascript:document.fmes.submit();">Dezembro</option>
</select>
</p>
<?php if (isset($mes))
{
	require "planilha.php";
?>
		<table>
		<tr>
			<td>
				<input type="button" onClick="location.href='principal.php'" value="Voltar">
				<input type="button" onClick="location.href='exportar_pdf.php?mes=<?php echo $mes; ?>'" value="Exportar como PDF">
				<input type="button" onClick="location.href='exportar_excel.php?mes=<?php echo $mes; ?>'" value="Exportar para Excel">
			</td>
			<td>
			</td>
		</tr>
		</table>
<?php
}
?>
</center>
</form>
</body>
</html>