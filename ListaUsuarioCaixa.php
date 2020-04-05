<?php 
session_start();

include_once 'Model/DAO/AbrirCaixaDAO.php';
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
<title>Lista de Usuario do Caixa</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>
<?php
if (empty($_SESSION)){
?> <script type="text/javascript"> alert("Usuario não logado no sistema"); window.location="index.php"; </script>
<?php	
}

$nivel = $_SESSION['nivel_log'];

if ($nivel !== "2"){
	header("Location: PaginaInicial.php");
} else {
?>
 
<div align="center">
 
<form action="" method="post">
<h2>Informe o nome:</h2>
<input type="text" name="nome" class="input-xxlarge" placeholder="Informe o nome do usuario do caixa">
<input type="submit" value="Pesquisar"  class="btn btn-info">
</form>

<?php 
//Aqui esta a parte onde excluir ou alterar o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
	   	$usuCaixaDAO = new AbrirCaixaDAO();
    	$verificaResult = $usuCaixaDAO->deleteId($id);
    	if ($verificaResult){
        	?> <script type="text/javascript"> alert('Usuário excluido com sucesso'); window.location="ListaUsuarioCaixa.php"</script> <?php 
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o usuario!'); window.location="ListaUsuarioCaixa.php"</script> <?php 
        }			
	} else if ($recebe === "alt") {
		header("Location: AlteraUsuarioCaixa.php?id=" . $id);
	}
}
?>

<?php 
if (!empty($_POST)){
	if (empty($_POST['nome'])){
		$a = 1;
		?><div class="alert alert-error"><font size="3px" color="red"> Campo vazio não permitido! </font></div><br><?php
	} else {
		$recNome = $_POST['nome'];
		$lis = new AbrirCaixaDAO();
		$array = $lis->listaFuncionarioPeloNome($recNome);
		if (!empty($array)){
			?><font size="3px" color="red"> <a href="ListaUsuarioCaixa.php" class="btn btn-info"> Cancelar a pesquisa </a> </font><br><br><?php
		}
	}
} else {
	$lis = new AbrirCaixaDAO();
	$array = $lis->listaCaixa();
}
if (empty($array) && empty($a)){
	?> <div class="alert alert-error">
		<font size="3px" color="red"> Item procurado não encontrado! </font>
	</div> <?php
}
?>

<table class="table table-striped table-hover">
<tr align="center">
<td>Codigo</td>
<td>Nome</td>
<td>Email</td>
<td>CPF</td>
<td>ID</td>
<td>AÃ§Ã£o</td>
</tr>
<?php
if (!empty($array)){
foreach ($array as $lis => $valores){
?>
<tr>
<td><?=$valores["codigoAbrircaixa"] ?></td>
<td><?=$valores["nome"] ?></td>
<td><?=$valores["email"] ?></td>
<td><?=$valores["cpf"] ?></td>
<td><?=$valores["id"] ?></td>
<td><a href="ListaUsuarioCaixa.php?acao=exc&id=<?=$valores["id"]?>"> Remover </a>
<a href="ListaUsuarioCaixa.php?acao=alt&id=<?=$valores["id"]?>"> Alterar </a></td>
</tr>

<?php } } ?>
</table>

<br><a href="PaginaInicial.php"  class="sr-only sr-only-focusable">Voltar ao site</a>

</div>

<?php
}
?>

</body>
</html>