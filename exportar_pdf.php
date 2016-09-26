<?php
include "valida_sessao.inc";
include "conecta_mysql.inc";
// Obtem o usuario que efetuou o login
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


require_once("fpdf/fpdf.php");

$pdf= new FPDF("P","pt","A4");

//Cabecalho
$pdf->AddPage();
$pdf->SetLeftMargin(72);
$pdf->SetRightMargin(72);
$pdf->Ln(10);
$pdf->SetFont('Times','B',18);
$pdf->Cell(0,5,"Sistema de Controle de Finanças Empresarial",0,1,'C');
$pdf->Ln(40);


//Receitas
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,5,"Lista de RECEITAS - Mês de ".$meses[$mes-1],0,1,"C");
$pdf->Ln(20);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,"Fixas",0,1,"C");
$pdf->Ln(10);
$pdf->Cell(0,2,"","T",1,"C");
$pdf->Ln(10);
$pdf->SetFont('Times','B',12);
$pdf->Cell(150,0,"Nome",0,0,"L");
$pdf->Cell(150,0,"Data e Hora de Cadastro",0,0,"C");
$pdf->Cell(150,0,'Valor (R$)',0,1,"R");
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
//Imprime receitas fixas
while($linha = mysql_fetch_array($resRecFix,MYSQL_ASSOC))
{
	if(strlen($linha["nome"])>28){
		$linha["nome"] = substr($linha["nome"], 0,28);
	}
	$pdf->Cell(150,10,$linha["nome"],0,0,"L");
	$pdf->Cell(150,10,$linha["datahora"],0,0,"C");
	$pdf->Cell(150,10,$linha["valor"],0,1,"R");
	// Incrementar o valor total
	$recFixTotal = $recFixTotal + $linha["valor"];
}

$pdf->SetFont('Times','B',12);
$pdf->Ln(10);
$pdf->Cell(150,10,"",0,0,"C");
$pdf->Cell(150,10,"Total:",0,0,"C");
/////////////////////
$pdf->SetFont('Times','',12);
$pdf->Cell(150,10,$recFixTotal,0,0,"R");
$pdf->Ln(30);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,"Variáveis",0,1,"C");
$pdf->Ln(10);
$pdf->Cell(0,2,"","T",1,"C");
$pdf->Ln(6);
//Imprime as receitas variaveis
while($linha = mysql_fetch_array($resRecVar,MYSQL_ASSOC))
	{
		if(strlen($linha["nome"])>28){
			$linha["nome"] = substr($linha["nome"], 0,28);
		}
		$pdf->Cell(150,10,$linha["nome"],0,0,"L");
		$pdf->Cell(150,10,$linha["datahora"],0,0,"C");
		$pdf->Cell(150,10,$linha["valor"],0,1,"R");
		// Incrementar o valor total
		$recVarTotal = $recVarTotal + $linha["valor"];
	}

$pdf->SetFont('Times','B',12);
$pdf->Ln(10);
$pdf->Cell(150,10,"",0,0,"C");
$pdf->Cell(150,10,"Total:",0,0,"C");
/////////////
$pdf->SetFont('Times','',12);
$pdf->Cell(150,10,$recVarTotal,0,0,"R");
$pdf->Ln(50);


//Despesas
$pdf->SetFont('Times','B',12);
$pdf->Cell(0,5,"Lista de DESPESAS - Mês de ".$meses[$mes-1],0,1,"C");
$pdf->Ln(20);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,"Fixas",0,1,"C");
$pdf->Ln(10);
$pdf->Cell(0,2,"","T",1,"C");
$pdf->Ln(10);
$pdf->SetFont('Times','B',12);
$pdf->Cell(150,0,"Nome",0,0,"L");
$pdf->Cell(150,0,"Data e Hora de Cadastro",0,0,"C");
$pdf->Cell(150,0,'Valor (R$)',0,1,"R");
$pdf->Ln(10);
$pdf->SetFont('Times','',12);
//Imprime despesas fixas
while($linha = mysql_fetch_array($resDesFix,MYSQL_ASSOC))
	{	
		if(strlen($linha["nome"])>28){
			$linha["nome"] = substr($linha["nome"], 0,28);
		}
		$pdf->Cell(150,10,$linha["nome"],0,0,"L");
		$pdf->Cell(150,10,$linha["datahora"],0,0,"C");
		$pdf->Cell(150,10,$linha["valor"],0,1,"R");
		// Incrementar o valor total
		$desFixTotal = $desFixTotal + $linha["valor"];
	}
$pdf->SetFont('Times','B',12);
$pdf->Ln(10);
$pdf->Cell(150,10,"",0,0,"C");
$pdf->Cell(150,10,"Total:",0,0,"C");
$pdf->SetFont('Times','',12);
$pdf->Cell(150,10,$desFixTotal,0,0,"R");
$pdf->Ln(30);

$pdf->SetFont('Times','',12);
$pdf->Cell(0,5,"Variáveis",0,1,"C");
$pdf->Ln(10);
$pdf->Cell(0,2,"","T",1,"C");
$pdf->Ln(6);
//Imprime despesas variaveis
while($linha = mysql_fetch_array($resDesVar,MYSQL_ASSOC))
	{
		if(strlen($linha["nome"])>28){
			$linha["nome"] = substr($linha["nome"], 0,28);
		}
		$pdf->Cell(150,10,$linha["nome"],0,0,"L");
		$pdf->Cell(150,10,$linha["datahora"],0,0,"C");
		$pdf->Cell(150,10,$linha["valor"],0,1,"R");
		// Incrementar o valor total
		$desVarTotal = $desVarTotal + $linha["valor"];
	}
$pdf->SetFont('Times','B',12);
$pdf->Ln(10);
$pdf->Cell(150,10,"",0,0,"C");
$pdf->Cell(150,10,"Total:",0,0,"C");
/////////////
$pdf->SetFont('Times','',12);
$pdf->Cell(150,10,$desVarTotal,0,0,"R");
$pdf->Ln(50);


///Saldo
$pdf->SetFont('Times',"B",12);
$pdf->Cell(0,10,"SALDO",0,1,"C");
$pdf->Ln(7);
$pdf->SetFont('Times','',12);
$pdf->Cell(0,2,"","T",1,"C");
$pdf->Ln(8);
$pdf->Cell(300,15,"Receitas:",0,0,"L");
$pdf->Cell(150,15,$recFixTotal+$recVarTotal,0,1,"R");
$pdf->Cell(300,15,"Despesas:",0,0,"L");
$pdf->Cell(150,15,$desFixTotal+$desVarTotal,0,1,"R");
$pdf->Cell(300,15,"Saldo:",0,0,"L");
$pdf->SetFont('Times','B',12);
$pdf->Cell(150,15,($recFixTotal+$recVarTotal)-($desFixTotal+$desVarTotal),0,1,"R");


$pdf->Output("receitas_despesas".$meses[$mes-1].".pdf","D");
?>