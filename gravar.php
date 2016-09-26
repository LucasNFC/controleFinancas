<?php
include "valida_sessao.inc";
include "conecta_mysql.inc";
// Obtem o usuario que efetuou o login
$nome_usuario = $_SESSION["nome_usuario"];
// Obtem informacoes digitadas
$t = $_POST['t'];
$nome = $_POST['nome'];
$classe = $_POST['classe'];
$mesRef = $_POST['mesRef'];
$valor = $_POST['valor'];
$descricao = $_POST['descricao'];

// Validacao dos campos nome e valor.
if(empty($nome) or empty($valor)) {
	$erro = 1;
	$msg = "Por favor, preencha todos os campos obrigatórios.";
} elseif ((substr_count($valor , '.')!=1) or (!is_numeric($valor))) {
	$erro = 1;
	$msg = "Digitar o campo valor apenas com números e no formato (xx.xx).";
} else {
	// Tratamento da Descricao
	if (empty($descricao)) {
		$descricao = NULL;
	}
	// Id do usuario que efetuou o login
	$resultado = mysql_query("SELECT id FROM usuarios WHERE login='$nome_usuario'");
	$idUsuario = mysql_result($resultado,0,"id");
	// Data e Hora
	$datahora= date("Y-m-d H:i:s");
	// Formatar o valor para duas casas decimais.
	$valor = number_format($valor, 2, '.', '');
	// Comandos SQL para insercao na base de dados.
	$saldoPesquisa = mysql_query("SELECT saldo FROM controlefinanceiro.usuarios WHERE id=$idUsuario");
	$saldo = mysql_result($saldoPesquisa,0,"saldo");
}
?>
<html>
<head><title>Controle de Finanças Empresarial</title></head>
<body>
<center>
<img src="dinheiro.png">
<h1>Sistema de Controle de Financas Empresarial</h1>
<hr width="700px"/><br/>
<?php
	if ($t==2 and $saldo < $valor) {
		echo "<p>O valor da despesa ultrapassou o seu saldo limite!</p>";
	} else {
		$comandoSQL = "insert into controlefinanceiro.receitas_despesas(nome,tipo,classe,mes_referencia,datahora,valor,usuario,descricao) values ('$nome',$t,$classe,$mesRef,'$datahora',$valor,$idUsuario,'$descricao')";
		$resultado = mysql_query($comandoSQL) or die('Erro fatal durante operação com base de dados');
		echo "<p>Inclusão realizada com sucesso.</p>";
		
		if ($t==2) {
			$saldoDespesa = mysql_query("UPDATE controlefinanceiro.usuarios SET saldo=$saldo-$valor WHERE id=$idUsuario");
		}
	}
	mysql_close($con);
?>
<p><a href="principal.php">Voltar</a></p>
</center>
</body>
</html>
