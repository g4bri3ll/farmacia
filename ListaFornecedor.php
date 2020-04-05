<?php 
session_start();

include_once 'Model/DAO/FornecedorDAO.php';
?>
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
<title>Lista de Fornecedor</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php

if (empty($_SESSION)){
	?> <script type="text/javascript"> alert("Usuario n„o logado no sistema!"); window.location="index.php"; </script> <?php	
}
$nivel = $_SESSION['nivel_log'];
if ($nivel == 2){
?>

<?php 
//Aqui esta a parte onde excluir ou alterar o fornecedor
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
	   	$forDAO = new FornecedorDAO();
    	$verificaResult = $forDAO->deleteId($id);
    	if ($verificaResult){
        	?> <script type="text/javascript"> alert('Fornecedor excluido com sucesso!'); window.location="ListaFornecedor.php"</script> <?php 
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o fornecedor!'); window.location="ListaFornecedor.php"</script> <?php 
        }			
	} else if ($recebe === "alt") {
		header("Location: AlteraFornecedor.php?id=" . $id);
	}
}
?>

<div align="center">

<form action="" method="post">
<h2>Informe o nome do fornecedor:</h2>
<input type="text" name="nome" class="input-xxlarge" placeholder="Informe o nome do fornecedor">
<input type="submit" value="Pesquisar" class="btn btn-info span3">
</form>
<?php
if (!empty($_POST)){
	if (empty($_POST['nome'])){
		$a = 1;
		?><div class="alert alert-error"><font size="3px" color="red"> Campo vazio n„o permitido! </font></div><br><?php
	} else {
		$recNome = $_POST['nome'];
		//Colocar os dados em minusculo
		$recNome = strtolower($recNome);
		$lis = new FornecedorDAO();
		$arrayListFornecedor = $lis->listaFornecedoresPeloNome($recNome);
		?><font size="3px" color="red"> <a href="ListaFornecedor.php" class="btn btn-info"> Cancelar a pesquisa </a> </font><br><br><?php
	}
} else {
	$lis = new FornecedorDAO();
	$arrayListFornecedor = $lis->listaFornecedores();
}
if (empty($arrayListFornecedor) && empty($a)){
	?> <div class="alert alert-error"> <font size="3px" color="red"> Item procurado n„o encontrado! </font>	</div> <?php
}
?>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome</td>
<td>Endere√ßo</td>
<td>Cidade</td>
<td>Email</td>
<td>Sexo</td>
<td>Cep</td>
<td>Cnpj</td>
<td>Telefone</td>
<td>AÁ„o</td>
</tr>

<?php 
if (!empty($arrayListFornecedor)){
foreach ($arrayListFornecedor as $lis => $valores){
?>
<tr>
<td><?=$valores["nome"]; ?></td>
<td><?=$valores["endereco"]; ?></td>
<td><?=$valores["cidade"]; ?></td>
<td><?=$valores["email"]; ?></td>
<td><?=$valores["sexo"]; ?></td>
<td><?=$valores["cep"]; ?></td>
<td><?=$valores["cnpj"]; ?></td>
<td><?=$valores["telefone"]; ?></td>
<td>
<a href="ListaFornecedor.php?acao=exc&id=<?=$valores["id"]?>"> Remover </a>
<a href="ListaFornecedor.php?acao=alt&id=<?=$valores["id"]?>"> Alterar </a>
</td>
</tr>

<?php
} }
?>

</table>

<br><a href="PaginaInicial.php"  class="sr-only sr-only-focusable">Voltar ao site</a>

</div>

<?php } ?>

</body>
</html>