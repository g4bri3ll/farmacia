<?php 
session_start();

include_once 'Model/DAO/ProdutoDAO.php';
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
<title>Lista de Produto</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php

if (empty($_SESSION)){
	?> <script type="text/javascript"> alert("Usuario não logado"); window.location="index.php"; </script> <?php	
} else {
$nivel = $_SESSION['nivel_log'];
if ($nivel === "2"){
?>

<?php 
//Aqui esta a parte onde excluir ou alterar o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
	   	$proDAO = new ProdutoDAO();
    	$verificaResult = $proDAO->deleteId($id);
    	if ($verificaResult){
        	?> <script type="text/javascript"> alert('Produto excluido com sucesso'); window.location="ListaProduto.php"</script> <?php 
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o produto!'); window.location="ListaProduto.php"</script> <?php 
        }			
	} else if ($recebe === "alt") {
		header("Location: AlteraProduto.php?id=" . $id);
	}
}
?>

<div align="center">

<form action="" method="post">
<h2>Informe o nome do produto:</h2>
<input type="text" name="nome" class="input-xxlarge" placeholder="Informe o nome do fornecedor">
<input type="submit" value="Pesquisar" class="btn btn-info span2 ">
</form>

<?php
if (!empty($_POST)){
	if (empty($_POST['nome'])){
		$a = 1;
		?><div class="alert alert-error"><font size="3px" color="red"> Campo vazio não permitido! </font></div><br><?php
	} else {
		$recNome = $_POST['nome'];
		//Colocar os dados em minusculo
		$recNome = strtolower($recNome);
		$lis = new ProdutoDAO();
		$array = $lis->listaProdutoPeloNome($recNome);
		?><font size="3px" color="red"> <a href="ListaProduto.php" class="btn btn-info"> Cancelar a pesquisa </a> </font><br><br><?php
	}
} else {
	$lis = new ProdutoDAO();
	$array = $lis->listaProduto();
}
if (empty($array) && empty($a)){
	?> <div class="alert alert-error">
		<font size="3px" color="red"> Item procurado não encontrado! </font>
	</div> <?php
}
?>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome</td>
<td>Marca</td>
<td>Codigo Barra</td>
<td>Codigo do produto</td>
<td>Valor Desconto</td>
<td>Valor do Produto</td>
<td>Qtda</td>
<td>ID</td>
<td>Ação</td>
</tr>
<?php
if (!empty($array)){
foreach ($array as $list => $valores){
?>
<tr>
<td><?=$valores["nome"] ?></td>
<td><?=$valores["marca"] ?></td>
<td><?=$valores["CodBarra"] ?></td>
<td><?=$valores["codigo"] ?></td>
<td><?=$valores["ValorDesconto"] ?></td>
<td><?=$valores["ValorProduto"] ?></td>
<td><?=$valores["qtda"] ?></td>
<td><?=$valores["id"] ?></td>
<td><a href="ListaProduto.php?acao=exc&id=<?=$valores["id"]; ?>"> Remover </a> | 
<a href="ListaProduto.php?acao=alt&id=<?=$valores["id"]; ?>"> Alterar </a></td>
</tr>

<?php } } ?>

</table>

<br><a href="PaginaInicial.php"  class="sr-only sr-only-focusable">Voltar ao site</a>

</div>

<?php } } ?>

</body>
</html>