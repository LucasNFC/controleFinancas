<?php
include "conecta_mysql.inc";
$nome_usuario = $_SESSION["nome_usuario"];
$id_usuario = $_SESSION["id_usuario"];
$saldoPesquisa = mysql_query("SELECT saldo FROM controlefinanceiro.usuarios WHERE id=$id_usuario");
$saldo = mysql_result($saldoPesquisa,0,"saldo");
$mes = $_GET["mes"];
$meses = array("Janeiro","Fevereiro","Marco","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$resRecVar = mysql_query("SELECT * FROM receitas_despesas WHERE classe=1 and mes_referencia=$mes and tipo=1 and usuario = $id_usuario");
$resDesVar = mysql_query("SELECT * FROM receitas_despesas WHERE classe=1 and mes_referencia=$mes and tipo =2 and usuario = $id_usuario");
$resRecFix = mysql_query("SELECT * FROM receitas_despesas WHERE classe=2 and tipo=1 and usuario = $id_usuario");
$resDesFix = mysql_query("SELECT * FROM receitas_despesas WHERE classe=2 and tipo=2 and usuario = $id_usuario");
//Valores Totais Receitas e Despesas
$recVarTotal = 0; $recFixTotal = 0; $desVarTotal = 0; $desFixTotal = 0;
mysql_close($con);
?>
<html>
<head>
<title>Controle de Finanças Empresarial</title>
<meta charset="utf-8">
</head>
<body>
<b>Lista de RECEITAS - Mês de <?php echo $meses[$mes-1]; ?></b><br><br>
Fixas
<hr width="700px"/>
<table width=700px border=0px>
	<th> Nome </th><th> Data e Hora de Cadastro </th><th> Valor (R$)</th>
<?php
while($linha = mysql_fetch_array($resRecFix,MYSQL_ASSOC))
{
	echo "<tr>";
	echo "<td align='left' width=33%>" . $linha["nome"] . "</td>";
	echo "<td align='center' width=33%>" . $linha["datahora"] . "</td>";
	echo "<td align='right' width=33%>" . $linha["valor"] . "</td>";
	echo "</tr>";
	// Incrementar o valor total
	$recFixTotal = $recFixTotal + $linha["valor"];
}
?>
<tr>
	<td width=33%></td><td align='center' width=33%><b>Total: </b></td>
	<td align='right'><?php echo $recFixTotal; ?>
</tr>
</table><br>
Variáveis
<hr width="700px"/>
<table width=700px border=0px>
	<?php
	while($linha = mysql_fetch_array($resRecVar,MYSQL_ASSOC))
	{
		echo "<tr>";
		echo "<td align='left' width=33%>" . $linha["nome"] . "</td>";
		echo "<td align='center' width=33%>" . $linha["datahora"] . "</td>";
		echo "<td align='right' width=33%>" . $linha["valor"] . "</td>";
		echo "</tr>";
		// Incrementar o valor total
		$recVarTotal = $recVarTotal + $linha["valor"];
	} ?>
	<tr>
		<td width=33%></td><td align='center' width=33%><b>Total: </b></td> 
		<td align='right'><?php echo $recVarTotal; ?>
	</tr>
</table><br/>
<b>Lista de DESPESAS - Mês de <?php echo $meses[$mes-1]; ?></b><br/><br/>
Fixas
<hr width="700px"/>
<table width=700px border=0px>
	<th> Nome </th><th> Data e Hora de Cadastro </th><th> Valor (R$)</th>
	<?php
	while($linha = mysql_fetch_array($resDesFix,MYSQL_ASSOC))
	{
		echo"<tr>";
		echo "<td align='left' width=33%>" . $linha["nome"] . "</td>";
		echo "<td align='center' width=33%>" . $linha["datahora"] . "</td>";
		echo "<td align='right' width=33%>" . $linha["valor"] . "</td>";
		echo "</tr>";
		// Incrementar o valor total
		$desFixTotal = $desFixTotal + $linha["valor"];
	} ?>
	<tr>
		<td width=33%></td><td align='center' width=33%><b>Total: </b></td>
		<td align='right'><?php echo $desFixTotal; ?>
	</tr>
</table><br/>
Variáveis
<hr width="700px"/>
<table width=700px border=0px>
	<?php
	while($linha = mysql_fetch_array($resDesVar,MYSQL_ASSOC))
	{
		echo "<tr>";
		echo "<td align='left' width=33%>" . $linha["nome"] . "</td>";
		echo "<td align='center' width=33%>" . $linha["datahora"] . "</td>";
		echo "<td align='right' width=33%>" . $linha["valor"] . "</td>";
		echo "</tr>";
		// Incrementar o valor total
		$desVarTotal = $desVarTotal + $linha["valor"];
	} ?>
	<tr>
		<td width=33%></td><td align='center' width=33%><b>Total: </b></td>
		<td align='right'><?php echo $desVarTotal; ?>
	</tr>
</table><br/>
<b>SALDO</b>
<hr width="700px"/>
<table width=700px border=0px>
	<tr>
		<td width="50%">Receitas: </td>
		<td align="right" width="50%"><?php echo ($recFixTotal+$recVarTotal) ?></td>
	</tr>
	<tr>
		<td width="50%">Despesas: </td>
		<td align="right" width="50%"><?php echo ($desFixTotal+$desVarTotal) ?></td>
	</tr>
	<tr>
		<td width="50%">Saldo: </td>
		<td align="right" width="50%"><b><?php echo ($recFixTotal+$recVarTotal)-($desFixTotal+$desVarTotal); ?></td>
	</tr>
</table>
</body>
</html>