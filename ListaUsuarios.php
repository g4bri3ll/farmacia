<?php
session_start();

include_once 'Model/Modelo/Usuario.php';
include_once 'Model/DAO/UsuarioDAO.php';
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
<title>Lista de Usuario</title>
<?php header("Content-Type: text/html; charset=ISO-8859-1",true);?>
</head>
<body>
<script src="boot/js/bootstrap.js" type="text/javascript" ></script>
<script src="boot/js/bootstrap.min.js" type="text/javascript" ></script>
<script src="boot/js/npm.js" type="text/javascript" ></script>

<div align="center">
<?php
if (empty($_SESSION)){
?>
	<script type="text/javascript">
	alert("Usuario sem permiss„o");
	window.location="index.php";
	</script>
<?php	
} else {
?> 
<form action="" method="post">
<label> Informe o nome: </label>
<input type="text" name="nome" class="input-xxlarge" placeholder="Informe o nome do usuario">
<input type="submit" value="Pesquisar" class="btn btn-info">
</form>

<?php 
//Aqui esta a parte onde excluir ou alterar o usuario
if (!empty($_GET['id']) || !empty($_GET['acao'])){
	$recebe = $_GET['acao'];
	$id = $_GET['id'];
	if ($recebe === "exc"){
	   	$usuDAO = new UsuarioDAO();
    	$verificaResult = $usuDAO->deleteId($id);
    	if ($verificaResult){
        	?> <script type="text/javascript"> alert('Usu·rio excluido com sucesso'); window.location="ListaUsuarios.php"</script> <?php 
        } else {
        	?> <script type="text/javascript"> alert('Erro ao excluir o usuario!'); window.location="ListaUsuarios.php"</script> <?php 
        }			
	} else if ($recebe === "alt") {
		header("Location: AlteraUsuario.php?id=" . $id);
	}
}
?>

<?php
	$nivel = $_SESSION['nivel_log'];
	//Verifica o nivel do usuario logado
	if ($nivel == 2){
		//Verifica se existe o post
		if (!empty($_POST)){
			if (!empty($_POST['nome'])){
				$nome = $_POST['nome'];
				//Colocar os dados em minusculo
				$nome = strtolower($nome);
				$lis = new UsuarioDAO();
				$arrayUsuario = $lis->listaUsuarioPeloNome($nome);
				?><font size="3px" color="red"> <a href="ListaUsuarios.php" class="btn btn-info"> Cancelar a pesquisa </a> </font><br><br><?php
			} else {
				$a = 1;
				?><div class="alert alert-error"><font size="3px" color="red"> Campo vazio n„o permitido! </font></div><br><?php
			}
		} else {
			$lis = new UsuarioDAO();
			$arrayUsuario = $lis->listaUsuario();
		}
		if (empty($arrayUsuario) && empty($a)){
			?> <div class="alert alert-error">
				<font size="3px" color="red"> Item procurado n„o encontrado! </font>
			</div> <?php
		}
?>

<table class="table table-striped table-hover">
<tr align="center">
<td>Nome</td>
<td>Endere√ßo</td>
<td>Cidade</td>
<td>Complemento</td>
<td>Login</td>
<td>Email</td>
<td>Nivel login</td>
<td>Sexo</td>
<td>Cep</td>
<td>CPF</td>
<td>Telefone</td>
<td>A√ß√£o</td>
</tr>

<?php
if (!empty($arrayUsuario)){
foreach ($arrayUsuario as $list => $valores){
?>

<tr>
<td><?php echo $valores["nome"] ?></td>
<td><?php echo $valores["endereco"] ?></td>
<td><?php echo $valores["cidade"] ?></td>
<td><?php echo $valores["complemento"] ?></td>
<td><?php echo $valores["login"] ?></td>
<td><?php echo $valores["email"] ?></td>
<td><?php echo $valores["nivel_log"] ?></td>
<td><?php echo $valores["sexo"] ?></td>
<td><?php echo $valores["cep"] ?></td>
<td><?php echo $valores["cpf"] ?></td>
<td><?php echo $valores["telefone"] ?></td>
<td><a href="ListaUsuarios.php?acao=exc&id=<?php echo $valores["id"]?>"> Remover </a>
<a href="ListaUsuarios.php?acao=alt&id=<?php echo $valores["id"]?>"> Alterar </a></td>
</tr>
<?php } } ?>
</table>

<br> <a href="PaginaInicial.php"  class="sr-only sr-only-focusable">Voltar ao site</a>

</div>

<?php
	} else {
		header("Location: index.php");
	}
}
?>

</body>
</html>