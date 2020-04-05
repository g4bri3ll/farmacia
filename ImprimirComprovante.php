<!doctype html>
<html lang="pt-BR">
<head>
<link rel="stylesheet" href="CSS/Index.css" />
<link rel="stylesheet" href="boot/css/bootstrap-responsive.css"/>
<link rel="stylesheet" href="boot/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css" />
<link rel="stylesheet" href="boot/css/bootstrap-theme.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap-theme.min.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css" />
<link rel="stylesheet" href="boot/css/bootstrap.css.map"/>
<link rel="stylesheet" href="boot/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/style.css"/>
<title>Imprimir Comprovante</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php
session_start();

include_once '/home/u232560180/public_html/Model/DAO/EmpresaDAO.php';
include_once '/home/u232560180/public_html/Model/DAO/VendasDAO.php';
include_once '/home/u232560180/public_html/Model/DAO/CompraFinalDAO.php';

if (empty($_SESSION)){
?>
	<script type="text/javascript">
	alert("Usuario sem permissão");
	window.location="Index.php";
	</script>
<?php	
} else {
	
	if (!empty($_SESSION['codigoVenda'])){
		
	//Pegar o codigo da venda na session
	$codigoVenda = $_SESSION['codigoVenda'];

	//Dados da empresa
	$empDAO = new EmpresaDAO();
	$arrayEmpresa = $empDAO->lista();

	//Pegando a hora do computador para gravar
	date_default_timezone_set('America/Sao_Paulo');
	$data = date('d/m/y');
	$hora = date('H:i:s');
	
	//lista o valor de cada produto compra, nome, quantidade
	$venDAO = new VendasDAO();
	$arrayVendas = $venDAO->ListaComprovante($codigoVenda);
	
	//Pegar o dinheiro do cliente na session
	$dinheiroCliente = $_SESSION['dinheiro_cliente'];

	//troco do cliente
	$troco = $_SESSION['troco'];
	
	//receber o ultimo valor total da compra
	$compraFinal = new CompraFinalDAO();
	$valorCobrado = $compraFinal->listaPeloCodigo($codigoVenda);
	
?>

<div align="center">
<table border="1">
<tr>
<td><?php echo $data;?></td>
<td><?php echo $hora;?></td>
</tr>
</table>
<table border="1">
<?php
foreach ($arrayEmpresa as $empDAO => $valores){
?>
<tr align="center">
<td><?php echo $valores['nome'];?></td>
</tr>
<tr align="center">
<td><?php echo $valores['cnpj'];?></td>
</tr>
<tr align="center">
<td><?php echo $valores['telefone'];?></td>
</tr>
<?php 
}//fechar o foreach que esta escrevendo os dados da empresa na impressão
?>
</table>
<table border="1">
<tr align="center">
<td>DATA DO RECIBO: </td>
<td><?php echo $data;?></td>
</tr>
</table>
<table border="1">
<?php 
foreach ($arrayVendas as $venDAO => $valores){
?>
<tr>
<td><?php echo $valores['nome'];?></td>
<td><?php echo $valores['qtda'];?></td>
<td><?php echo $valores['valorDesconto'];?></td>
</tr>
<?php }?>
</table> 
<table border="1">
<tr>
<td>Total da Compra:</td>
<td><?php foreach ($valorCobrado as $compraFinal => $valores){ echo $valores['valorCompra']; }?> </td>
</tr>
</table>
<table border="1">
<tr>
<td>Dinheiro Recebido:</td>
<td><?php echo $dinheiroCliente; ?></td>
</tr>
</table>
<table border="1">
<tr>
<td>Troco:</td>
<td><?php echo $troco ?></td>
</tr>
</table>
<br><br>

<?php 
	//Distroi o codigo e o dinheiro da session da session
	unset($_SESSION['codigoVenda']);
	unset($_SESSION['troco']);
	unset($_SESSION['dinheiro_cliente']);
?>

<a href="PaginaInicial.php" class="btn btn-info">Voltar ao site</a>

<?php
} else { 
	header("Location: PaginaInicial.php");
 }
?>
</div>
<?php
}
?>

</body>
</html>